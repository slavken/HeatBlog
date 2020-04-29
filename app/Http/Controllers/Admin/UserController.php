<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')
            ->paginate(10);

        return view('home.admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(Request $request, $id)
    {
        $this->authorize('update-users');

        $user = User::findOrFail($id);
        $userPosts = $user->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(5, '*', 'post')
            ->appends($request->query());
        $userComments = $user->comments()
            ->with('post')
            ->orderBy('created_at', 'desc')
            ->paginate(5, '*', 'comment')
            ->appends($request->query());

        return view('home.admin.users.show', ['user' => $user, 'posts' => $userPosts, 'comments' => $userComments]);
    }

    public function edit($id)
    {
        $this->authorize('update-users');

        $user = User::findOrFail($id);

        return view('home.admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update-users');

        $user = User::findOrFail($id);

        if ($user->name != $request->name) {
            $request->validate([
                'name' => 'min:2|unique:users'
            ]);
        }

        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'email|min:6|unique:users'
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return back()
            ->with('status', 'The user updated successfully!');
    }

    public function destroy($id)
    {
        $this->authorize('delete-users');

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('users.index');
    }
}
