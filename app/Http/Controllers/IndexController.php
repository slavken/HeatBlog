<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function profile(Request $request, $name)
    {
        $user = User::where('name', $name)
            ->firstOrFail();
        $posts = $user->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(10, '*', 'post')
            ->appends($request->query());
        $comments = $user->comments()
            ->orderBy('created_at', 'desc')
            ->paginate(10, '*', 'post')
            ->appends($request->query());

        return view('profile', ['user' => $user, 'posts' => $posts, 'comments' => $comments]);
    }

    function about()
    {
        return view('about');
    }

    function contact()
    {
        return view('contact');
    }
}
