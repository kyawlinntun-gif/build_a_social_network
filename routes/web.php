<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/dashboard', 'PostController@dashboard')->name('dashboard')->middleware('auth');

Route::resource('/post', 'PostController')->except('update');
Route::post('/post/update', 'PostController@update')->name('post.update'); 

Route::resource('/account', 'AccountController');

Route::post('/like', 'PostController@postLike')->name('like');
