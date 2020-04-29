@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row text-center">
            <div class="col">
                <div class="jumbotron">
                    <h5>Posts</h5>
                    <p class="lead">{{$posts->count()}}</p>
                </div>
            </div>
            <div class="col">
                <div class="jumbotron">
                    <h5>Users</h5>
                    <p class="lead">{{$users->count()}}</p>
                </div>
            </div>
            <div class="col">
                <div class="jumbotron">
                    <h5>Categories</h5>
                    <p class="lead">{{$categories->count()}}</p>
                </div>
            </div>
            <div class="col">
                <div class="jumbotron">
                    <h5>Comments</h5>
                    <p class="lead">{{$comments->count()}}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Recent</div>

                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <h5>Latest post</h5>

                                @if ($posts->isEmpty())
                                    <small class="text-muted">Not found</small>
                                @else
                                    <small class="text-muted">
                                        <i class="far fa-clock"></i>
                                        {{ $posts->last()->created_at->diffForHumans() }}
                                    </small>

                                    <div class="font-weight-bold">
                                        <a href="{{ url('post/'.$posts->last()->alias) }}">{{ $posts->last()->title }}</a>
                                    </div>
                                @endif
                            </div>

                            <div class="col-4">
                                <h5>Latest user</h5>

                                <small class="text-muted">
                                    <i class="far fa-clock"></i>
                                    {{ $users->last()->created_at->diffForHumans() }}
                                </small>

                                <div class="font-weight-bold">
                                    <a href="{{ url('profile/'.$users->last()->name) }}">{{ $users->last()->name }}</a>
                                </div>
                            </div>

                            <div class="col-4">
                                <h5>Latest comment</h5>

                                <small class="text-muted">
                                    <i class="far fa-clock"></i>
                                    {{ $comments->last()->created_at->diffForHumans() }}
                                </small>

                                <div class="font-weight-bold">
                                    <a href="{{ route('comments.edit', $comments->last()->id) }}">{{ $comments->last()->body }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Statistics</div>
            
                    <div class="card-body">
                        <table class="table table-bordered mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Posts</th>
                                    <th scope="col">Users</th>
                                    <th scope="col">Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Today</th>
                                    <td>{{ $datePost['today'] }}</td>
                                    <td>{{ $dateUser['today'] }}</td>
                                    <td>{{ $dateComment['today'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Week</th>
                                    <td>{{ $datePost['week'] }}</td>
                                    <td>{{ $dateUser['week'] }}</td>
                                    <td>{{ $dateComment['week'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Month</th>
                                    <td>{{ $datePost['month'] }}</td>
                                    <td>{{ $dateUser['month'] }}</td>
                                    <td>{{ $dateComment['month'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Year</th>
                                    <td>{{ $datePost['year'] }}</td>
                                    <td>{{ $dateUser['year'] }}</td>
                                    <td>{{ $dateComment['year'] }}</td>
                                </tr>
                            </tbody>
                        </table>
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
                            @foreach (Auth::user()->roles as $role)
                                <span @if ($role->name == 'admin') class="text-danger" @endif>{{ Str::ucfirst($role->name) }}</span>
                            @endforeach
                        </div>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded active">Dashboard</a>
                            <a href="{{ url('admin/posts') }}" class="list-group-item list-group-item-action border-0 rounded">Posts</a>
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
