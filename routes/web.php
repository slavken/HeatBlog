<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', 'PostController@index')->name('main');
Route::get('about', 'IndexController@about');
Route::get('contact', 'IndexController@contact');
Route::get('category/{alias}', 'CategoryController@index')->name('category.show');
Route::post('comment/{id}', 'CommentController@store')->name('comment.store');
Route::resource('post', 'PostController');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('home/posts', 'HomeController@posts');
    Route::get('home/comments', 'CommentController@index');
    Route::get('home/settings', 'HomeController@settings');
    Route::match(['get', 'post'], 'change/email', 'HomeController@updateEmail');
    Route::match(['get', 'post'], 'change/username', 'HomeController@updateUsername');
    Route::match(['get', 'post'], 'change/password', 'HomeController@updatePassword');
    Route::delete('home/comments/{id}', 'CommentController@destroy')->name('home.comments.destroy');
    Route::resource('post', 'PostController', ['except' => ['index', 'show']]);

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'role'], function () {
        Route::get('/', 'HomeController@index')->name('admin.dashboard');
        Route::get('posts', 'PostController@index')->name('posts.index');
        Route::get('cache/clear/{key?}', 'CacheController@clear')->name('cache.clear');
        Route::get('confirm/email/{id}', 'HomeController@confirmEmail')->name('confirm.email');
        Route::match(['get', 'post'], 'roles/{id}/add', 'RoleController@add')->name('roles.add');
        Route::match(['get', 'post'], 'change/{id}/email', 'HomeController@updateEmail')->name('change.email');
        Route::match(['get', 'post'], 'change/{id}/username', 'HomeController@updateUsername')->name('change.username');
        Route::match(['get', 'post'], 'change/{id}/password', 'HomeController@updatePassword')->name('change.password');
        Route::delete('roles/{id}/delete', 'RoleController@delete')->name('roles.delete');
        Route::resource('categories', 'CategoryController')->middleware('can:categories');
        Route::resource('roles', 'RoleController')->middleware('can:roles');
        Route::resource('permissions', 'PermissionController')->middleware('can:permissions');
        Route::resources([
            'users' => 'UserController',
            'comments' => 'CommentController',
            'cache' => 'CacheController'
        ]);
    });
});