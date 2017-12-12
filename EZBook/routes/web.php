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
Route::get('/admin-dashboard', 'web\admin\AdminController@onDashboard');
