<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentsRequest;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function index()
    {
        
    }
    public function store(Post $post,Request $request)
    {
        $this->validate($request,[
            'text'=>'required',

        ]);
        $request->user()->comments()->create([
            'post_id'=>$post->id,
            'text'   =>$request->text,
        ]);
        return back();
    }

    public function destroy(Comment $comment)
    {
        $comment -> delete();
        return back();
    }
}
