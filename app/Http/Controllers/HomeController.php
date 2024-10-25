<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

session_start();

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function welcome()
    {
        return view('welcome');
    }
    public function adminHome()
    {
        return view('admin.home');
    }
    public function index()
    {
        $locations = Location::with('posts')->get();
        $posts = Post::with('user', 'locations')->join('locations', 'locations.id', '=', 'posts.location_id')->join('users', 'users.id', '=', 'posts.user_id')->get(['locations.location_status','locations.location_name', 'users.name', 'posts.*']);
        $user = User::with('posts')->get();
        return view('user.home')->with('locations', $locations)->with('posts', $posts)->with('user', $user);
    }
    public function myProfile()
    {
        $posts = Post::all()->sortbyDesc('id');
        return view('user.my_profile')->with('posts', $posts);
    }
    public function data()
    {
        $locations = Location::with('posts')->get();
        $posts = Post::with('user', 'locations')->join('locations', 'locations.id', '=', 'posts.location_id')->join('users', 'users.id', '=', 'posts.user_id')->get(['locations.location_status','locations.location_name', 'users.name', 'posts.*']);
        $user = User::with('posts')->get();
        return view('user.data')->with('locations', $locations)->with('posts', $posts)->with('user', $user);
    }
    public function user_profile($user_id){
        // $user = DB::table('users')->where('id', $user_id)->get();
        $user = User::with('posts')->where('id', $user_id)->first();
        // dd($user->avatar);
        $locations = Location::with('posts')->get();
        $posts = Post::with('user', 'locations')->join('locations', 'locations.id', '=', 'posts.location_id')->join('users', 'users.id', '=', 'posts.user_id')->get(['locations.location_status','locations.location_name', 'users.name', 'posts.*']);
        return view('user.profile')->with('user', $user)->with('locations', $locations)->with('posts', $posts);
    }
}
