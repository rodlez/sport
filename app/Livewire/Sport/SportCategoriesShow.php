<?php

namespace App\Livewire\Sport;

use App\Models\Sport\SportCategory;
use Livewire\Component;

class SportCategoriesShow extends Component
{
    public SportCategory $category;

    public function mount(SportCategory $category)
    {
        $this->category = $category;
    }
    
    public function render()
    {
        return view('livewire.sport.sport-categories-show', [
            'category' => $this->category
        ])->layout('layouts.app');
    }    
   
}
