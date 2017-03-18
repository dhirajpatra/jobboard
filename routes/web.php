
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

// route to show the login form
Route::get('/', [
    'as' => 'login',
    'uses' => 'HomeController@showLogin'
]);

// route to show the login form
Route::get('login', [
    'as' => 'login',
    'uses' => 'HomeController@showLogin'
]);

// route to process the login form
Route::post('/', [
    'as' => 'login_post',
    'uses' => 'HomeController@doLogin'
]);

// route to logout
Route::get('logout', [
    'as' => 'logout',
    'uses' => 'HomeController@doLogout'
])->middleware('auth');

// route to job posting
Route::get('jobpost', [
    'as' => 'jobpost',
    'uses' => 'JobpostController@showPost'
])->middleware('auth');

// route to job posting
Route::post('jobpost', [
    'as' => 'jobpost_post',
    'uses' => 'JobpostController@doPost'
])->middleware('auth');

// for moderator email activation of job posting
Route::get('jobpost/activation/{token}', [
    'as' => 'activation_path',
    'uses' => 'JobpostController@doActivate'
]);

// for moderator email activation of job posting
Route::get('jobpost/spam/{id}', [
    'as' => 'spam',
    'uses' => 'JobpostController@makeSpam'
]);
