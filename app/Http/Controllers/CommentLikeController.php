<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentLikeController extends Controller
{
    public function __construct()
    {   
        $this->middleware(['auth']);
    }
    
    public function store(Comment $comment,Request $request)
    {

        if ($comment->likedCommentBy($request->user()))
        {
            return response(null,409);
        }
        $comment->comment_likes()->create([
            'user_id'=>$request->user()->id,
        ]);
        return back(); 
    }

    public function destroy(Comment $comment,Request $request)
    {
        $request->user()->comment_likes()->where('comment_id',$comment->id)->delete();
        return back();
    }

}
