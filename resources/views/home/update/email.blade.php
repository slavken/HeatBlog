@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Settings</div>
            
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h5>Email: {{ Auth::user()->email }}</h5>
                        <form method="post">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="New email" required>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary btn-block my-3">Submit</button>
                        </form>
                        <a href="{{ url('home/settings') }}">Return to settings</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        {{ Auth::user()->name }}
                        <div class="list-group">
                            <a href="{{ url('home') }}" class="list-group-item list-group-item-action border-0 rounded">Dashboard</a>
                            <a href="{{ url('home/posts') }}" class="list-group-item list-group-item-action border-0 rounded">My posts</a>
                            <a href="{{ url('home/comments') }}" class="list-group-item list-group-item-action border-0 rounded">My comments</a>
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded active">Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
