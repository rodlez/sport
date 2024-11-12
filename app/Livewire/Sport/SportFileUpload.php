<?php

namespace App\Livewire\Sport;

use App\Models\Sport\Sport;
use App\Models\Sport\SportFile;
use App\Services\SportService;
use Livewire\Component;
use Livewire\WithFileUploads;

class SportFileUpload extends Component
{
    use WithFileUploads;
    
    public Sport $sport;

    public $files = [];

    // Dependency Injection to use the Service
    protected SportService $sportService;

    protected $rules = [
        'files' => 'array|min:1|max:5',
        //'files.*' => 'required|mimes:pdf,jpeg,png,jpg|max:2048',
        'files.*' => 'required|file|mimetypes:text/plain,application/pdf,image/jpeg,image/png,application/vnd.oasis.opendocument.text,application/vnd.openxmlformats-officedocument.wordprocessingml.document,video/mp4|max:1024000',
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
        SportService $sportService,
    ) {
        $this->sportService = $sportService;
    }

    public function mount(Sport $sport)
    {
        $this->sport = $sport;
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
            $storagePath = 'sportfiles/' . $file->getClientOriginalExtension();
            $data = $this->sportService->uploadFile($file, $this->sport, 'public', $storagePath);
            
            SportFile::create($data);            
        }

        return to_route('sports.show', $this->sport)->with('message', 'File(s) for (' . $this->sport->title . ') successfully uploaded.');
    }

    public function render()
    {
        return view('livewire.sport.sport-file-upload', [
            'sport' => $this->sport
        ])->layout('layouts.app');
    }
    
    
}