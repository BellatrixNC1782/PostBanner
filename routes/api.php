<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Login
Route::post('login', 'v1\LoginController@login');

//Verify & resend
Route::post('verifyotp', 'v1\VerifyController@verifyOtp');
Route::post('resendotp', 'v1\VerifyController@resendOtp');
Route::post('resendtokenmail', 'v1\LoginController@resendTokenMail');

//Forgot reset password
Route::post('forgotresetpassword', 'v1\LoginController@forgotResetPassword');
Route::post('forgotpassword', 'v1\LoginController@forgotPassword');

//Config
Route::Get('getconfig/{config_key}/{device_type}', 'v1\ConfigController@getconfig');
Route::post('getappversion', 'v1\AppVersionController@getAppVersion');

//Category list
Route::Get('getcategorylist', 'v1\ConfigController@getCategoryList');

Route::post('adddevicetoken', 'v1\LoginController@addDeviceToken');
    
//Get Poster
Route::post('getposterlist', 'v1\PosterController@getPosterList');

Route::group(['middleware' => ['jwt.verify']], function() {
    
    //Profile
    Route::post('updateprofile', 'v1\LoginController@updateProfile');
    Route::get('userdetails', 'v1\UserController@userDetails');
    
    //Get dashboard
    Route::post('getdashboard', 'v1\DashboardController@getDashboard');
    
    //Logout
    Route::get('logout/{uu_id}', 'v1\LogoutController@logout');
    
    //Notifications
    Route::put('notificationonoff', 'v1\NotificationController@notificationOnOff');
    Route::post('notificationlist','v1\NotificationController@notificationlist');   
    Route::get('unreadcount','v1\NotificationController@unreadCount');
    
    Route::delete('deleteuser', 'v1\UserController@deleteUser');
    
    //Business Profile
    Route::post('addupdatebusinessprofile', 'v1\BusinessProfileController@addUpdateBusinessProfile');
    Route::get('getbusinessdetail', 'v1\BusinessProfileController@getBusinessDetail');    
    Route::delete('deletebusinessdetail', 'v1\BusinessProfileController@deleteBusinessDetail');
    
    //Saved Poster
    Route::post('addupdatesavedposter', 'v1\SavedPosterController@addUpdateSavedPoster');
    Route::get('getsavedposterlist', 'v1\SavedPosterController@getSavedPosterlist');
    Route::delete('deletesavedposter/{saved_poster_id}', 'v1\SavedPosterController@deleteSavedPoster');
});
