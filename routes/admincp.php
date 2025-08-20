<?php

Route::get('/', 'admincp\LoginController@index')->name('admincp');
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

Route::post('/product_excel_upload', 'admincp\MerchandiseController@productExcelUpload')->name('product_excel_upload');

Route::group(['middleware' => ['admincp']], function () {
    Route::post('addcurrentusertimezone', 'admincp\DashboardController@addcurrentusertimezone')->name('addcurrentusertimezone');

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
    
    //Update profile
    Route::get('/profile', 'admincp\Profilecontroller@index')->name('profile');
    Route::post('/updateprofile', 'admincp\Profilecontroller@updateprofile')->name('updateprofile');

    //Change Password
    Route::get('/changepassword', 'admincp\ChangepasswordController@index')->name('changepassword');
    Route::post('/updatepassword', 'admincp\ChangepasswordController@updatepassword')->name('updatepassword');        
        
    //CMS
    Route::get('/cms', 'admincp\CmsController@index')->name('cms');
    Route::get('/getcms', 'admincp\CmsController@getCms')->name('getcms');
    Route::get('/addcms', 'admincp\CmsController@addcms')->name('addcms');
    Route::post('/savecms', 'admincp\CmsController@savecms')->name('savecms');
    Route::get('/editcms/{id}', 'admincp\CmsController@editCms')->name('editcms');
    Route::post('/updatecms', 'admincp\CmsController@updatecms')->name('updatecms');
    Route::post('/deletecms', 'admincp\CmsController@deleteCms')->name('deletecms');
    Route::get('/cmsdeletemodal/{id}', 'admincp\CmsController@cmsDeleteModal')->name('cmsdeletemodal');

    //FAQ
    Route::get('/faq', 'admincp\FaqController@index')->name('faq');
    Route::get('/getfaq', 'admincp\FaqController@getFaq')->name('getfaq');
    Route::get('/addfaq', 'admincp\FaqController@addfaq')->name('addfaq');
    Route::post('/savefaq', 'admincp\FaqController@savefaq')->name('savefaq');
    Route::get('/editfaq/{id}', 'admincp\FaqController@editFaq')->name('editfaq');
    Route::post('/updatefaq', 'admincp\FaqController@updatefaq')->name('updatefaq');
    Route::post('/deletefaq', 'admincp\FaqController@deleteFaq')->name('deletefaq');
    Route::get('/faqdeletemodal/{id}', 'admincp\FaqController@faqDeleteModal')->name('faqdeletemodal');
    Route::get('/changefaqstatusmodal/{id}', 'admincp\FaqController@changeFaqStatus')->name('changefaqstatusmodal');
    Route::post('/updatfaqstatus', 'admincp\FaqController@updateFaqStatus')->name('updatfaqstatus'); 

    //Email  management
    Route::get('/emaillist', 'admincp\EmailController@emailList')->name('emaillist');
    Route::get('/getemaillist', 'admincp\EmailController@getEmailList')->name('getemaillist');
    Route::get('/addemail', 'admincp\EmailController@addEmail')->name('addemail');
    Route::post('/saveemail', 'admincp\EmailController@saveEmail')->name('saveemail');
    Route::get('/editemail/{id}', 'admincp\EmailController@editEmail')->name('editemail');
    Route::post('/updateemail', 'admincp\EmailController@updateEmail')->name('updateemail');
    Route::get('/changeemailstatus/{id}', 'admincp\EmailController@changeEmailStatus')->name('changeemailstatus');
    Route::post('/updateemailstatus', 'admincp\EmailController@updateEmailStatus')->name('updateemailstatus');

    // Notification
    Route::get('/notification', 'admincp\NotificationController@index')->name('notification');
    Route::get('/getnotification', 'admincp\NotificationController@getNotification')->name('getnotification');
    Route::get('/addnotification', 'admincp\NotificationController@addNotification')->name('addnotification');
    Route::post('/savenotification', 'admincp\NotificationController@saveNotification')->name('savenotification');
    Route::get('/editnotification/{id}', 'admincp\NotificationController@editNotification')->name('editnotification');
    Route::post('/updatenotification', 'admincp\NotificationController@updateNotification')->name('updatenotification');
    Route::get('/deletemodalnotification/{id}', 'admincp\NotificationController@deleteModalNotification')->name('deletemodalnotification');
    Route::post('/deletenotification', 'admincp\NotificationController@deleteNotification')->name('deletenotification');
    
});
