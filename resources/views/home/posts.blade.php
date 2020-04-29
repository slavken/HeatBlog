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
                    <div class="card-header">Posts</div>

                    <div class="card-body">
                        @if ($posts->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Post</th>
                                            <th>Date</th>
                                            <th>Views</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posts as $post)
                                            <tr>
                                                <th><a href="{{ route('post.show', $post->alias) }}" class="text-dark">{{ Str::limit($post->title, 30) }}</a></th>
                                                <td>{{ $post->created_at->diffForHumans() }}</td>
                                                <td>{{ $post->views }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                                                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $posts->links() }}
                            </div>
                        @else
                            <span class="text-danger">Not found</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <a href="{{ route('home') }}" class="text-dark">
                                <i class="fas fa-user p-3 border rounded-circle"></i>
                            </a>
                            <h3>{{ Auth::user()->name }}</h3>
                        </div>
                        <div class="list-group">
                            <a href="{{ url('home') }}" class="list-group-item list-group-item-action border-0 rounded">Dashboard</a>
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded active">My posts</a>
                            <a href="{{ url('home/comments') }}" class="list-group-item list-group-item-action border-0 rounded">My comments</a>
                            <a href="{{ url('home/settings') }}" class="list-group-item list-group-item-action border-0 rounded">Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
