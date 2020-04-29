@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="jumbotron text-center py-5">
                                    <h5>Posts</h5>
                                    <p class="lead">{{ $qtyPosts }}</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="jumbotron text-center py-5">
                                    <h5>Comments</h5>
                                    <p class="lead">{{ $qtyPosts }}</p>
                                </div>
                            </div>
                        </div>

                        <h4>Latest posts</h4>
                        @if ($latestPosts->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestPosts as $post)
                                            <tr>
                                                <th><a href="{{ route('post.show', $post->alias) }}" class="text-dark">{{ $post->title }}</a></th>
                                                <td>{{ $post->created_at->diffForHumans() }}</td>
                                                <td>{{ $post->views }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ url('home/posts') }}" class="btn btn-sm btn-primary float-right">All posts</a>
                        @else
                            <span class="text-danger">Not found</span>
                        @endif

                        <h4 class="mt-4">Latest comments</h4>
                        @if ($latestComments->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Post</th>
                                            <th scope="col">Comment</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestComments as $comment)
                                            <tr>
                                            <th><a href="{{ route('post.show', $comment->post->alias) }}" class="text-dark">{{ $comment->post->title }}</a></th>
                                                <td>{{ $comment->body }}</td>
                                                <td>{{ $comment->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{ url('home/comments') }}" class="btn btn-sm btn-primary float-right">All comments</a>
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
                            <i class="fas fa-user p-3 border rounded-circle"></i>
                            <h3>{{ Auth::user()->name }}</h3>
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded active">Dashboard</a>
                            <a href="{{ url('home/posts') }}" class="list-group-item list-group-item-action border-0 rounded">My posts</a>
                            <a href="{{ url('home/comments') }}" class="list-group-item list-group-item-action border-0 rounded">My comments</a>
                            <a href="{{ url('home/settings') }}" class="list-group-item list-group-item-action border-0 rounded">Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
