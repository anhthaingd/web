<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $post_ids = $user->bookmarks()->get('post_id');
        $posts = Post::find($post_ids);

        return view('posts.bookmarks',[
            'user' => $user,
            'posts' => $posts,
        ]);
    }

    public function store(Post $post, Request $request)
    {
        if ($post->bookmarkedBy($request->user()))
        {
            return response(null, 409);
        }

        $post->bookmarks()->create([
            'user_id'  => $request->user()->id,
        ]);

        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        $request->user()->bookmarks()->where('post_id', $post->id)->delete();

        return back();
    }
}