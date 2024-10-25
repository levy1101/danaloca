<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddPosts extends Component
{
    public function render()
    {
        $locations = DB::table('locations')->orderBy('id', 'desc')->get();
        return view('livewire.add-posts')->with('locations', $locations);
    }
}
