<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::singularResourceParameters();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalogs', function() {
	return view('catalogs.index');
});

Route::resource('groups', 'GroupsController', ['except' => ['create', 'edit']]);
Route::resource('periods', 'PeriodsController', ['except' => ['create', 'edit']]);
Route::resource('subjects', 'SubjectsController', ['except' => ['create', 'edit']]);
Route::resource('privileges', 'PrivilegesController', ['except' => ['create', 'edit']]);
Route::resource('roles', 'RolesController', ['except' => ['create', 'edit']]);
Route::resource('diseases', 'DiseasesController', ['except' => ['create', 'edit']]);
Route::resource('federal-entities', 'FederalEntitiesController', ['except' => ['create', 'edit']]);
Route::resource('addresses', 'AddressesController', ['except' => ['create', 'edit']]);
Route::resource('clinics', 'ClinicsController', ['except' => ['create', 'edit']]);
Route::resource('courses', 'CoursesController');
Route::auth();

Route::get('/courses', 'CoursesController@index');
Route::get('/courses/create', 'CoursesController@create');
Route::post('/courses', 'CoursesController@store');
Route::patch('/courses/{course}', 'CoursesController@update');
Route::delete('/courses/{course}', 'CoursesController@destroy');

Route::get('/teacher/courses', 'TeachersController@index_courses');
Route::get('/teacher/courses/{course}', 'TeachersController@show_course');

Route::get('/student/courses', 'StudentsController@index_courses');
Route::get('/student/course/{course}', 'StudentsController@store_course');

Route::get('/home', 'HomeController@index');
