@extends('layouts.main')

@section('content')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex align-items-center">
                <h1 class="mb-1">{{ Str::ucfirst($user->name) }}</h1>
    
                @if (Auth::id() == $user->id)
                    <a href="{{ url('home/settings') }}" class="btn btn-sm btn-light ml-2 border">Edit</a>
                @else
                    @can('update-users')
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-light ml-2 border">Edit</a>
                    @endcan
                @endif
            </div>

            <!-- Roles -->
            @if ($user->roles->isNotEmpty())
                @foreach ($user->roles as $role)
                    <span @if ($role->name == 'admin') class="text-danger" @endif>{{ Str::ucfirst($role->name) }}</span>
                @endforeach
            @endif

            <p>Registration date: {{$user->created_at->format('d M Y') }}</p>

            <!-- Posts -->
            <div class="card mb-4">
                <div class="card-header">Posts</div>

                <div class="card-body">
                    @if ($posts->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Post</th>
                                        <th>Date</th>
                                        @canany(['update', 'update-posts', 'delete'], $posts)
                                            <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <th><a href="{{ route('post.show', $post->title) }}" class="text-dark">{{ Str::limit($post->title, 30) }}</a></th>
                                            <td>{{ $post->created_at->diffForHumans() }}</td>
                                            @canany(['update', 'update-posts', 'delete'], $post)
                                            <td>
                                                <div class="my-2 d-flex">
                                                    @canany(['update', 'update-posts'], $post)
                                                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                                                    @endcanany
                                                    @can('delete', $post)
                                                        <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                            @endcanany
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

            <!-- Comments -->
            <div class="card mb-4">
                <div class="card-header">Comments</div>

                <div class="card-body">
                    @if ($comments->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Comment</th>
                                        <th>Post</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td>{{ $comment->body}}</td>
                                            <th><a href="{{ route('post.show', $comment->post->alias) }}" class="text-dark">{{ Str::limit($comment->post->title, 30) }}</a></th>
                                            <td>{{ $comment->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="my-2 d-flex">
                                                    <a href="{{ route('post.edit', $comment->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                                                    <form action="{{ route('post.destroy', $comment->id) }}" method="POST">
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

        <!-- Sidebar -->
        <aside class="col-md-4">
            @include('includes.sidebar')
        </aside>
    </div>
@endsection
