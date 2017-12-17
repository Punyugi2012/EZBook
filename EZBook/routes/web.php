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
Route::get('/admin-authors', 'web\admin\AdminController@onAuthors')->middleware('admin-isLogin');
Route::get('/admin-books', 'web\admin\AdminController@onBooks')->middleware('admin-isLogin');
Route::get('/admin-regis-publisher', 'web\admin\AdminController@registerPublisher')->middleware('admin-isLogin');
Route::get('/admin-regis-author', 'web\admin\AdminController@registerAuthor')->middleware('admin-isLogin');
Route::post('/admin-create-publisher', 'web\admin\AdminController@createPublisher')->middleware('admin-isLogin');
Route::get('/admin-edit-publisher/{publisherId}', 'web\admin\AdminController@onEditPublisher')->middleware('admin-isLogin');
Route::put('/admin-update-publisher/{publisherId}', 'web\admin\AdminController@updatePublisher')->middleware('admin-isLogin');
Route::post('/admin-create-author', 'web\admin\AdminController@createAuthor')->middleware('admin-isLogin');
Route::get('/admin-edit-author/{authorId}', 'web\admin\AdminController@onEditAuthor')->middleware('admin-isLogin');
Route::put('/admin-update-author/{authorId}', 'web\admin\AdminController@updateAuthor')->middleware('admin-isLogin');
Route::post('/admin-create-book', 'web\admin\AdminController@uploadBook')->middleware('admin-isLogin');
Route::put('/admin-update-book/{bookId}', 'web\admin\AdminController@updateBook')->middleware('admin-isLogin');
Route::get('/admin-book/{bookId}', 'web\admin\AdminController@onBook')->middleware('admin-isLogin');
Route::get('/admin-books/publisher/{publisherId}/{type?}', 'web\admin\AdminController@onPublisherBooks')->middleware('admin-isLogin');
Route::get('/admin-books/author/{authorId}/{type?}', 'web\admin\AdminController@onAuthorBooks')->middleware('admin-isLogin');
Route::get('/admin-search/publishers', 'web\admin\AdminController@searchPublisers')->middleware('admin-isLogin');
Route::get('/admin-search/authors', 'web\admin\AdminController@searchAuthors')->middleware('admin-isLogin');
Route::get('/admin-search/books', 'web\admin\AdminController@searchBooks')->middleware('admin-isLogin');


Route::get('/publisher-login', 'web\publisher\PublisherController@onLogin');
Route::post('/publisher-login', 'web\publisher\PublisherController@checkLogin');
Route::get('/publisher-logout', 'web\publisher\PublisherController@onLogout');
Route::get('/publisher-dashboard', 'web\publisher\PublisherController@onDashboard')->middleware('publisher-isLogin');
Route::get('/publisher-books', 'web\publisher\PublisherController@onBooks')->middleware('publisher-isLogin');
Route::get('/publisher-profile', 'web\publisher\PublisherController@onProfile')->middleware('publisher-isLogin');
Route::get('/publisher-history', 'web\publisher\PublisherController@onHistory')->middleware('publisher-isLogin');
Route::get('/publisher-search/books', 'web\publisher\PublisherController@searchBook')->middleware('publisher-isLogin');

