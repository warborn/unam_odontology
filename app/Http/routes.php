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

Route::get('/catalogs', 'CatalogsController@index');
Route::get('/catalogs/address-js', 'CatalogsController@address_js');
Route::get('/catalogs/{view}', 'CatalogsController@display');

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
Route::resource('formats', 'FormatsController', ['except' => 'destroy']);

Route::auth();
Route::get('user/activation/{token}', 'Auth\AuthController@activate_user')->name('user.activate');

Route::get('/addresses/postal-code/{code}', 'AddressesController@index_by_postal_code');

Route::post('/courses/{course}/teachers/', 'CoursesController@store_teacher');
Route::delete('/courses/{course}/teachers/{teacher}', 'CoursesController@destroy_teacher');

Route::get('/teacher/courses', 'TeachersController@index_courses');
Route::get('/teacher/courses/{course}', 'TeachersController@show_course');
Route::patch('/teacher/courses/{course}/students/{student}', 'TeachersController@update_student_status');


Route::get('/student/{student}/courses', 'StudentsController@index_accepted_courses');
Route::get('/student/courses', 'StudentsController@index_courses');
Route::post('/student/course/{course}', 'StudentsController@store_course');
Route::delete('/student/course/{course}', 'StudentsController@destroy_course');

Route::get('/movements', 'MovementsController@index');

Route::get('/roles/{role}/privileges', 'RolesController@index_privileges');
Route::post('/roles/{role}/privileges', 'RolesController@store_privilege');
Route::delete('/roles/{role}/privileges/{privilege}', 'RolesController@destroy_privilege');

Route::get('/accounts', 'AccountsController@index')->name('accounts.index');
Route::get('/accounts/{user}', 'AccountsController@show');
Route::post('/accounts/{user}/roles', 'AccountsController@store_role');
Route::delete('/accounts/{user}/roles/{role}', 'AccountsController@destroy_role');
Route::post('/accounts/{user}/privileges/{privilege}', 'AccountsController@store_disabled_privilege');
Route::delete('/accounts/{user}/privileges/{privilege}', 'AccountsController@destroy_disabled_privilege');
Route::post('/accounts/{user}/deactivate', 'AccountsController@deactivate');
Route::delete('/accounts/{user}/activate', 'AccountsController@activate');

Route::post('/formats/{format}/students', 'FormatsController@store_student');
Route::delete('/formats/{format}/students/{student}', 'FormatsController@destroy_student');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/my-profile', 'UsersController@profile');
Route::patch('/password', 'UsersController@update_password');
