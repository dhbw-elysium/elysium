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

Route::when('*', 'csrf', array('post', 'put', 'delete'));


Route::group(array('before' => 'auth'), function() {
    Route::get('home', 'HomeController@showWelcome');
	Route::get('logout', 'AuthController@getLogout');
	Route::get('courses', 'CoursesController@showCourses');

	Route::get('docents/list.json', 'DocentsController@docentListForTable');
	Route::get('docents', 'DocentsController@showDocents');
	Route::get('docents/import', 'DocentsImportController@docentsImportUpload');
	Route::get('docents/import/upload', 'DocentsImportController@docentsImportUpload');
	Route::any('docents/import/process', 'DocentsImportController@docentsImportProcess');

	Route::get('docent/{did}', 'DocentController@showDocent');
	Route::get('docent/{did}/phone-{group}.json', 'DocentController@docentPhoneList');
	Route::post('docent/phone-update', 'DocentController@postDocentPhoneUpdate');
	Route::get('docent/{did}/data-form-{element}.json', 'DocentController@docentDataForm');
	Route::post('docent/{did}/data-form-{element}', 'DocentController@docentDataUpdate');
	Route::post('docent/status/add', 'DocentController@addStatusEntry');

    Route::get('user', 'UserController@showUsers');
    Route::get('user/list', 'UserController@showUsers');
    Route::post('user/delete', 'UserController@postUserDelete');
    Route::get('user/edit', 'UserController@showUsers');
    Route::get('user/new', 'UserController@createNewUser');
    Route::post('user/edit/updateNew', 'UserController@updateNewUser');
    Route::get('user/edit/{uid}', 'UserController@showUserEdit');
    Route::post('user/edit/update', 'UserController@postUserUpdate');
    Route::post('user/edit/update/password', 'UserController@postUserPasswordUpdate');

	Route::post('course/update', 'CoursesController@postCourseUpdate');
	Route::post('course/delete', 'CoursesController@postCourseDelete');
	Route::post('courseGroup/update', 'CoursesController@postCourseGroupUpdate');
	Route::post('courseGroup/delete', 'CoursesController@postCourseGroupDelete');

	Route::get('status', 'StatusController@showStatusList');
	Route::get('status/list', 'StatusController@showStatusList');
    Route::get('status/list-trash', 'StatusController@showStatusListTrash');
	Route::get('status/edit/{sid}', 'StatusController@showStatusEdit');
	Route::post('status/edit/{sid}', 'StatusController@postStatusEdit');
	Route::get('status/new', 'StatusController@showStatusEdit');
	Route::post('status/new', 'StatusController@postStatusEdit');

	Route::post('status/delete', 'StatusController@postStatusDelete');
    Route::post('status/restore', 'StatusController@postStatusRestore');

});
