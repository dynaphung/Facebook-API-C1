<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAllComments() {
        return $this->hasMany(Comment::class, 'post_id');
        
    }

    public function getAllLikes() {
        return $this->hasMany(Like::class, 'post_id');
        
    }
}
