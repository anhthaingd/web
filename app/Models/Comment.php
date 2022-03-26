<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CommentLike;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'post_id',
        'text',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedCommentBy(User $user)
    {
        return $this->comment_likes->contains('user_id',$user->id);
    }
    public function comment_likes()
    {
        return $this->hasMany(CommentLike::class);
    }

}
