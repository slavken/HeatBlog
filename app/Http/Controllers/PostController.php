<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Popular this week
        $postsWeek = Post::with('categories')
            ->where('updated_at', '>=', Carbon::now()->startOfWeek())
            ->orderBy('weekly_views', 'desc')
            ->limit(4)
            ->get();

        // Trend category
        $trendPosts = Category::firstWhere('alias', 'lifehacks')
            ->posts()
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Very interesting
        $interestingPosts = Post::with('categories')
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();

        // Search
        if ($request->search) {
            $posts = Post::with('user')
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(5)
                ->appends($request->query());

            return view('posts.index', [
                'posts' => $posts, 
                'postsWeek' => $postsWeek, 
                'trendPosts' => $trendPosts, 
                'interestingPosts' => $interestingPosts
            ]);
        }

        // All posts
        $posts = Post::with(['user', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('posts.index', [
            'posts' => $posts, 
            'postsWeek' => $postsWeek, 
            'trendPosts' => $trendPosts, 
            'interestingPosts' => $interestingPosts
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('posts.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5|unique:posts',
            'body' => 'required|min:5',
            'img' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->alias = Str::slug($request->title);
        $post->body = $request->body;
        $post->user_id = Auth::id();

        // If the file exists
        if ($request->file('img')) {
            // With storage:link
            $path = Storage::putFile('public', $request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;

            // Without storage:link
            // $imgName = time() . '.' . $request->img->extension();
            // $request->img->move(public_path('img'), $imgName);
        }

        $post->save();
        $post->categories()
            ->attach($request->category);

        return redirect()
            ->route('post.show', $post->alias)
            ->with('status', 'The post added successfully!');
    }

    public function show($alias)
    {
        $post = Post::where('alias', Str::slug($alias))
            ->firstOrFail();
        $comments = Post::find($post->id)
            ->comments
            ->groupBy('parent_id');
        $categories = Post::find($post->id)
            ->categories;

        // Add a view
        $post->increment('views');

        // Add a view today
        if ($post->updated_at >= Carbon::today()) {
            $post->increment('views_today');
        } else {
            $post->views_today = 0;
            $post->update();
        }

        // Add a weekly view
        if ($post->updated_at >= Carbon::now()->startOfWeek()) {
            $post->increment('weekly_views');
        } else {
            $post->weekly_views = 0;
            $post->update();
        }

        return view('posts.show', ['post' => $post, 'comments' => $comments, 'categories' => $categories]);
    }

    public function edit($id)
    {
        $post = Post::find($id);

        if (Gate::none(['update', 'update-posts'], $post)) {
            abort(403);
        }

        $categories = Category::all();

        return view('posts.edit', ['post' => $post, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (Gate::none(['update', 'update-posts'], $post)) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|min:5',
            'body' => 'required|min:5',
            'img' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($post->title != $request->title) {
            $request->validate([
                'title' => 'unique:posts'
            ]);
        }

        $post->title = $request->title;
        $post->alias = Str::slug($request->title);
        $post->body = $request->body;

        if ($request->file('img')) {
            // With storage:link
            $path = Storage::putFile('public', $request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }

        $post->save();
        $post->categories()
            ->sync($request->category);

        return back()
            ->with('status', 'The post is updated successfully!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('delete', $post);

        $post->delete();

        return redirect()
            ->route('main');
    }
}
