@extends('layouts.page')

@section('content')
<div class="flex-center position-ref full-height">
    <div class="top-right links">
        @if (Session::has('access_token'))
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('auth::logout') }}">Logout</a>
        @else
            <a href="{{ route('auth::login') }}">Login</a>
        @endif
    </div>

    <div class="content">
        <div class="title m-b-md">
            {{ config('app.name', 'Laravel') }}
        </div>

        <div class="links">
            <a href="https://github.com/rymanalu/simple-twitter-client" target="_blank">GitHub</a>
        </div>
    </div>
</div>
@endsection
