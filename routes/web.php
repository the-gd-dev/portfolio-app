<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'auth:web', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::resource('home', 'HomeController');
    Route::resource('about', 'AboutController');
    Route::resource('resume', 'ResumesController');
    Route::resource('portfolio-categories', 'PortfolioCategoriesController');
    Route::resource('portfolios', 'PortfoliosController');
    Route::resource('services', 'ServicesController');
    Route::resource('skills', 'SkillsController');
    Route::resource('profiles', 'ProfilesController');
    Route::resource('user-skills', 'UserSkillsController');
    Route::resource('contact-form', 'ContactController');

    //Bulk Actions
    Route::post('services-bulk/{action}', 'ServicesController@bulkAction')->name('services.bulk');
    Route::post('portfolios-bulk/{action}', 'PortfoliosController@bulkAction')->name('portfolios.bulk');
    Route::post('portfolio-categories-bulk/{action}', 'PortfolioCategoriesController@bulkAction')->name('portfolio-categories.bulk');
    Route::post('skills-bulk/{action}', 'SkillsController@bulkAction')->name('skills.bulk');
    Route::post('profiles-bulk/{action}', 'ProfilesController@bulkAction')->name('profiles.bulk');
    Route::post('contact-form-bulk/{action}', 'ContactController@bulkAction')->name('contact-form.bulk');

  
    Route::post('contacts-settings', 'ContactController@updateSettings')->name('contacts.settings');
    Route::get('contacts-settings', 'ContactController@getContactSettings');
    Route::post('services-icon', 'ServicesController@saveIcon')->name('services.icons');
    Route::post('services-colors', 'ServicesController@setColors')->name('services.colors');
    Route::post('services-settings', 'ServicesController@updateSettings')->name('services.settings');
    Route::get('services-settings', 'ServicesController@getServicesSettings');

    Route::post('portfolios-images', 'PortfoliosController@portfolioImages')->name('portfolio.images');
    Route::post('portfolio-settings', 'PortfoliosController@updateSettings')->name('portfolio.settings');
    Route::get('portfolio-settings', 'PortfoliosController@getPortfolioSettings');
    

    // Qualifications Routes
    Route::post('resume-qualifications-add', 'ResumesController@addQualifications')->name('resume.qual.add');
    Route::post('resume-qualifications-save', 'ResumesController@saveQualifications')->name('resume.qual.save');
    Route::post('resume-qualifications-delete', 'ResumesController@deleteQualifications')->name('resume.qual.del');
    // Experience Routes
    Route::post('resume-experiences-save', 'ResumesController@saveExperiences')->name('resume.exp.save');
    Route::post('resume-experiences-add', 'ResumesController@addExperiences')->name('resume.exp.add');
    Route::post('resume-experiences-remove', 'ResumesController@removeExperiences')->name('resume.exp.del');
    Route::post('profiles-skills', 'ProfilesController@getSkills')->name('profiles.skills');
    
    Route::post('skills-icon', 'SkillsController@saveIcon')->name('skills.icons');
    Route::post('skills-colors', 'SkillsController@setColors')->name('skills.colors');
    Route::get('user-skills', 'UserSkillsController@getUserSkills')->name('users.skills');
    Route::post('user-skills-order', 'UserSkillsController@setOrder')->name('user-skills.order');
    Route::post('about-image', 'AboutController@imageUpload')->name('about.image');
    Route::post('home-bannner', 'HomeController@bannerUpload')->name('home.banner');
});
Route::resource('contacts', 'ContactController');
Route::get('/{id}', 'RootController@index');
Route::get('project/{id}', 'RootController@getProjectDetails')->name('project.show');
