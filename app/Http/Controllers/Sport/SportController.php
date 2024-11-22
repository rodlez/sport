<?php

namespace App\Http\Controllers\Sport;


use App\Http\Controllers\Controller;
use App\Models\Sport\Sport;
use App\Services\SportService;
// Auth
use Illuminate\Support\Facades\Auth;
// Excel Export
use App\Exports\SportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SportController extends Controller
{
    public function __construct(private SportService $sportService) {        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {              
         // resticted access - only user who owns the Sport has access
         if ($sport->user_id !== Auth::id()) {
            abort(403);
        }   

        $result = $this->sportService->deleteSport($sport);

        return to_route('sports.index')->with('message', $result);
       
    }

    /**
     * Export the collection as excel file
     */
    public function exportAll() 
    {        
        //$totalEntries = $this->codeService->totalEntries();

        $totalEntries = Sport::get()->where('user_id', Auth::id())->count();
        $excelFileName = 'AllSports('. $totalEntries .').xlsx';

        return Excel::download(new SportExport(true, [], $this->sportService), $excelFileName);
    }

     /**
     * Export the collection as excel file
     */
    public function exportSelected(Request $request) 
    {   
        // listEntries is a string, remove [ ] from start and end of the string
        $stringListEntries = substr($request->listEntries, 1, -1);

        // convert string to array of Ids
        $listIds = explode(',',$stringListEntries);
        $excelFileName = 'SelectionSports('. count($listIds) .').xlsx';                
        
        return Excel::download(new SportExport(false, $listIds, $this->sportService),  $excelFileName);
    }

    /**
     * Export the collection as excel file
     */
    public function exportBulk(Request $request) 
    {                
        // convert string to array of Ids
        $listIds = explode(',',$request->listEntriesBulk);        
        $excelFileName = 'BulkSports('. count($listIds) .').xlsx';

        return Excel::download(new SportExport(false, $listIds, $this->sportService), $excelFileName);
    }
}
