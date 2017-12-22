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
Route::put('/admin-edit-member/{memberId}', 'web\admin\AdminController@updateMember')->middleware('admin-isLogin');
Route::get('/admin-edit-member/{memberId}', 'web\admin\AdminController@onEditMember')->middleware('admin-isLogin');
Route::put('/admin-update-author/{authorId}', 'web\admin\AdminController@updateAuthor')->middleware('admin-isLogin');
Route::post('/admin-create-book', 'web\admin\AdminController@uploadBook')->middleware('admin-isLogin');
Route::put('/admin-update-book/{bookId}', 'web\admin\AdminController@updateBook')->middleware('admin-isLogin');
Route::get('/admin-book/{bookId}', 'web\admin\AdminController@onBook')->middleware('admin-isLogin');
Route::get('/admin-books/publisher/{publisherId}/{type?}', 'web\admin\AdminController@onPublisherBooks')->middleware('admin-isLogin');
Route::get('/admin-books/author/{authorId}/{type?}', 'web\admin\AdminController@onAuthorBooks')->middleware('admin-isLogin');
Route::get('/admin-search/publishers', 'web\admin\AdminController@searchPublisher')->middleware('admin-isLogin');
Route::get('/admin-search/authors', 'web\admin\AdminController@searchAuthors')->middleware('admin-isLogin');
Route::get('/admin-search/books', 'web\admin\AdminController@searchBooks')->middleware('admin-isLogin');
Route::get('/admin-search/members', 'web\admin\AdminController@searchMembers')->middleware('admin-isLogin');
Route::get('/admin-news', 'web\admin\AdminController@news')->middleware('admin-isLogin');
Route::get('/admin-create-news', 'web\admin\AdminController@onCreateNews')->middleware('admin-isLogin');
Route::post('/admin-create-news', 'web\admin\AdminController@createNews')->middleware('admin-isLogin');
Route::get('/admin-edit-news/{newsId}', 'web\admin\AdminController@onEditNews')->middleware('admin-isLogin');
Route::put('/admin-edit-news/{newsId}', 'web\admin\AdminController@editNews')->middleware('admin-isLogin');
Route::delete('/admin-delete-news', 'web\admin\AdminController@deleteNews')->middleware('admin-isLogin');
Route::delete('/admin-delete-comment/book/{bookId}', 'web\admin\AdminController@deleteComment')->middleware('admin-isLogin');


Route::get('/publisher-login', 'web\publisher\PublisherController@onLogin');
Route::post('/publisher-login', 'web\publisher\PublisherController@checkLogin');
Route::get('/publisher-logout', 'web\publisher\PublisherController@onLogout')->middleware('publisher-isLogin');
Route::get('/publisher-dashboard', 'web\publisher\PublisherController@onDashboard')->middleware('publisher-isLogin');
Route::get('/publisher-books', 'web\publisher\PublisherController@onBooks')->middleware('publisher-isLogin');
Route::get('/publisher-profile', 'web\publisher\PublisherController@onProfile')->middleware('publisher-isLogin');
Route::get('/publisher-history', 'web\publisher\PublisherController@onHistory')->middleware('publisher-isLogin');
Route::get('/publisher-search/books', 'web\publisher\PublisherController@searchBook')->middleware('publisher-isLogin');
Route::get('/publisher-book/{bookId}', 'web\publisher\PublisherController@book')->middleware('publisher-isLogin');

Route::get('/', 'web\user\UserController@index');
Route::get('/recommend', 'web\user\UserController@onRecommend');
Route::get('/free', 'web\user\UserController@onFree');
Route::get('/discount', 'web\user\UserController@onDiscount');
Route::get('/user-login', 'web\user\UserController@onLogin');
Route::post('/user-login', 'web\user\UserController@checkLogin');
Route::get('/user-logout', 'web\user\UserController@logout')->middleware('user-isLogin');
Route::get('/user-register', 'web\user\UserController@onRegister');
Route::post('/user-register', 'web\user\UserController@register');
Route::get('/user-profile', 'web\user\UserController@onProfile')->middleware('user-isLogin');
Route::put('/user-update/{userId}', 'web\user\UserController@update')->middleware('user-isLogin');
Route::get('/user-books/{typeId}', 'web\user\UserController@books');
Route::get('/user-search-book', 'web\user\UserController@search');
Route::get('/newbooks', 'web\user\UserController@onNewBooks');
Route::get('/recommendBooks', 'web\user\UserController@onRecommendBooks');
Route::get('/freebooks', 'web\user\UserController@onFreeBooks');
Route::get('/discountbooks', 'web\user\UserController@onDiscountBooks');
Route::get('/publishers', 'web\user\UserController@onPublishers');
Route::get('/book/{bookId}', 'web\user\UserController@book');
Route::post('/user-comment/book/{bookId}', 'web\user\UserController@comment')->middleware('user-isLogin');
Route::get('/user-books/publisher/{publisherId}/{type?}', 'web\user\UserController@publisherBooks');
Route::get('/user-books', 'web\user\UserController@userBooks')->middleware('user-isLogin');
Route::get('/user-books/author/{authorId}/{type?}', 'web\user\UserController@authorBooks');
Route::get('/infos', 'web\user\UserController@onInfos');
Route::get('/info/{infoId}', 'web\user\UserController@info');
Route::post('/user-vote/book/{bookId}', 'web\user\UserController@vote')->middleware('user-isLogin');
Route::put('/user-edit-vote/book/{bookId}', 'web\user\UserController@editVote')->middleware('user-isLogin');
Route::get('/user-foget-pass', 'web\user\UserController@onForgetPassword');
Route::post('/send-email', 'web\user\UserController@sendEmail');
Route::get('/send-password-success', 'web\user\UserController@sendSuccess');
Route::get('/user-buy/book/{bookId}', 'web\user\UserController@buyBook')->middleware('user-isLogin');
Route::post('/user-bind', 'web\user\UserController@bind')->middleware('user-isLogin');
Route::put('/user-edit-bind/{bindId}', 'web\user\UserController@editBind')->middleware('user-isLogin');
