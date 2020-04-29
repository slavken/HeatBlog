<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    function index()
    {
        $posts = Post::all();
        $users = User::all();
        $categories = Category::all();
        $comments = Comment::all();

        $post = $user = $comment = [];

        $post['today'] = $posts->where('created_at', '>=', Carbon::today())->count();
        $post['week'] = $posts->where('created_at', '>=', Carbon::now()->subWeek())->count();
        $post['month'] = $posts->where('created_at', '>=', Carbon::now()->subMonth())->count();
        $post['year'] = $posts->where('created_at', '>=', Carbon::now()->subYear())->count();

        $user['today'] = $users->where('created_at', '>=', Carbon::today())->count();
        $user['week'] = $users->where('created_at', '>=', Carbon::now()->subWeek())->count();
        $user['month'] = $users->where('created_at', '>=', Carbon::now()->subMonth())->count();
        $user['year'] = $users->where('created_at', '>=', Carbon::now()->subYear())->count();

        $comment['today'] = $comments->where('created_at', '>=', Carbon::today())->count();
        $comment['week'] = $comments->where('created_at', '>=', Carbon::now()->subWeek())->count();
        $comment['month'] = $comments->where('created_at', '>=', Carbon::now()->subMonth())->count();
        $comment['year'] = $comments->where('created_at', '>=', Carbon::now()->subYear())->count();

        return view('home.admin.index', [
            'posts' => $posts, 
            'users' => $users,
            'categories' => $categories, 
            'comments' => $comments,
            'datePost' => $post,
            'dateUser' => $user,
            'dateComment' => $comment
        ]);
    }

    public function updateEmail(Request $request, $id)
    {
        $this->authorize('update-users');

        $user = User::find($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email|min:6|unique:users'
            ]);

            $user->email = $request->email;
            $user->email_verified_at = null;

            $user->save();

            event(new Registered($user));

            return redirect('admin/users/' . $id)
                ->with('status', 'The email changed successfully!');
        }

        return view('home.admin.users.update.email', ['user' => $user]);
    }

    public function updateUsername(Request $request, $id)
    {
        $this->authorize('update-users');

        $user = User::find($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|min:2|unique:users'
            ]);

            $user->name = $request->name;
            $user->save();

            return redirect('admin/users/' . $id)
                ->with('status', 'The username changed successfully!');
        }

        return view('home.admin.users.update.username', ['user' => $user]);
    }

    public function updatePassword(Request $request, $id)
    {
        $this->authorize('update-users');

        $user = User::find($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'password' => 'required|min:8|confirmed'
            ]);

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect('admin/users/' . $id)
                ->with('status', 'Password changed successfully!');
        }

        return view('home.admin.users.update.password', ['user' => $user]);
    }

    function confirmEmail($id)
    {
        $this->authorize('update-users');

        $user = User::find($id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        return back();
    }
}
