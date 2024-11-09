<?php

namespace App\Livewire\Sport;

use App\Models\Sport\SportTag;
use Livewire\Component;

class SportTagsShow extends Component
{
    public SportTag $tag;

    public function mount(SportTag $tag)
    {
        $this->tag = $tag;
    }
    
    public function render()
    {
        return view('livewire.sport.sport-tags-show', [
            'tag' => $this->tag
        ])->layout('layouts.app');
    }   

    
}
