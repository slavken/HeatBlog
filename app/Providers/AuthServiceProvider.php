<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Post' => 'App\Policies\PostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Actions
        Gate::define('update-posts', function ($user) {
            return $user->permission('update-posts');
        });

        Gate::define('delete-posts', function ($user) {
            return $user->permission('delete-posts');
        });

        Gate::define('update-users', function ($user) {
            return $user->permission('update-users');
        });

        Gate::define('delete-users', function ($user) {
            return $user->permission('delete-users');
        });

        Gate::define('update-comments', function ($user) {
            return $user->permission('update-comments');
        });

        Gate::define('delete-comments', function ($user) {
            return $user->permission('delete-comments');
        });

        // Views
        Gate::define('users', function ($user) {
            return $user->permission('users');
        });

        Gate::define('categories', function ($user) {
            return $user->permission('categories');
        });

        Gate::define('cache', function ($user) {
            return $user->permission('cache');
        });

        Gate::define('roles', function ($user) {
            return $user->permission('roles');
        });

        Gate::define('permissions', function ($user) {
            return $user->permission('permissions');
        });
    }
}
