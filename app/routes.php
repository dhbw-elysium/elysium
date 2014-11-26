<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@showWelcome');


// Authentication
Route::get('login', array('as' => 'login', 'uses' => 'AuthController@showLogin'));
Route::post('login', 'AuthController@postLogin');

Route::group(array('before' => 'auth'), function() {
    Route::get('home', 'HomeController@showWelcome');
	Route::get('logout', 'AuthController@getLogout');
	Route::get('courses', 'CoursesController@showCourses');
	Route::get('docents', 'DocentsController@showDocents');
	Route::get('docent', 'DocentController@showDocent');
});
