<?php

namespace App\Providers;

use App\Category;
use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // All categories
        View::composer('includes.categories', function ($view) {
            if (!Cache::has('category')) {
                Cache::put('category', Category::all());
            }
            $view->with('categories', Cache::get('category'));
        });

        // Views today
        View::composer('includes.sidebar', function ($view) {
            $posts = Post::with('categories')
                ->where('updated_at', '>=', Carbon::today())
                ->orderBy('views_today', 'desc')
                ->limit(3)
                ->get();
            $view->with('posts', $posts);
        });
    }
}
