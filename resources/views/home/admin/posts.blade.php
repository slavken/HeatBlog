@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Posts</div>

                    <div class="card-body">
                        <a href="{{ route('post.create') }}" class="btn btn-success mb-3">Add a post</a>

                        @if ($posts->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Post</th>
                                            <th>User</th>
                                            <th>Date</th>
                                            <th>Views</th>
                                            @canany(['update-posts', 'delete-posts'])
                                                <th class="text-center">Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($posts as $post)
                                            <tr>
                                                <th><a href="{{ route('post.show', $post->alias) }}" class="text-dark">{{ Str::limit($post->title, 30) }}</a></th>
                                                <th><a href="{{ route('users.show', $post->user->id) }}" class="text-dark">{{ $post->user->name }}</a></th>
                                                <td>{{ $post->created_at->format('H:i - d M Y') }}</td>
                                                <td>{{ $post->views }}</td>
                                                @canany(['update-posts', 'delete-posts'])
                                                    <td>
                                                        <div class="d-flex justify-content-center my-2">
                                                            @can('update-posts')
                                                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                                                            @endcan
                                                            @can('delete-posts')
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
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <a href="{{ route('home') }}" class="text-dark mr-2">
                                <i class="fas fa-user p-3 border rounded-circle"></i>
                            </a>
                            <h3>{{ Auth::user()->name }}</h3>
                        </div>
                        <div class="list-group">
                            <a href="{{ url('admin') }}" class="list-group-item list-group-item-action border-0 rounded">Dashboard</a>
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded active">Posts</a>
                            <a href="{{ url('admin/users') }}" class="list-group-item list-group-item-action border-0 rounded">Users</a>
                            @can('categories')
                                <a href="{{ url('admin/categories') }}" class="list-group-item list-group-item-action border-0 rounded">Categories</a>
                            @endcan
                            <a href="{{ url('admin/comments') }}" class="list-group-item list-group-item-action border-0 rounded">Comments</a>
                            @can('cache')
                                <a href="{{ url('admin/cache') }}" class="list-group-item list-group-item-action border-0 rounded">Cache</a>
                            @endcan
                            @can('roles')
                                <a href="{{ url('admin/roles') }}" class="list-group-item list-group-item-action border-0 rounded">Roles</a>
                            @endcan
                            @can('permissions')
                                <a href="{{ url('admin/permissions') }}" class="list-group-item list-group-item-action border-0 rounded">Permissions</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
