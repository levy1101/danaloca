<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FetchLocations extends Component
{
    public function fetch_locations($location_id)
    {
        $locations = DB::table('locations')->where('id', $location_id)->get();
        $posts = Post::with('user', 'locations')->join('locations', 'locations.id', '=', 'posts.location_id')->join('users', 'users.id', '=', 'posts.user_id')->get(['locations.location_status','locations.location_name', 'users.name', 'posts.*']);
        $user = User::with('posts')->get();
        return view('livewire.fetch-locations')->with('locations', $locations)->with('posts', $posts)->with('user', $user);
    }
}
