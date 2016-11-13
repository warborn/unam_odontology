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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalogs', function() {
	return view('catalogs.index');
});

Route::get('/groups', 'GroupsController@index');
Route::post('/groups', 'GroupsController@store');
Route::patch('/groups/{group}', 'GroupsController@update');
Route::delete('/groups/{group}', 'GroupsController@destroy');

Route::get('/periods', 'PeriodsController@index');
Route::post('/periods', 'PeriodsController@store');
Route::patch('/periods/{period}', 'PeriodsController@update');
Route::delete('/periods/{period}', 'PeriodsController@destroy');

Route::get('/subjects', 'SubjectsController@index');
Route::post('/subjects', 'SubjectsController@store');
Route::patch('/subjects/{subject}', 'SubjectsController@update');
Route::delete('/subjects/{subject}', 'SubjectsController@destroy');

Route::get('/privileges', 'PrivilegesController@index');
Route::post('/privileges', 'PrivilegesController@store');
Route::patch('/privileges/{privilege}', 'PrivilegesController@update');
Route::delete('/privileges/{privilege}', 'PrivilegesController@destroy');

Route::get('/roles', 'RolesController@index');
Route::post('/roles', 'RolesController@store');
Route::patch('/roles/{role}', 'RolesController@update');
Route::delete('/roles/{role}', 'RolesController@destroy');

Route::get('/federal-entities', 'FederalEntitiesController@index');
Route::post('/federal-entities', 'FederalEntitiesController@store');
Route::patch('/federal-entities/{federalEntities}', 'FederalEntitiesController@update');
Route::delete('/federal-entities/{federalEntities}', 'FederalEntitiesController@destroy');

Route::get('/diseases', 'DiseasesController@index');
Route::post('/diseases', 'DiseasesController@store');
Route::patch('/diseases/{disease}', 'DiseasesController@update');
Route::delete('/diseases/{disease}', 'DiseasesController@destroy');

Route::get('/addresses', 'AddressesController@index');
Route::post('/addresses', 'AddressesController@store');
Route::patch('/addresses/{address}', 'AddressesController@update');
Route::delete('/addresses/{address}', 'AddressesController@destroy');

Route::get('/clinics', 'ClinicsController@index');
Route::post('/clinics', 'ClinicsController@store');
Route::patch('/clinics/{clinic}', 'ClinicsController@update');
Route::delete('/clinics/{clinic}', 'ClinicsController@destroy');
Route::auth();

Route::get('/courses', 'CoursesController@index');
Route::get('/courses/create', 'CoursesController@create');
Route::post('/courses', 'CoursesController@store');
Route::patch('/courses/{course}', 'CoursesController@update');
Route::delete('/courses/{course}', 'CoursesController@destroy');

Route::get('/home', 'HomeController@index');
