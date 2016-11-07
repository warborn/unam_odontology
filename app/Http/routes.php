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
Route::get('/subjects', 'SubjectsController@index');
Route::get('/privileges', 'PrivilegesController@index');
Route::get('/roles', 'RolesController@index');
Route::get('/federal-entities', 'FederalEntitiesController@index');
Route::get('/diseases', 'DiseasesController@index');
Route::get('/addresses', 'AddressesController@index');
Route::auth();

Route::get('/home', 'HomeController@index');
