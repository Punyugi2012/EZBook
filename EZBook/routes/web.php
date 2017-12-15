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
Route::get('/home', 'web\HomeController@onHome');

Route::get('/admin-login', 'web\admin\AdminController@onLogin');
Route::post('/admin-login', 'web\admin\AdminController@checkLogin');
Route::get('/admin-dashboard', 'web\admin\AdminController@onDashboard')->middleware('admin-isLogin');
Route::get('/admin-logout', 'web\admin\AdminController@logout')->middleware('admin-isLogin');
Route::get('/admin-publishers', 'web\admin\AdminController@onPublishers')->middleware('admin-isLogin');
Route::get('/admin-uploadbooks', 'web\admin\AdminController@onUploadBooks')->middleware('admin-isLogin');
Route::get('/admin-members', 'web\admin\AdminController@onMembers')->middleware('admin-isLogin');
Route::get('/admin-books', 'web\admin\AdminController@onBooks')->middleware('admin-isLogin');
Route::get('/admin-regis-publisher', 'web\admin\AdminController@registerPublisher')->middleware('admin-isLogin');
Route::post('/admin-create-publisher', 'web\admin\AdminController@createPublisher')->middleware('admin-isLogin');
Route::post('/admin-create-book', 'web\admin\AdminController@uploadBook')->middleware('admin-isLogin');
Route::get('/admin-book/{bookId}/publisher/{publisherId}', 'web\admin\AdminController@onBook')->middleware('admin-isLogin');

