@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Comments</div>

                    <div class="card-body">
                        @if ($comments->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Comment</th>
                                            <th scope="col">Post</th>
                                            <th scope="col">Date</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $comment)
                                            <tr>
                                                <td>{{ $comment->body }}</td>
                                                <th><a href="{{ route('post.show', $comment->post->alias) }}" class="text-dark">{{ Str::limit($comment->post->title, 30) }}</a></th>
                                                <td>{{ $comment->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <form action="{{ route('home.comments.destroy', $comment->id) }}" method="POST">
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
                                {{ $comments->links() }}
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
                            <a href="{{ url('home/posts') }}" class="list-group-item list-group-item-action border-0 rounded">My posts</a>
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded active">My comments</a>
                            <a href="{{ url('home/settings') }}" class="list-group-item list-group-item-action border-0 rounded">Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
