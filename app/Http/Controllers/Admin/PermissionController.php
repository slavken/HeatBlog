<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')
            ->paginate();

        return view('home.admin.permissions.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        $roles = Role::all();

        return view('home.admin.permissions.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions'
        ]);

        $permission = new Permission();

        $permission->name = Str::slug($request->name);

        $permission->save();
        $permission->roles()
            ->sync($request->role);

        return redirect()
            ->route('permissions.index')
            ->with('status', 'The permission added successfully!');
    }

    public function show($id)
    {
        abort(404);
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        $roles = Role::all();

        return view('home.admin.permissions.edit', ['permission' => $permission, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions'
        ]);

        $permission = Permission::findOrFail($id);

        $permission->name = Str::slug($request->name);

        $permission->save();
        $permission->roles()
            ->sync($request->role);

        return redirect()
            ->route('permissions.index')
            ->with('status', 'The permission updated successfully!');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()
            ->route('permissions.index');
    }
}
