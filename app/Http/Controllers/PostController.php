<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {

    $posts=Post::latest()->with(['user','likes'])-> paginate(20);

    return view('posts.index', [
        'posts'=>$posts,

        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,[
            'body'=>'required'
        ]);
        //auth()->user()->posts()->create();
        $request->user()->posts()->create($request->only('body'));
        return back(); 
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back();
    }
}
