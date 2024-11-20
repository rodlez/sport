<?php

namespace App\Http\Controllers\Sport;

use App\Http\Controllers\Controller;
use App\Models\Sport\Sport;
use App\Services\SportService;
use Exception;
use Illuminate\Support\Facades\Auth;

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
}
