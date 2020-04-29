<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with('post')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        return view('home.comments', ['comments' => $comments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'body' => 'min:1'
        ]);

        $comment = new Comment();

        $comment->post_id = $id;
        $comment->parent_id = $request->parent ? $request->parent : null;
        $comment->body = $request->body;
        $comment->user_id = Auth::id() ?: null;

        $comment->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::id() != $comment->user_id) abort(403);

        $comment->delete();

        return back();
    }
}
