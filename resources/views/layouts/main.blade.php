<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('contact') }}">Contact Us</a>
                    </li>
                </ul>
                @guest
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="btn btn-sm btn-success" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    <a href="{{ route('post.create') }}" class="btn btn-sm btn-outline-success mr-2">Create a post</a>
                    @if (Auth::user()->roles->isNotEmpty())
                        <a href="{{ url('admin') }}" class="btn btn-sm btn-primary mr-2">Admin Panel</a>
                    @endif
                    <a href="{{ url('/home') }}" class="btn btn-sm btn-primary">My profile</a>
                @endguest
            </div>
        </div>
    </nav>
    
    <!-- Content -->
    <div class="container">
        @include('includes.categories')

        @yield('content')
    </div>

    <!-- Footer -->
    @include('includes.footer')

    <!-- Scripts -->
    @include('includes.scripts')
</body>
</html>