<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>App cua Thai</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="bg-gray-400">
        <nav class="p-6 bg-purple-500 flex justify-between mb-6">
            <ul class="flex items-center">
                <li>
                    <a href="/" class="p-3">Home</a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="p-3">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('posts') }}" class="p-3">Posts</a>
                </li>
                <li>
                    <a href="{{ route('bookmarks') }}" class="p-3">Bookmark</a>
                </li>
            </ul>

            <ul class="flex items-center">

                @auth
                    <li>
                        <a href="" class="p-3">{{auth()->user()->name}}</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="p-3">Logout</a>
                    </li>
                @endauth

                @guest
                    <li>
                        <a href="{{ route('login') }}" class="p-3">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="p-3">Register</a>
                    </li>
                @endguest

                
                
                
            </ul>
        </nav>
        
        @yield('content')
    </body>
</html>