<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'Api'
], function(){
    Route::post('/user/userRegister/', 'UserController@userRegister')->name('api.user.userRegister');
    Route::post('/user/userLogin/', 'UserController@userLogin')->name('api.user.userLogin');
    Route::post('/user/userLogout/', 'UserController@userLogout')->name('api.user.userLogout');
    Route::post('/user/userUpdate/', 'UserController@userUpdate')->name('api.user.userUpdate');
    Route::post('/user/forgot_password', 'UserController@password_forgot')->name('api.user.forgot_password');
    Route::post('/user/update_password', 'UserController@update_password')->name('api.user.update_password');
    Route::post('/user/change_password', 'UserController@change_password')->name('api.user.change_password'); //not on forgot

    Route::get('/user/getUserById/', 'UserController@getUserById')->name('api.user.getUserById');
    Route::get('/user/userSearch/', 'UserController@userSearch')->name('api.user.userSearch');

// Other Controller nnn
    Route::get('/user/getProducts/', 'UserController@getProducts')->name('api.user.getProducts');

    Route::get('/user/getCategories/', 'AudioController@getCategories')->name('api.user.getCategories');
    Route::get('/user/listAudioByCatagory/{categ_id}/{lang?}', 'AudioController@listAudioByCatagory')->name('api.user.listAudioByCatagory');
    Route::get('/user/listAudio/', 'AudioController@listAudio')->name('api.user.listAudio');    
    Route::get('/user/listAudioBYUser/', 'AudioController@listAudioBYUser')->name('api.user.listAudioBYUser');
    Route::get('/user/showAudio/', 'AudioController@showAudio')->name('api.user.showAudio');
    Route::post('/user/addAudio/', 'AudioController@addAudio')->name('api.user.addAudio');
    Route::post('/user/UpdateAudio/', 'AudioController@UpdateAudio')->name('api.user.UpdateAudio');
    Route::post('/user/updateAudioStatus/', 'AudioController@updateAudioStatus')->name('api.user.updateAudioStatus');
    Route::post('/user/updateAudioPlayeCount/', 'AudioController@updateAudioPlayeCount')->name('api.user.updateAudioPlayeCount');

    Route::post('/user/addFavourite/', 'AudioController@addFavourite')->name('api.user.addFavourite');
    Route::post('/user/removeFavourite/', 'AudioController@removeFavourite')->name('api.user.removeFavourite');
    Route::get('/user/FavouriteList/{user_id?}', 'AudioController@FavouriteList')->name('api.user.FavouriteList');

    //sharing audio with friends
    Route::post('/user/sharePost/', 'AudioController@sharePost')->name('api.user.sharePost');

    Route::get('/user/postTracking/', 'UserController@postTracking')->name('api.user.postTracking');    

    Route::post('/user/addFriend/', 'UserController@addFriend')->name('api.user.addFriend');
    Route::post('/user/modifyFriendStatus/', 'UserController@modifyFriendStatus')->name('api.user.modifyFriendStatus');
    Route::get('/user/listFriends/', 'UserController@listFriends')->name('api.user.listFriends');

    Route::post('/user/sendSms/', 'UserController@sendSms')->name('api.user.sendSms');
    Route::get('/user/showSms/', 'UserController@showSms')->name('api.user.showSms');

    Route::post('/user/userPaidByPost/', 'UserController@userPaidByPost')->name('api.user.userPaidByPost');
    Route::post('/user/userEarning/', 'UserController@userEarning')->name('api.user.userEarning');
    Route::get('/user/showWallet/{user_id}', 'UserController@showWallet')->name('api.user.showWallet');
    Route::post('/user/withDrawRequest/', 'UserController@withDrawRequest')->name('api.user.withDrawRequest');
});