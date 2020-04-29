<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')
            ->paginate();

        return view('home.admin.roles.index', ['roles' => $roles]);
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('home.admin.roles.create', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles'
        ]);

        $role = new Role();

        $role->name = Str::lower($request->name);

        $role->save();
        $role->permissions()
            ->sync($request->permission);

        return redirect()
            ->route('roles.index')
            ->with('status', 'The role added successfully!');
    }

    public function show($id)
    {
        $role = Role::find($id);
        $users = $role->users()
            ->paginate();

        return view('home.admin.roles.show', ['role' => $role, 'users' => $users]);
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('home.admin.roles.edit', ['role' => $role, 'permissions' => $permissions]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles'
        ]);

        $role = Role::findOrFail($id);

        $role->name = Str::lower($request->name);

        $role->save();
        $role->permissions()
            ->sync($request->permission);

        return redirect()
            ->route('roles.index')
            ->with('status', 'The role updated successfully!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()
            ->route('roles.index');
    }

    function add(Request $request, $id)
    {
        $role = Role::find($id);

        if ($request->isMethod('post')) {
            $user = User::where('name', $request->name)->first();

            $check = $role->users()
                ->syncWithoutDetaching($user->id);

            if (empty($check['attached'])) {
                return back()
                    ->withErrors('The user already added');
            }

            return back()
                ->with('status', 'The user added successfully!');
        }

        $users = User::all();

        return view('home.admin.roles.add', ['role' => $role, 'users' => $users]);
    }

    function delete(Request $request, $id)
    {
        $user = User::find($request->user);

        $user->roles()
            ->detach($id);

        return back();
    }
}
