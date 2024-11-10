<?php

namespace App\Livewire\Sport;

use App\Models\Sport\Sport;
use App\Models\Sport\SportTag;
use App\Services\SportService;
use Livewire\Component;

class SportShow extends Component
{
    // Dependency Injection to use the Service
    /* protected SportService $sportService; */
    
    public Sport $sport;

    public function mount(Sport $sport)
    {
        $this->sport = $sport;
    }

   /*  public function boot(
        SportService $sportService,
    ) {
        $this->sportService = $sportService;
    } */
    
    public function render()
    {
        //$tags = $this->sportService->displayEntryTags($this->sport, '');

        // Without using SportService       
        
        return view('livewire.sport.sport-show', [
            'sport' => $this->sport,
            'tags' => $this->sport->tags,
            'workouts' => $this->sport->workouts,
        ])->layout('layouts.app');
    }
    
}
