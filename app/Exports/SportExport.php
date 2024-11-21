<?php

namespace App\Exports;

use App\Models\Sport\Sport;
use App\Services\SportService;

use Excel;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// styles
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SportExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithEvents
{
    private $exportAll;
    private $listIds;

    // Dependency Injection SportService
    private SportService $sportService;

    public function __construct(bool $exportAll, array $listIds, SportService $sportService)
    {
        $this->exportAll = $exportAll;
        $this->listIds = $listIds;
        $this->sportService = $sportService;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {      
        // To select the columns in the DB that we want to export
        if ($this->exportAll) {
            return Sport::select('id', 'user_id', 'category_id', 'status', 'title', 'date', 'location', 'duration', 'distance', 'url', 'info', 'created_at', 'updated_at')
                    ->get();
        } else {
            return Sport::select('id', 'user_id', 'category_id', 'status', 'title', 'date', 'location', 'duration', 'distance', 'url', 'info', 'created_at', 'updated_at')
                ->get()
                ->whereIn('id', $this->listIds);
        }
    }

    public function map($sport): array
    {
        // To work with the columns selected in the collection method
        
        $workouts = implode("\n", $this->sportService->getSportWorkoutsTitles($sport));

        $tags = implode("\n", $this->sportService->getSportTagsNames($sport));

        $files = $sport->files->count();        

        $urls = implode("\n\n", json_decode($sport->url));       

        return [$sport->id, $sport->user->name, $sport->status, $sport->title, $sport->date, $sport->category->name, $tags, $workouts, $sport->location, $sport->duration, $sport->distance, $urls, $sport->info, $files, date_format($sport->created_at, 'd-m-Y'), date_format($sport->updated_at, 'd-m-Y')];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ['ID', 'USER', 'STATUS', 'TITLE', 'DATA', 'CATEGORY', 'TAGS', 'WORKOUTS', 'LOCATION', 'DURATION', 'DISTANCE', 'URLS', 'INFO', 'FILES', 'CREATED', 'UPDATED'];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Check if selection or All to establish the number of rows on the Excel file
                $this->exportAll ? ($totalRows = Sport::get()->count()) : ($totalRows = count($this->listIds));

                // Default Row height and width
                $event->sheet->getRowDimension('1')->setRowHeight(50);
                $event->sheet->getDefaultColumnDimension()->setWidth(20);

                // Except for Title and Files
                $event->sheet->getColumnDimension('A')->setWidth(10);
                $event->sheet->getColumnDimension('C')->setWidth(10);
                $event->sheet->getColumnDimension('J')->setWidth(10);
                $event->sheet->getColumnDimension('K')->setWidth(10);
                $event->sheet->getColumnDimension('N')->setWidth(10);

                $event->sheet->getColumnDimension('D')->setWidth(50);
                $event->sheet->getColumnDimension('H')->setWidth(50);
                $event->sheet->getColumnDimension('L')->setWidth(50);
                $event->sheet->getColumnDimension('M')->setWidth(50);

                //$event->sheet->getColumnDimension('J')->setVisible(false);
                //$event->sheet->getColumnDimension('H')->setVisible(false);

                $event->sheet
                    ->getStyle('A2:K' . $totalRows + 1)
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setWrapText(true);

                $event->sheet
                    ->getStyle('E2:E' . $totalRows + 1)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                $event->sheet
                    ->getStyle('I2:I' . $totalRows + 1)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                $event->sheet
                    ->getStyle('J2:K' . $totalRows + 1)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(false);

                // Loop through each row and apply conditional formatting
                for ($row = 2; $row <= $totalRows + 1; $row++) {
                    
                    $cellStatus     = $event->sheet->getCell('C' . $row)->getValue();
                    $cellWorkouts   = $event->sheet->getCell('H' . $row)->getValue();
                    $cellDistance   = $event->sheet->getCell('K' . $row)->getValue();

                    // STATUS
                    if ($cellStatus == 1) {
                        $event->sheet
                            ->getStyle('C' . $row)
                            ->getFont()
                            ->getColor()
                            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                    } else {
                        $event->sheet
                            ->getStyle('C' . $row)
                            ->getFont()
                            ->getColor()
                            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);

                        $event->sheet->setCellValue('C' . $row, '0');
                    }
                    // WORKOUTS
                    if ($cellWorkouts == 0) {
                        $event->sheet
                            ->getStyle('H' . $row)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('e5e7eb');
                    }
                    // DISTANCE
                    if (empty($cellDistance)) {
                        $event->sheet
                            ->getStyle('K' . $row)
                            ->getFont()
                            ->getColor()
                            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

                        $event->sheet->setCellValue('K' . $row, '0');
                    }
                    
                    /* if ($cellValueCat == 'PHP') {
                        $event->sheet
                            ->getStyle('D' . $row)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('7c3aed');
                    } */
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $totalRows = count($this->listIds);
        return [
            // Style the first row as bold text.
            1 => [
                'font' => [
                    'name' => 'Arial',
                    'bold' => true,
                    'italic' => false,
                    'strikethrough' => false,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => '16a34a',
                    ],
                    'endColor' => [
                        'argb' => '16a34a',
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => false,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                    'top' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                    'left' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                    'right' => [
                        'borderStyle' => Border::BORDER_THICK,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ],
                ],
            ],
            /* 'A2:K' . $totalRows + 1 => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    'wrapText' => false,
                ],
            ], */
        ];
    }
}
