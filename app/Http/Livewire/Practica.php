<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;


class Practica extends Component
{
    public $search;
    
    protected $queryString = ['search'];

    public function render()
    {
        return view('livewire.practica',[
            'users' => User::where('name', 'like', '%'.$this->search.'%')->get(),
        ]);
    }
}
