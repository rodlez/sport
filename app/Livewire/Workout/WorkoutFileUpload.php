<?php

namespace App\Livewire\Workout;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Workout\Workout;
use App\Models\Workout\WorkoutFile;
use App\Services\WorkoutService;


class WorkoutFileUpload extends Component
{
    use WithFileUploads;
    
    public Workout $workout;

    public $files = [];

    // Dependency Injection to use the Service
    protected WorkoutService $workoutService;

    protected $rules = [
        'files' => 'array|min:1|max:5',
        //'files.*' => 'required|mimes:pdf,jpeg,png,jpg|max:2048',
        'files.*' => 'required|file|mimetypes:text/plain,application/pdf,image/jpeg,image/png,application/vnd.oasis.opendocument.text,application/vnd.openxmlformats-officedocument.wordprocessingml.document,video/mp4|max:102400',
    ];

    protected $messages = [
        'files.min' => 'Select at least 1 file to upload (max 5 files)',
        'files.max' => 'Limited to 5 files to upload',
        'files.*.required' => 'Select at least one file to upload',
        //'files.*.mimes' => 'At least one file is not one of the allowed formats: PDF, JPG, JPEG or PNG',
        'files.*.mimetypes' => 'At least one file do not belong to the allowed formats: PDF, JPG, JPEG, PNG, TXT, DOC, ODT'
    ];

    // Hook Runs on every request, immediately after the component is instantiated, but before any other lifecycle methods are called
    public function boot(
        WorkoutService $workoutService,
    ) {
        $this->workoutService = $workoutService;
    }

    public function mount(Workout $workout)
    {
        $this->workout = $workout;
    }

    public function deleteFile($position)
    {
        array_splice($this->files, $position, 1);
    }

    public function save()
    {
        //dd($this->files);
        
        $this->validate();

        //dd($this->validate());

        foreach ($this->files as $file) {
            $storagePath = 'workoutfiles/' . $file->getClientOriginalExtension();
            $data = $this->workoutService->uploadFile($file, $this->workout, 'public', $storagePath);
            
            WorkoutFile::create($data);            
        }

        return to_route('workouts.show', $this->workout)->with('message', 'File(s) for (' . $this->workout->title . ') successfully uploaded.');
    }

    public function render()
    {
        return view('livewire.workout.workout-file-upload', [
            'workout' => $this->workout
        ])->layout('layouts.app');
    }
}
