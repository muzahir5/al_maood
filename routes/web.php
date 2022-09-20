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

Route::get('/', 'User\DashboardController@index')->name('dashboard');
Route::get('/privacy-policy', 'User\DashboardController@privacyPolicy')->name('privacy-policy');
// Route::get('/privacy-policy', function () {
//     return View::make('privacy-policy.blade.php');
// });

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

    Route::get('/audios/{status?}', 'User\AudioController@index')->name('audios');
    Route::get('/createAudio', 'User\AudioController@create')->name('createAudio');
    Route::post('/addAudio', 'User\AudioController@store')->name('addAudio');
    Route::get('/audios/{status?}', 'User\AudioController@index')->name('audios');
    Route::get('/editAudio/{id}', 'User\AudioController@edit')->name('editAudio');
    Route::post('/updateAudio', 'User\AudioController@update')->name('updateAudio');
});

Route::group([
	'prefix' => 'editor'
],function () {
    Route::get('/', 'Editor\LoginController@create');
    Route::get('/dashboard', 'Editor\DashboardController@index')->name('dashboard');
    // Route::get('/register', 'Editor\RegistrationController@create')->name('register');
    // Route::post('/register', 'Editor\RegistrationController@store')->name('register');
    Route::get('/login', 'Editor\LoginController@create')->name('login');
    Route::post('/login', 'Editor\LoginController@login');
    Route::get('/logout', 'Editor\LoginController@logout');

    Route::get('/createAudio', 'Editor\AudioController@create')->name('createAudio');
    Route::post('/addAudio', 'Editor\AudioController@store')->name('addAudio');
    Route::get('/audios/{status?}', 'Editor\AudioController@index')->name('audios');
    Route::get('/editAudio/{id}', 'Editor\AudioController@edit')->name('editAudio');
    Route::post('/updateAudio', 'Editor\AudioController@update')->name('updateAudio');
    Route::get('/updateAudioStatus/{id}', 'Editor\AudioController@updateAudioStatus')->name('updateAudioStatus');

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

    Route::get('/audio/{status?}', 'Admin\AudioController@index')->name('audio');
    Route::get('/addAudio', 'Admin\AudioController@create')->name('addAudio');
    Route::post('/addAudio', 'Admin\AudioController@save')->name('addAudio');
    Route::get('/editAudio/{id}', 'Admin\AudioController@edit')->name('editAudio');
    Route::post('/updateAudio', 'Admin\AudioController@update')->name('updateAudio');
    Route::get('/updateAudioStatus/{id}', 'Admin\AudioController@updateAudioStatus')->name('updateAudioStatus');

    Route::get('/video/{status?}', 'Admin\VideoController@index')->name('video');
    Route::get('/addVideo', 'Admin\VideoController@create')->name('addVideo');
    Route::post('/addVideo', 'Admin\VideoController@save')->name('addVideo');
    // Route::get('/editVideo/{id}', 'Admin\VideoController@edit')->name('editVideo');
    // Route::post('/updateVideo', 'Admin\VideoController@update')->name('updateVideo');
    // Route::get('/updateVideoStatus/{id}', 'Admin\VideoController@updateVideoStatus')->name('updateAudioStatus');

    Route::get('/categories', 'Admin\CategoriesController@index')->name('categories');
    Route::get('/addCategory', 'Admin\CategoriesController@create')->name('addCategory');
    Route::post('/addCategory', 'Admin\CategoriesController@save')->name('addCategory');
    Route::get('/editCategory/{id}', 'Admin\CategoriesController@edit')->name('editCategory');
    Route::post('/updateCategory', 'Admin\CategoriesController@update')->name('updateCategory');
    Route::get('/deleteCategory/{id}', 'Admin\CategoriesController@delete')->name('deleteCategory');

    Route::get('/locations', 'Admin\LocationsController@index')->name('locations');
    Route::get('/addLocation', 'Admin\LocationsController@create')->name('addLocation');
    Route::post('/addLocation', 'Admin\LocationsController@save')->name('addLocation');
    Route::get('/editLocation/{id}', 'Admin\LocationsController@edit')->name('editLocation');
    Route::post('/updateLocation', 'Admin\LocationsController@update')->name('updateLocation');
    Route::get('/deleteLocation/{id}', 'Admin\LocationsController@delete')->name('deleteLocation');

    Route::get('/languages', 'Admin\LanguagesController@index')->name('language');
    Route::get('/addLanguage', 'Admin\LanguagesController@create')->name('addLanguage');
    Route::post('/addLanguage', 'Admin\LanguagesController@save')->name('addLanguage');
    Route::get('/editLanguage/{id}', 'Admin\LanguagesController@edit')->name('editLanguage');
    Route::post('/updateLanguage', 'Admin\LanguagesController@update')->name('updateLanguage');
    Route::get('/deleteLanguage/{id}', 'Admin\LanguagesController@delete')->name('deleteLanguage');

    Route::get('/users', 'Admin\UserController@index')->name('users');
    Route::post('/updateUser', 'Admin\UserController@updateUser')->name('updateUser');
    Route::get('/updateUserStatus/{id}/{status}', 'Admin\UserController@updateUserStatus')->name('updateUserStatus');
    Route::get('/editUser/{id}', 'Admin\UserController@edit')->name('editUser');

    Route::get('/narrators', 'Admin\NarratorController@index')->name('narrator');
    Route::get('/addNarrator', 'Admin\NarratorController@create')->name('addNarrator');
    Route::post('/addNarrator', 'Admin\NarratorController@save')->name('addNarrator');
    Route::get('/editNarrator/{id}', 'Admin\NarratorController@edit')->name('editNarrator');
    Route::post('/updateNarrator', 'Admin\NarratorController@update')->name('updateNarrator');
    Route::get('/deleteNarrator/{id}', 'Admin\NarratorController@delete')->name('deleteNarrator');
    Route::get('/updateNarratorStatus/{id}', 'Admin\NarratorController@updateNarratorStatus')->name('updateNarratorStatus');

});

Route::get('/about', function()
{
   return View::make('pages.contact');
});