<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Models\Sport\Sport;
use App\Models\Sport\SportFile;
use App\Services\FileService;
use Illuminate\Http\Request;

class SportFileController extends Controller
{
    public function __construct(private FileService $fileService) {        
    }
    
    public function download(Sport $sport, SportFile $file)
    {
        return $this->fileService->downloadFile($file, 'attachment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport, SportFile $file)
    {          
        $this->fileService->deleteOneFile($file);
        
        return back()->with('message', 'File ' . $file->original_filename . ' from Sport: ' . $sport->title . ' deleted.');
    }
}
