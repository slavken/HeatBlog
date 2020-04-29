@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">Settings</div>

                    <div class="card-body">
                        <div class="mb-3">
                            <h5>Your account: {{ Auth::user()->name }}</h5>
                            <h5>Email: {{ Auth::user()->email }}</h5>
                        </div>

                        <a href="{{ url('change/email') }}" class="btn btn-primary mr-2">Change email</a>
                        <a href="{{ url('change/username') }}" class="btn btn-primary mr-2">Change username</a>
                        <a href="{{ url('change/password') }}" class="btn btn-primary">Change password</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <a href="{{ route('home') }}" class="text-dark">
                                <i class="fas fa-user border rounded-circle p-3"></i>
                            </a>
                            <h3>{{ Auth::user()->name }}</h3>
                        </div>
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
