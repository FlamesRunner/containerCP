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
    return redirect('/dashboard');
});

Route::get('/home', function () {
	return redirect('/dashboard');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');

// User routes
Route::get('/dashboard/user/profile', 'UserController@index')->name('profile.view');
Route::post('/dashboard/user/profile/save', 'UserController@save')->name('profile.save');
Route::get('/dashboard/vm/list', 'VMController@index')->name('vm.list');

// Admin routes
Route::get('/dashboard/admin/nodes', 'NodeController@index')->name('admin.nodes');
Route::get('/dashboard/admin/users', 'AdminUserController@index')->name('admin.users');
Route::get('/dashboard/admin/users/edit/{uid}', 'AdminUserController@profile_index')->name('admin.profile');
Route::post('/dashboard/admin/users/save/{uid}', 'AdminUserController@save')->name('admin.profile.save');
Route::post('/dashboard/admin/users/delete/{uid}', 'AdminUserController@delete')->name('admin.profile.delete');