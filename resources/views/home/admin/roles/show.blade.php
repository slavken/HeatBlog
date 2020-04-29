@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">Role #{{ $role->id }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p>Role name: {{ $role->name }}</p>
                        <p>
                            Permisssions:
                            @foreach ($role->permissions as $permission)
                                <span class="badge badge-primary">{{ $permission->name }}</span>
                            @endforeach
                        </p>

                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('roles.add', $role->id) }}" class="btn btn-lg d-block btn-info">Add user</a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-lg d-block btn-light border">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        @if ($users->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Date</th>
                                            @canany(['update-users', 'delete-users'])
                                                <th class="text-center">Action</th>
                                            @endcanany
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <th><a href="{{ route('users.show', $user->id) }}" class="text-dark">{{ $user->name }}</a></th>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->created_at->format('H:i - d M Y') }}</td>
                                                @canany(['update-users', 'delete-users'])
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            @can('update-users')
                                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                                                            @endcan
                                                            @can('delete-users')
                                                                <form action="{{ route('roles.delete', $role->id) }}" method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <input type="hidden" name="user" value="{{ $user->id }}">
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
                                {{ $users->links() }}
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
                            <a href="{{ url('admin/posts') }}" class="list-group-item list-group-item-action border-0 rounded">Posts</a>
                            <a href="{{ url('admin/users') }}" class="list-group-item list-group-item-action border-0 rounded">Users</a>
                            @can('categories')
                                <a href="{{ url('admin/categories') }}" class="list-group-item list-group-item-action border-0 rounded">Categories</a>
                            @endcan
                            <a href="{{ url('admin/comments') }}" class="list-group-item list-group-item-action border-0 rounded">Comments</a>
                            @can('cache')
                                <a href="{{ url('admin/cache') }}" class="list-group-item list-group-item-action border-0 rounded">Cache</a>
                            @endcan
                            <a href="{{ url('admin/roles') }}" class="list-group-item list-group-item-action border-0 rounded active">Roles</a>
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
