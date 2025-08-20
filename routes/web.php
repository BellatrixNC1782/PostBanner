<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('termsofusemobile', 'HomeController@termsofuseMobile')->name('termsofusemobile');
Route::get('privacypolicymobile', 'HomeController@privacyPolicyMobile')->name('privacypolicymobile');