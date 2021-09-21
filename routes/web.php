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

Route::get('/', 'Index\DashboardController@index')->name('dashboard');

Route::group([
    'prefix' => 'index'
],function(){
    
    Route::get('/','Index\DashboardController@index')->name('dashboard');    
    Route::get('/productDetail/{id}','Index\DashboardController@productDetail')->name('productDetail');    
    Route::Post('/postTracking/','Index\CustomPostTracking@postTracking')->name('index.postTracking');
    
});

Route::group([
	'prefix' => 'user'
],function () {

    Route::get('/', 'User\LoginController@create');
    Route::get('/dashboard', 'User\DashboardController@index')->name('dashboard');
    Route::get('/register', 'User\RegistrationController@create')->name('register');
    Route::post('/register', 'User\RegistrationController@store')->name('register');
    
    Route::get('/login', 'User\LoginController@create')->name('login');
    Route::post('/login', 'User\LoginController@login');
    Route::get('/logout', 'User\LoginController@logout');

    Route::get('/listAudioByCatagory/{id}','User\DashboardController@listAudioByCatagory')->name('user.listAudioByCatagory');
    Route::get('/listAudioByCatagoryId/{cate_id?}','User\DashboardController@listAudioByCatagoryId')->name('user.listAudioByCatagoryId');
    Route::get('/listAudio/{searching_word?}/{cat_id?}', 'User\DashboardController@listAudio')->name('user.listAudio');


});

Route::group([
	'prefix' => 'admin'
],function () {

    Route::get('/', 'Admin\LoginController@create');
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');

    Route::get('/register', 'Admin\RegistrationController@create')->name('register');
    Route::post('/register', 'Admin\RegistrationController@store')->name('register');
    
    Route::get('/login', 'Admin\LoginController@create')->name('login');
    Route::post('/login', 'Admin\LoginController@login');
    Route::get('/logout', 'Admin\LoginController@logout');

    Route::get('/product', 'Admin\ProductController@index')->name('product');
    Route::get('/addProduct', 'Admin\ProductController@create')->name('addProduct');
    Route::post('/addProduct', 'Admin\ProductController@save')->name('addProduct');
    Route::get('/editProduct/{id}', 'Admin\ProductController@edit')->name('editProduct');
    Route::post('/updateProduct', 'Admin\ProductController@update')->name('updateProduct');

    Route::get('/audio', 'Admin\AudioController@index')->name('audio');
    Route::get('/addAudio', 'Admin\AudioController@create')->name('addAudio');
    Route::post('/addAudio', 'Admin\AudioController@save')->name('addAudio');
    Route::get('/editAudio/{id}', 'Admin\AudioController@edit')->name('editAudio');
    Route::post('/updateAudio', 'Admin\AudioController@update')->name('updateAudio');
    Route::get('/updateAudioStatus/{id}', 'Admin\AudioController@updateAudioStatus')->name('updateAudioStatus');

    Route::get('/categories', 'Admin\CategoriesController@index')->name('categories');
    Route::get('/addCategory', 'Admin\CategoriesController@create')->name('addCategory');
    Route::post('/addCategory', 'Admin\CategoriesController@save')->name('addCategory');
    Route::get('/editCategory/{id}', 'Admin\CategoriesController@edit')->name('editCategory');
    Route::post('/updateCategory', 'Admin\CategoriesController@update')->name('updateCategory');
    Route::get('/deleteCategory/{id}', 'Admin\CategoriesController@delete')->name('deleteCategory');

    Route::get('/users', 'Admin\UserController@index')->name('users');
    Route::get('/updateUserStatus/{id}/{status}', 'Admin\UserController@updateUserStatus')->name('updateUserStatus');


});

Route::get('/about', function()
{
   return View::make('pages.contact');
});