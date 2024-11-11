<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Models\Sport\Sport;
use App\Models\Sport\SportFile;
use App\Services\SportService;
use Illuminate\Http\Request;

class SportFileController extends Controller
{
    public function __construct(private SportService $sportService) {        
    }
    
    public function download(Sport $sport, SportFile $file)
    {
        return $this->sportService->downloadFile($file, 'attachment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport, SportFile $file)
    {          
        $this->sportService->deleteOneFile($file);
        
        return back()->with('message', 'File ' . $file->original_filename . ' from Sport: ' . $sport->title . ' deleted.');
    }
}
