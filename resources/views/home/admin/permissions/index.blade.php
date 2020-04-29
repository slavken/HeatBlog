@extends('layouts.admin')

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

                <div class="card mb-4">
                    <div class="card-header">Permissions</div>

                    <div class="card-body">
                        <a href="{{ route('permissions.create') }}" class="btn btn-success mb-3">Add a permission</a>

                        @if ($permissions->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions->sortBy('id') as $permission)
                                            <tr>
                                                <td>{{ $permission->id }}</td>
                                                <td>
                                                    {{ $permission->name }}

                                                    @if ($permission->roles->isNotEmpty())
                                                        <div>
                                                            @foreach ($permission->roles as $role)
                                                                <a href="{{ route('roles.show', $role->id) }}" class="badge badge-primary">{{ $role->name }}</a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center my-2">
                                                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-light mr-2 border">Edit</a>
                                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
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
                                {{ $permissions->links() }}
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
                            @can('roles')
                                <a href="{{ url('admin/roles') }}" class="list-group-item list-group-item-action border-0 rounded">Roles</a>
                            @endcan
                            <a href="#" class="list-group-item list-group-item-action border-0 rounded active">Permissions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
