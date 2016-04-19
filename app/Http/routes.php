<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function(){
    //Route::Auth();
	$this->get('inter-backend', ['as' => 'internal.login', 'uses' => 'Auth\AuthController@showLoginForm']);
	$this->post('chk-login-bkn', ['as' => 'internal.post.login', 'uses' => 'Auth\AuthController@login']);
	$this->get('inter-logout', ['as' => 'internal.logout', 'uses' => 'Auth\AuthController@logout']);

	// Registration Routes...
	$this->get('register', 'Auth\AuthController@showRegistrationForm');
	$this->post('register', 'Auth\AuthController@register');

	// Password Reset Routes...
	$this->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
	$this->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
	$this->post('password/reset', 'Auth\PasswordController@reset');

	Route::get('/', function(){ return view('welcome');	});

});

/* Backend Internal User */
Route::group(['prefix' => 'internal-bkn', 'middleware' => ['web','auth']], function () {
    Route::get('/dashboard',    ['as' => 'admin.dashboard', 	'uses' => 'BackendController@getDashboard']);
    Route::get('/change-password', ['as' => 'admin.change.password', 'uses' => 'BackendController@changePassword']);
    Route::post('/update-password', ['as' => 'admin.update.password', 'uses' => 'BackendController@updatePassword']);
    Route::get('/check-password',  ['as' => 'admin.check.password', 'uses' => 'BackendController@checkCurrentPassword']);

    Route::get('/manage-menu',  ['as' => 'admin.menu.list', 	'uses' => 'BackendMenuController@index']);
    Route::get('/loading-menu-list', ['as' => 'admin.menu.pagination', 'uses' => 'BackendMenuController@pagination']);
    Route::get('/create-menu',  ['as' => 'admin.menu.create', 	'uses' => 'BackendMenuController@create']);
    Route::post('/insert-menu', ['as' => 'admin.menu.insert', 	'uses' => 'BackendMenuController@store']);
    Route::get('/edit-menu',    ['as' => 'admin.menu.edit', 	'uses' => 'BackendMenuController@edit']);
    Route::post('/update-menu', ['as' => 'admin.menu.update', 	'uses' => 'BackendMenuController@update']);
    Route::post('/search-menu', ['as' => 'admin.menu.search', 	'uses' => 'BackendMenuController@search']);
    Route::get('/delete-menu',  ['as' => 'admin.menu.delete', 	'uses' => 'BackendMenuController@destroy']);
    Route::get('/change-status-menu', ['as' => 'admin.menu.status', 	 'uses' => 'BackendMenuController@updateStatus']);
    Route::get('/content-type-menu',  ['as' => 'admin.menu.content.type','uses' => 'BackendMenuController@changeContentType']);
    Route::get('/check-link-menu',    ['as' => 'admin.menu.checklink', 	 'uses' => 'BackendMenuController@checkLink']);

    Route::get('/manage-article',       ['as' => 'admin.article.list', 	 'uses' => 'BackendArticleController@index']);
    Route::get('/loading-article-list', ['as' => 'admin.article.pagination', 'uses' => 'BackendArticleController@pagination']);
    Route::get('/create-article',       ['as' => 'admin.article.create', 'uses' => 'BackendArticleController@create']);
    Route::post('/insert-article',      ['as' => 'admin.article.insert', 'uses' => 'BackendArticleController@store']);
    Route::get('/edit-article',         ['as' => 'admin.article.edit', 	 'uses' => 'BackendArticleController@edit']);
    Route::post('/update-article',      ['as' => 'admin.article.update', 'uses' => 'BackendArticleController@update']);
    Route::post('/search-article',      ['as' => 'admin.article.search', 'uses' => 'BackendArticleController@search']);
    Route::get('/delete-article',       ['as' => 'admin.article.delete', 'uses' => 'BackendArticleController@destroy']);
    Route::get('/change-status-article',['as' => 'admin.article.status', 'uses' => 'BackendArticleController@updateStatus']);

    Route::get('/manage-contact',  ['as' => 'admin.contact.list', 		 'uses' => 'BackendArticleController@contact']);
    Route::post('/update-contact', ['as' => 'admin.contact.update', 	 'uses' => 'BackendArticleController@contactUpdate']);

    Route::get('/manage-category', ['as' => 'admin.category.list',       'uses' => 'BackendCategoryController@index']);
    Route::get('/loading-category-list',['as' => 'admin.category.pagination',  'uses' => 'BackendCategoryController@pagination']);
    Route::get('/create-category', ['as' => 'admin.category.create', 	 'uses' => 'BackendCategoryController@create']);
    Route::post('/insert-category',['as' => 'admin.category.insert', 	 'uses' => 'BackendCategoryController@store']);
    Route::get('/edit-category',   ['as' => 'admin.category.edit', 		 'uses' => 'BackendCategoryController@edit']);
    Route::post('/update-category',['as' => 'admin.category.update', 	 'uses' => 'BackendCategoryController@update']);
    Route::post('/search-category',['as' => 'admin.category.search', 	 'uses' => 'BackendCategoryController@search']);
    Route::get('/delete-category', ['as' => 'admin.category.delete',     'uses' => 'BackendCategoryController@destroy']);
    Route::get('/change-status-category',['as' => 'admin.category.status','uses' => 'BackendCategoryController@updateStatus']);
    Route::get('/change-front-category',['as' => 'admin.category.front','uses' => 'BackendCategoryController@updateFront']);

    Route::get('/manage-sub-category', ['as' => 'admin.subcategory.list', 'uses' => 'BackendCategorySubController@index']);
    Route::get('/loading-sub-category-list',['as' => 'admin.subcategory.pagination',  'uses' => 'BackendCategorySubController@pagination']);
    Route::get('/create-sub-category', ['as' => 'admin.subcategory.create',     'uses' => 'BackendCategorySubController@create']);
    Route::post('/insert-sub-category',['as' => 'admin.subcategory.insert',     'uses' => 'BackendCategorySubController@store']);
    Route::get('/edit-sub-category',   ['as' => 'admin.subcategory.edit',       'uses' => 'BackendCategorySubController@edit']);
    Route::post('/update-sub-category',['as' => 'admin.subcategory.update',     'uses' => 'BackendCategorySubController@update']);
    Route::post('/search-sub-category',['as' => 'admin.subcategory.search',     'uses' => 'BackendCategorySubController@search']);
    Route::get('/delete-sub-category', ['as' => 'admin.subcategory.delete',     'uses' => 'BackendCategorySubController@destroy']);
    Route::get('/change-status-sub-category',['as' => 'admin.subcategory.status','uses' => 'BackendCategorySubController@updateStatus']);

	Route::get('/manage-slideshow',        ['as' => 'admin.slideshow.list', 	 'uses' => 'BackendSlideshowController@index']);
    Route::get('/loading-slideshow-list',  ['as' => 'admin.slideshow.pagination','uses' => 'BackendSlideshowController@pagination']);
    Route::post('/insert-slideshow',       ['as' => 'admin.slideshow.insert',    'uses' => 'BackendSlideshowController@store']);
    Route::get('/change-status-slideshow', ['as' => 'admin.slideshow.status',    'uses' => 'BackendSlideshowController@updateStatus']);
    Route::get('/delete-slideshow',        ['as' => 'admin.slideshow.delete',    'uses' => 'BackendSlideshowController@destroy']);
    Route::get('/re-order',                ['as' => 'admin.slideshow.reorder',   'uses' => 'BackendSlideshowController@reOrder']);

	Route::get('/manage-gallery',       ['as' => 'admin.gallery.list', 		 'uses' => 'BackendGalleryController@index']);
    Route::get('/loading-gallery-list', ['as' => 'admin.gallery.pagination', 'uses' => 'BackendGalleryController@pagination']);
    Route::any('/insert-gallery',       ['as' => 'admin.gallery.insert', 	 'uses' => 'BackendGalleryController@store']);
    Route::post('/search-gallery',      ['as' => 'admin.gallery.search', 	 'uses' => 'BackendGalleryController@search']);
    Route::get('/delete-gallery',       ['as' => 'admin.gallery.delete', 	 'uses' => 'BackendGalleryController@destroy']);
    Route::get('/change-status-gallery',['as' => 'admin.gallery.status',     'uses' => 'BackendGalleryController@updateStatus']);

    Route::get('/add-photo-gallery/{id}',    ['as' => 'admin.gallery.addphoto',   'uses' => 'BackendGalleryController@addPhoto']);
    Route::post('/insert-photo-gallery',['as' => 'admin.gallery.insert.photo','uses'=> 'BackendGalleryController@insertPhoto']);
    Route::get('/delete-photo-gallery',    ['as' => 'admin.gallery.removephoto',   'uses' => 'BackendGalleryController@removePhoto']);
});