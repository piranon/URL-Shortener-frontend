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

Route::get('/', 'HomeController@index')->name('home');
Route::post('/create', 'HomeController@create')->name('create');

// Authentication Routes...
Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout')->name('logout');

Route::get('/admin', 'AdminController@index')->name('admin');
Route::post('/admin/delete', 'AdminController@delete')->name('admin/delete');
Route::post('/admin/search', 'AdminController@search')->name('admin/search');
