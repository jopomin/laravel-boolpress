<?php

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

Route::get('/', 'HomeController@index')->name('guest.home');

Route::get('/posts', 'PostController@index')->name('guest.posts.index');
Route::get('/posts/{slug}', 'PostController@show')->name('guest.posts.show');

Route::get('/categories', 'CategoryController@index')->name('guest.categories.index');
Route::get('/categories/{slug}', 'CategoryController@show')->name('guest.categories.show');

Auth::routes();

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'HomeController@index')->name('admin-home');
        Route::get('/profile', 'HomeController@profile')->name('admin-profile');
        Route::post('/profile/generate-token', 'HomeController@generateToken')->name('admin.generateToken');
        Route::resource('/posts', 'PostController');
    });

