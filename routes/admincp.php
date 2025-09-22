<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'admincp\LoginController@index')->name('admincpmain');
Route::get('/login', 'admincp\LoginController@index')->name('admincp');
Route::post('/login', 'admincp\LoginController@login')->name('adminlogin');

Route::get('/forgotpassword', 'admincp\LoginController@forgotpassword')->name('forgotpassword');
Route::post('/sendforgotpassword', 'admincp\LoginController@sendforgotpassword')->name('sendforgotpassword');
Route::get('/adminverifyotp', 'admincp\LoginController@adminVerifyOtp')->name('adminverifyotp');
Route::post('/verifyforgototp', 'admincp\LoginController@verifyForgotOtp')->name('verifyforgototp');
Route::get('/adminresetpassword', 'admincp\LoginController@adminResetPassword')->name('adminresetpassword');
Route::get('/reset_password', 'admincp\LoginController@reset_password')->name('reset_password');
Route::post('/resetforgotpassword', 'admincp\LoginController@resetForgotPassword')->name('resetforgotpassword');
Route::get('/resendotp', 'admincp\LoginController@resendotp')->name('resendotp');

Route::group(['middleware' => ['admincp']], function () {
    
    Route::group(['middleware' => ['superadmin']], function () {
        //Setting  management
        Route::get('/settinglist', 'admincp\SettingController@settingList')->name('settinglist');
        Route::get('/getsettinglist', 'admincp\SettingController@getSettingList')->name('getsettinglist');
        Route::get('/addsetting', 'admincp\SettingController@addSetting')->name('addsetting');
        Route::post('/savesetting', 'admincp\SettingController@saveSetting')->name('savesetting');
        Route::get('/editsetting/{id}', 'admincp\SettingController@editSetting')->name('editsetting');
        Route::post('/updatesetting', 'admincp\SettingController@updateSetting')->name('updatesetting');

        //App version
        Route::get('appversion', 'admincp\AppVersionController@appVersion')->name('appversion');
        Route::post('updateverion', 'admincp\AppVersionController@appVersionUpdate')->name('updateverion');

    });
    
    Route::match(['get', 'post'], '/admincplogout', 'admincp\LoginController@admincplogout')->name('admincplogout');
    Route::get('/dashboard', 'admincp\DashboardController@index')->name('dashboard');
    
    Route::get('/getuserchart/{year}', 'admincp\DashboardController@getuserchart')->name('getuserchart')->where('year', '[0-9]+');

    //User management
    Route::get('/userlist', 'admincp\UserController@userList')->name('userlist');
    Route::get('/getuserlist', 'admincp\UserController@getUserList')->name('getuserlist');
    Route::get('/changeuserstatus/{id}', 'admincp\UserController@changeUserStatus')->name('changeuserstatus');
    Route::post('/updateuserstatus', 'admincp\UserController@updateUserStatus')->name('updateuserstatus');
    Route::get('/viewuser/{id}', 'admincp\UserController@viewUser')->name('viewuser');
    
    //Update profile
    Route::get('/profile', 'admincp\Profilecontroller@index')->name('profile');
    Route::post('/updateprofile', 'admincp\Profilecontroller@updateprofile')->name('updateprofile');

    //Change Password
    Route::get('/changepassword', 'admincp\ChangepasswordController@index')->name('changepassword');
    Route::post('/updatepassword', 'admincp\ChangepasswordController@updatepassword')->name('updatepassword');

    //Email  management
    Route::get('/emaillist', 'admincp\EmailController@emailList')->name('emaillist');
    Route::get('/getemaillist', 'admincp\EmailController@getEmailList')->name('getemaillist');
    Route::get('/addemail', 'admincp\EmailController@addEmail')->name('addemail');
    Route::post('/saveemail', 'admincp\EmailController@saveEmail')->name('saveemail');
    Route::get('/editemail/{id}', 'admincp\EmailController@editEmail')->name('editemail');
    Route::post('/updateemail', 'admincp\EmailController@updateEmail')->name('updateemail');
    Route::get('/changeemailstatus/{id}', 'admincp\EmailController@changeEmailStatus')->name('changeemailstatus');
    Route::post('/updateemailstatus', 'admincp\EmailController@updateEmailStatus')->name('updateemailstatus');

    //CMS
    Route::get('/cms', 'admincp\CmsController@index')->name('cms');
    Route::get('/getcms', 'admincp\CmsController@getCms')->name('getcms');
    Route::get('/addcms', 'admincp\CmsController@addcms')->name('addcms');
    Route::post('/savecms', 'admincp\CmsController@savecms')->name('savecms');
    Route::get('/editcms/{id}', 'admincp\CmsController@editCms')->name('editcms');
    Route::post('/updatecms', 'admincp\CmsController@updatecms')->name('updatecms');
    Route::post('/deletecms', 'admincp\CmsController@deleteCms')->name('deletecms');
    Route::get('/cmsdeletemodal/{id}', 'admincp\CmsController@cmsDeleteModal')->name('cmsdeletemodal');
    
});
