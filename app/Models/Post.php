<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Location;
use App\Models\Like;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'post_content',
        'post_image',
        'user_id',
        'location_id',

    ];
    public function locations() {
        return $this->belongsToMany(Location::class,'posts','id','location_id');
    }
    public function user() {
        return $this->belongsTo(User::class);
        // return $this->belongsToMany(User::class,'posts','id','user_id');
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function marks(){
        return $this->hasMany(Bookmark::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function userLikedPost()
    {
        return (bool) $this->likes->where('user_id', auth()->id())->count();
    }
    public function userMarkedPost()
    {
        return (bool) $this->marks->where('user_id', auth()->id())->count();
    }
}
