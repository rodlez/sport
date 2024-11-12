<?php

namespace App\Livewire\Sport;

use App\Models\Sport\Sport;
use App\Models\Sport\SportTag;
use App\Services\SportService;
use App\Services\WorkoutService;
use Livewire\Component;

class SportShow extends Component
{
    public Sport $sport;

    public $showVideos = false;

    // Dependency Injection to use the Service
    protected WorkoutService $workoutService;

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(WorkoutService $workoutService)
    {
        $this->workoutService = $workoutService;
    }

    public function mount(Sport $sport)
    {
        $this->sport = $sport;
    }

    public function render()
    {
        $playlist       = $this->workoutService->getSportPlaylist($this->sport);        
        $videos         = $this->workoutService->getSportVideoPaths($this->sport);
        $totalVideos    = $this->workoutService->getVideosTotal($videos);

        return view('livewire.sport.sport-show', [
            'sport'         => $this->sport,
            'tags'          => $this->sport->tags,
            'workouts'      => $this->sport->workouts,
            'playlist'      => $playlist,
            'videos'        => $videos,
            'totalVideos'   => $totalVideos,
        ])->layout('layouts.app');
    }
}
