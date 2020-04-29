<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index($alias)
    {
        $category = Category::where('alias', Str::slug($alias))
            ->firstOrFail();

        $posts = Category::find($category->id)
            ->posts()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('category.index', ['category' => $category, 'posts' => $posts]);
    }
}
