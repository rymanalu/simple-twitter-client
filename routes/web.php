<?php

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

Route::get('/', 'WelcomeController')->name('welcome');

Route::get('auth/login', 'AuthController@login')->name('auth::login');

Route::get('auth/callback', 'AuthController@callback')->name('auth::callback');

Route::get('auth/error', 'AuthController@error')->name('auth::error');

Route::get('auth/logout', 'AuthController@logout')->name('auth::logout');

Route::get('home', 'HomeController@index')->name('home');

Route::post('tweet', 'TweetController@store')->name('tweet');
