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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/active', 'ActiveController@index')->middleware('auth');
Route::get('/home/route', 'RouteController@index')->middleware('auth');
Route::get('/worktable', 'WorktableController@index');
Route::get('/map', 'MapController@index');
Route::get('/admin', 'AdminController@index')->middleware('is_admin')->name('admin');
Route::get('/documentation', 'DocumentationController@index');

