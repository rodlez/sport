<?php

namespace App\Http\Controllers\Pdf;

use App\Models\Sport\Sport;
use App\Models\Workout\Workout;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{

    public function generateSportPDF(Sport $data)
    {
        $dataToPdf = clone $data;
        $dataToPdf = $dataToPdf->toArray();

        // Convert the string to a DateTime object
        $dateTime = DateTime::createFromFormat('Y-d-m', $data->date);
        $dataToPdf["date"] = date_format($dateTime, 'd-m-Y');
        
        ($data->status == 0 ?  $dataToPdf["status"] = 'Complete' :  $dataToPdf["status"]  = 'Pending');
        
        $dataToPdf["user_name"] = $data->user->name;
        $dataToPdf["category_name"] = $data->category->name;
        
        $dataToPdf["tags"] = $data->tags->toArray();

        if ($data->workouts != null && $data->workouts != '[]')
        {
            $dataToPdf["workouts"] = $data->workouts->toArray();
        }

        // URL decode JSON 
        if ($data->url != null && $data->url != '[]')
        {
            $dataToPdf["urls"] = [];
                    foreach (json_decode($data->url) as $key => $url)
                    {
                        $dataToPdf["urls"][$key] = $url;
                    }
        }       

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
        
        $pdf = PDF::loadView('pdf.sportPDF', $dataToPdf);
        
        $documentName = 'sport_' . $data->id . '.pdf';

        return $pdf->download($documentName);
       
    }
    
    public function generateWorkoutPDF(Workout $data)
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
        $pdf = PDF::loadView('pdf.workoutPDF', $dataToPdf);
        
        $documentName = 'workout_' . $data->id . '.pdf';

        return $pdf->download($documentName);
       
    }
}
