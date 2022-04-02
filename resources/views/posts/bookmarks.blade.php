@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-8/12 bg-white p-6 rounded-lg">
        

        @if ($posts->count())
        @foreach ($posts as $post)
        <div class="mb-4">
            <a href="{{ route('users.posts',$post->user) }}" class="font-bold">{{ $post->user->name }}</a> <span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
            <div>
                <!-- <textarea name="body1" id="body1" cols="30" rows="7" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body1') border-red-500 @enderror">{{$post->body}}</textarea> -->
                <div class="mb-5 bg-blue-300 px-4 py-6 rounded-sm shadow-md">
                    <div class="mb-10">
                        <span class="text-black-500 text-3xl text-sm">{{ $post->body }}</span>
                    </div>


                </div>
            </div>
            @auth
            <div>
                <form action="{{ route('posts.destroy',$post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500">Delete</button>

                </form>
            </div>

            @endauth
            @auth
            <div class="flex items-center">


                @if (!$post->likedBy(auth()->user()))
                <form action="{{ route('posts.likes',$post) }}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500">Like</button>
                </form>
                @else
                <form action="{{ route('posts.likes',$post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500">Unlike</button>
                </form>
                @endif


                <span>{{ $post->likes->count() }} {{ Str::plural('like',$post->likes->count()) }}</span>
            </div>
           
            @endauth
        </div>
        <div class="mb-2">
            @auth
            @if(!$post->bookmarkedBy(auth()->user()))
            <form action="{{ route('posts.bookmark', $post) }}" method="post" class="mr-1">
                <!-- route('posts.bookmark') -->
                @csrf
                <button type="submit" class="text-white rounded-xl px-2 py-1 bg-orange-400"> Lưu bài viết </button>
            </form>
            @else
            <form action="{{ route('posts.bookmark', $post) }}" method="post" class="mr-1">
                <!-- route('posts.bookmark') -->
                @csrf
                @method('DELETE')
                <button type="submit" class="text-white rounded-xl px-2 py-1 bg-orange-400"> Bỏ lưu </button>
            </form>
            @endif
            @endauth
        </div>
        <div>
            @auth
            <form action="{{ route('posts.comments',$post) }}" method="POST" class="mb-0">
                @csrf

                <textarea name="text" class="mt-1 py-2 px-3 block w-full border-4 borded border-gray-400 rounded-md shadow-sm" placeholder="Comment something!" required>{{ old('text') }}</textarea>
                <button type="submit" class="mt-6 py-1 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">Post</button>
            </form>
            @endauth

            <div class="mt-6">

                @foreach ($post->comments as $comment)
                <div class="mb-5 bg-white px-4 py-1 rounded-sm shadow-md">
                    <div class="mb-2">
                        <a href="{{ route('users.posts',$post->user) }}" class="font-bold">{{ $comment->user->name }}</a> <span class="text-gray-600 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="mt-2">
                        <p class="text-red-600">{{ $comment->text }}</p>
                    </div>
                    <div class="flex items-center">
                        @auth
                        <div>
                            <form action="{{ route('comments.destroy',$comment) }}" method="post" class="mr-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-500">Delete</button>
                            </form>
                        </div>
                        @endauth

                    </div>
                    <div class="flex items-center">
                        @auth

                        @if (!$comment->likedCommentBy(auth()->user()))
                        <form action="{{ route('comments.likes',$comment) }}" method="post" class="mr-1">
                            @csrf
                            <button type="submit" class="text-blue-500">Like</button>
                        </form>
                        @else
                        <form action="{{ route('comments.likes',$comment) }}" method="post" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-500">Unlike</button>
                        </form>

                        @endif
                        <span>{{ $comment->comment_likes->count() }} {{ Str::plural('like',$comment->comment_likes->count())}}</span>
                        @endauth

                    </div>
                </div>
                @endforeach


            </div>
        </div>

        @endforeach
        
        @else
        <p>There are no posts</p>
        @endif
    </div>
</div>
@endsection