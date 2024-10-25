<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_name',
        'location_status',
        'location_ip'
    ];
    public function posts() {
        return $this->hasMany(Post::class,'location_id','id');
        
    }
    
}
