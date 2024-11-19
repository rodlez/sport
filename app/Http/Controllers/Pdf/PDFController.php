<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Workout\Workout;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    
    public function generatePDF(Workout $data)
    {
        $dataToPdf = clone $data;
        $dataToPdf = $dataToPdf->toArray();

        $dataToPdf["date"] = date_format($data->created_at, 'd-m-Y'); 
        $dataToPdf["user_name"] = Auth::user()->name;
        $dataToPdf["type_name"] = $data->type->name;
        $dataToPdf["level_name"] = $data->level->name;

        /* Get the attached files */
        $files = $data->files;
        
        if ($files != null && $files != '[]')
        {
            $dataToPdf["files"] = [];
            foreach ($files as $key => $file)
            {
                $dataToPdf["files"][$key] = $file->toArray();
            }
        } 
        //dd($dataToPdf);
        $pdf = PDF::loadView('pdf.myPDF', $dataToPdf);
        
        $documentName = 'workout_' . $data->id . '.pdf';

        return $pdf->download($documentName);
       
    }
}
