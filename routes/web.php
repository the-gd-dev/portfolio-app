<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        // Login Routes...
        Route::get('/login', 'LoginController@showLoginForm')->name('login');
        Route::post('/login', 'LoginController@login');
        // Logout Routes...
        Route::post('/logout', 'LoginController@logout')->name('logout');
        // Registration Routes...
        Route::get('/register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('/register', 'RegisterController@register');
        // Password Reset Routes...
        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.update');
        // Password Confirmation Routes...
        Route::get('/password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('/password/confirm', 'ConfirmPasswordController@confirm');
        // Email Verification Routes...
        Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
        Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');
    });
    Route::group(['middleware' => 'auth:web', 'namespace' => 'Admin' , 'as' => 'admin.'], function () {
        Route::resource('home', 'HomeController');
        Route::resource('about', 'AboutController');
        Route::resource('resume', 'ResumesController');
        
        // Qualifications Routes
        Route::post('resume-qualifications-add', 'ResumesController@addQualifications')->name('resume.qual.add');
        Route::post('resume-qualifications-save', 'ResumesController@saveQualifications')->name('resume.qual.save');
        Route::post('resume-qualifications-delete', 'ResumesController@deleteQualifications')->name('resume.qual.del');
        // Experience Routes
        Route::post('resume-experiences-save', 'ResumesController@saveExperiences')->name('resume.exp.save');
        Route::post('resume-experiences-add', 'ResumesController@addExperiences')->name('resume.exp.add');
        Route::post('resume-experiences-remove', 'ResumesController@removeExperiences')->name('resume.exp.del');
        Route::resource('profiles', 'ProfilesController');
        Route::post('profiles-skills', 'ProfilesController@getSkills')->name('profiles.skills');
        Route::resource('skills', 'SkillsController');
        Route::post('skills-icon', 'SkillsController@saveIcon')->name('skills.icons'); 
        Route::post('skills-colors', 'SkillsController@setColors')->name('skills.colors'); 
        Route::resource('user-skills', 'UserSkillsController');
        Route::get('user-skills', 'UserSkillsController@getUserSkills')->name('users.skills');
        Route::post('user-skills-order', 'UserSkillsController@setOrder')->name('user-skills.order');
        Route::post('about-image', 'AboutController@imageUpload')->name('about.image');
        Route::post('home-bannner', 'HomeController@bannerUpload')->name('home.banner');
    });
});
Route::get('/{id}', 'RootController@index');
