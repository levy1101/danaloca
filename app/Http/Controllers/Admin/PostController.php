<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use App\Models\Comment;

// session_start();

class PostController extends Controller
{
    public function all_post()
    {
        // $posts = DB::table('posts')->orderBy('posts.id', 'desc')->get();
        // dd($posts);
        $locations = Location::with('posts')->get();
        $posts = Post::with('user', 'locations')->join('locations', 'locations.id', '=', 'posts.location_id')->join('users', 'users.id', '=', 'posts.user_id')->get(['locations.location_status','locations.location_name', 'users.name', 'posts.*']);
        $user = User::with('posts')->get();
        $manager_post = view('admin.all_post')->with('locations', $locations)->with('posts', $posts)->with('user', $user);
        return view('layouts.admin')->with('admin.all_post', $manager_post);
    }
    public function add_post()
    {
        $locations = DB::table('locations')->orderBy('locations.id', 'desc')->get();
        return view('admin.add_post')->with('locations', $locations);
    }
    public function save_post(Request $request)
    {

        $data = array();
        $data['post_content'] = $request->post_content;
        $data['post_status'] = $request->post_status;
        $data['location_id'] = $request->location;
        $data['user_id'] = '1';
        
        $get_image = $request->file('post_image');
        if($get_image){
            $get_image_name = $get_image->getClientOriginalName();
            $image_name = current(explode('.',$get_image_name));
            $new_image = $image_name.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/post',$new_image);
            $data['post_image'] = $new_image;
            DB::table('posts')->insert($data);
            Session::put('message', 'Thêm bài viết thành công');
            return Redirect::to('/admin/add_post');
        }
        $data['post_image'] = '';
        DB::table('posts')->insert($data);
        Session::put('message', 'Thêm bài viết thành công');
        return Redirect::to('/admin/add_post');
    }
    public function edit_post($post_id)
    {
        $location = DB::table('locations')->orderBy('id', 'desc')->get();
        $edit_post = DB::table('posts')->where('id', $post_id)->get();
        $manager_post = view('admin.edit_post')->with('edit_post', $edit_post)->with('location',$location);
        // dd($edit_post);
        return view('layouts.admin')->with('admin.edit_post', $manager_post);

    }
    public function update_post(Request $request, $post_id)
    {
        $data = array();
        $data['post_content'] = $request->post_content;
        $data['post_status'] = $request->post_status;
        $data['location_id'] = $request->location;
        $get_image = $request->file('post_image');
        if($get_image){
            $get_image_name = $get_image->getClientOriginalName();
            $image_name = current(explode('.',$get_image_name));
            $new_image = $image_name.rand(0,999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('upload/post/',$new_image);
            $data['post_image'] = $new_image;
            DB::table('posts')->where('id',$post_id)->update($data);
            Session::put('message', 'Cập nhật bài viết thành công');
            return Redirect::to('/admin/all_post');
        }
        
        DB::table('posts')->where('posts.id',$post_id)->update($data);
        Session::put('message', 'Cập nhật bài viết thành công');
        return Redirect::to('/admin/all_post');
    }
    public function delete_post($post_id)
    {
        Comment::where('post_id', '=', $post_id)->delete();
        Post::where('id', '=', $post_id)->delete();
        return redirect()->back()->with('message', 'Xoá bài viết thành công');
    }
}
