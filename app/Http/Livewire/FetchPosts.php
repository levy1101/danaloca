<?php

namespace App\Http\Livewire;

use App\Models\Bookmark;
use Livewire\Component;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;

class FetchPosts extends Component
{
    public function render()
    {
        $locations = Location::with('posts')->get();
        $posts = Post::with('user', 'locations')->join('locations', 'locations.id', '=', 'posts.location_id')->join('users', 'users.id', '=', 'posts.user_id')->get(['locations.location_status', 'locations.location_name', 'users.name', 'posts.*']);
        $user = User::with('posts')->get();
        return view('livewire.fetch-posts')->with('locations', $locations)->with('posts', $posts)->with('user', $user);
    }
    public function addLikeToPost($post_id)
    {
        $user_id = auth()->id();
        $checkLiked = Like::where('user_id', $user_id)->where('post_id', $post_id)->first();
        if ($checkLiked) {
            Like::where('user_id', $user_id)->where('post_id', $post_id)->delete();
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post_id
            ]);
        }
    }
    public function addBookmarkToPost($post_id)
    {
        $user_id = auth()->id();
        $checkMarked = Bookmark::where('user_id', $user_id)->where('post_id', $post_id)->first();
        if ($checkMarked) {
            Bookmark::where('user_id', $user_id)->where('post_id', $post_id)->delete();
        } else {
            Bookmark::create([
                'user_id' => auth()->id(),
                'post_id' => $post_id
            ]);
        }
    }
}
