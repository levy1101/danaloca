<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// đăng xuất
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Auth::routes();
Route::group(['prefix' => 'admin'], function () {
    // danh mục bài viết
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
    Route::get('/add_location', [App\Http\Controllers\Admin\LocationController::class, 'add_location'])->middleware('is_admin');
    Route::get('/all_location', [App\Http\Controllers\Admin\LocationController::class, 'all_location'])->name('all_location')->middleware('is_admin');
    Route::post('/save_location', [App\Http\Controllers\Admin\LocationController::class, 'save_location'])->middleware('is_admin');
    Route::get('/edit_location/{id}', [App\Http\Controllers\Admin\LocationController::class, 'edit_location'])->middleware('is_admin');
    Route::post('/update_location/{id}', [App\Http\Controllers\Admin\LocationController::class, 'update_location'])->name('update_location')->middleware('is_admin');
    Route::get('/delete_location/{id}', [App\Http\Controllers\Admin\LocationController::class, 'delete_location'])->middleware('is_admin');
    // bài viết
    Route::get('/add_post', [App\Http\Controllers\Admin\PostController::class, 'add_post'])->middleware('is_admin');
    Route::get('/all_post', [App\Http\Controllers\Admin\PostController::class, 'all_post'])->name('all_post')->middleware('is_admin');
    Route::post('/save_post', [App\Http\Controllers\Admin\PostController::class, 'save_post'])->middleware('is_admin');
    Route::get('/edit_post/{id}', [App\Http\Controllers\Admin\PostController::class, 'edit_post'])->middleware('is_admin');
    Route::post('/update_post/{id}', [App\Http\Controllers\Admin\PostController::class, 'update_post'])->name('update_post')->middleware('is_admin');
    Route::get('/delete_post/{id}', [App\Http\Controllers\Admin\PostController::class, 'delete_post'])->middleware('is_admin');
    // người dùng
    Route::get('/add_user', [App\Http\Controllers\Admin\UserController::class, 'add_user'])->middleware('is_admin');
    Route::get('/all_user', [App\Http\Controllers\Admin\UserController::class, 'all_user'])->name('all_user')->middleware('is_admin');
    Route::post('/save_user', [App\Http\Controllers\Admin\UserController::class, 'save_user'])->middleware('is_admin');
    Route::get('/edit_user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'edit_user'])->middleware('is_admin');
    Route::post('/update_user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'update_user'])->name('update_user')->middleware('is_admin');
    Route::get('/delete_user/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'delete_user'])->middleware('is_admin');
});
Route::get('/add_post', [App\Http\Controllers\User\PostController::class, 'add_post']);
Route::post('/save_post', [App\Http\Controllers\User\PostController::class, 'save_post']);
// Route::get('/search',[App\Http\Controllers\SearchController::class, 'get_result'])->name('get_result');
// Route::get('/chat',[App\Http\Controllers\ChatController::class, 'chat'])->name('chat');
Route::get('/my_profile',[App\Http\Controllers\HomeController::class, 'myProfile']);
Route::get('/user_profile/{user_id}',[App\Http\Controllers\HomeController::class, 'user_profile'])->name('user_profile');
Route::get('/data',[App\Http\Controllers\HomeController::class, 'data']);
Route::get('/form_location', [App\Http\Controllers\User\LocationController::class, 'index'])->name('form_location');
Route::post('/like', [App\Http\Controllers\User\LikeController::class, 'index'])->name('like');
Route::post('/comment', [App\Http\Controllers\User\CommentController::class, 'index'])->name('comment');
Route::get('/location_post/{location_id}',[App\Http\Livewire\FetchLocations::class, 'fetch_locations'])->name('location_post');
Route::get('/bookmark/{user_id}',[App\Http\Livewire\FetchBookmarks::class, 'fetch_bookmarks'])->name('bookmark');
Route::get('/message/{user_id}', [App\Http\Controllers\User\MessageController::class, 'index'])->name('message');
