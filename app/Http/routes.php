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
})->middleware('auth');

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
Route::get('user/activation/{token}', 'Auth\AuthController@activate_user')->name('user.activate');

Route::get('/courses', 'CoursesController@index');
Route::get('/courses/create', 'CoursesController@create');
Route::post('/courses', 'CoursesController@store');
Route::patch('/courses/{course}', 'CoursesController@update');
Route::delete('/courses/{course}', 'CoursesController@destroy');
Route::post('/courses/{course}/teachers/', 'CoursesController@store_teacher');
Route::delete('/courses/{course}/teachers/{teacher}', 'CoursesController@destroy_teacher');

Route::get('/teacher/courses', 'TeachersController@index_courses');
Route::get('/teacher/courses/{course}', 'TeachersController@show_course');
Route::patch('/teacher/courses/{course}/students/{student}', 'TeachersController@update_student');


Route::get('/student/{student}/courses', 'StudentsController@index_accepted_courses');
Route::get('/student/courses', 'StudentsController@index_courses');
Route::post('/student/course/{course}', 'StudentsController@store_course');
Route::delete('/student/course/{course}', 'StudentsController@destroy_course');

Route::get('/movements', 'MovementsController@index');

Route::get('/roles/{role}/privileges', 'RolesController@index_privileges');
Route::post('/roles/{role}/privileges', 'RolesController@store_privilege');
Route::delete('/roles/{role}/privileges/{privilege}', 'RolesController@destroy_privilege');

Route::get('/accounts', 'AccountsController@index');
Route::get('/accounts/{account}', 'AccountsController@show');
Route::post('/accounts/{account}/roles', 'AccountsController@store_role');
Route::delete('/accounts/{account}/roles/{role}', 'AccountsController@destroy_role');
Route::post('/accounts/{account}/privileges/{privilege}', 'AccountsController@store_disabled_privilege');
Route::delete('/accounts/{account}/privileges/{privilege}', 'AccountsController@destroy_disabled_privilege');
Route::post('/accounts/{account}/deactivate', 'AccountsController@deactivate');
Route::delete('/accounts/{account}/activate', 'AccountsController@activate');

// Route::get('/patients', 'PatientsController@index');
// Route::get('/patients/{patient}/formats/create', 'FormatsController@create');
// Route::post('/patients/{patient}/formats', 'FormatsController@store');

Route::get('/formats', 'FormatsController@index');
Route::get('/formats/create', 'FormatsController@create');
Route::post('/formats', 'FormatsController@store');
Route::get('/formats/{format}', 'FormatsController@show');
Route::get('/formats/{format}/edit', 'FormatsController@edit');
Route::patch('/formats/{format}', 'FormatsController@update');
Route::delete('/formats/{format}', 'FormatsController@destroy');
Route::post('/formats/{format}/students', 'FormatsController@store_student');
Route::delete('/formats/{format}/students/{student}', 'FormatsController@destroy_student');

Route::get('/home', 'HomeController@index');
Route::get('/my-profile', 'UsersController@profile');
Route::patch('/password', 'UsersController@update_password');
