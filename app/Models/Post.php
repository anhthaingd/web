<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body'
    ];

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id',$user->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
    public function bookmarkedBy(User $user)
    {
        return $this->bookmarks->contains('user_id', $user->id);
    }
}
