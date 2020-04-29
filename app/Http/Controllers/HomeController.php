<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Auth::user()
            ->posts()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $latestComments = Comment::with('post')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $qtyPosts = Auth::user()
            ->posts
            ->count();
        $qtyComments = Auth::user()
            ->comments
            ->count();

        return view('home.index', [
            'latestPosts'    => $latestPosts, 
            'latestComments' => $latestComments, 
            'qtyPosts'     => $qtyPosts, 
            'qtyComments'  => $qtyComments
        ]);
    }

    public function posts()
    {
        $posts = Auth::user()
            ->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('home.posts', ['posts' => $posts]);
    }

    public function settings()
    {
        return view('home.settings');
    }

    public function updateEmail(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'required|email|min:6|unique:users'
            ]);

            $user = Auth::user();
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();

            event(new Registered($user));

            return back();
        }

        return view('home.update.email');
    }

    public function updateUsername(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|min:2|unique:users'
            ]);

            $user = Auth::user();
            $user->name = $request->name;
            $user->save();

            return redirect('home/settings')
                ->with('status', 'The username changed successfully!');
        }

        return view('home.update.username');
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'old_password' => 'required|min:8',
                'password' => 'required|min:8|confirmed',
            ]);

            if (Hash::check($request->old_password, Auth::user()->password)) {
                $user = Auth::user();
                $user->password = Hash::make($request->new_password);
                $user->save();

                return redirect('home/settings')
                    ->with('status', 'Password changed successfully!');
            } else {
                return back()
                    ->withErrors('The old password is incorrect');
            }
        }

        return view('home.update.password');
    }
}
