<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddPosts extends Component
{
    use WithFileUploads;

    public $post_content;
    public $post_image;
    public $location;

    protected $rules = [
        'post_content' => 'required|string|max:255',
        'post_image' => 'nullable|image|max:1024',
        'location' => 'required|exists:locations,id',
    ];

    public function submitPost()
    {
        $this->validate();

        $post = new Post();
        $post->post_content = $this->post_content;
        $post->post_status = '1';
        $post->location_id = $this->location;
        $post->user_id = Auth::id();

        if ($this->post_image) {
            $imageName = $this->post_image->getClientOriginalName();
            $this->post_image->storeAs('upload/post', $imageName);
            $post->post_image = $imageName;
        }

        $post->save();

        session()->flash('message', 'Thêm bài viết thành công');

        $this->reset(['post_content', 'post_image', 'location']);
    }

    public function render()
    {
        $locations = DB::table('locations')->orderBy('id', 'desc')->get();
        return view('livewire.add-posts')->with('locations', $locations);
    }
}