<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Location;
use App\Models\Post;
use App\Models\Bookmark;
use Illuminate\Support\Facades\DB;

class FetchBookmarks extends Component
{
    public function fetch_bookmarks($user_id)
    {
        $locations = Location::with('posts')->get();
        $posts = Post::with('user', 'locations','marks')->join('locations', 'locations.id', '=', 'posts.location_id')->join('users', 'users.id', '=', 'posts.user_id')->join('bookmarks', 'bookmarks.user_id', '=', 'users.id')->get(['locations.location_status','locations.location_name', 'users.name', 'posts.*']);
        $user = DB::table('users')->where('id', $user_id)->get();
        $bookmarks = Bookmark::with('post')->join('users', 'users.id', '=', 'bookmarks.user_id')->get();
        // dd($bookmarks);
        return view('livewire.fetch-bookmarks')->with('locations', $locations)->with('posts', $posts)->with('user', $user)->with('bookmarks',$bookmarks);
    }
}
