<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// Users Factory
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->userName,
        'password' => bcrypt($faker->password),
    ];
});

// Personal Informations Factory
$factory->define(App\PersonalInformation::class, function(Faker\Generator $faker) {
	return [
		'user_name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'mother_last_name' => $faker->lastName,
		'email' => $faker->email,
	];
});

// Privileges Factory
$factory->define(App\Privilege::class, function(Faker\Generator $faker) {
	$privileges = ['add format', 'update format', 'delete format', 'delete user', 'enable user', 'disable user'];
	return [
		'privilege_id' => $faker->unique()->numerify('PR#'),
		'privilege' => $faker->unique()->randomElement($privileges),
	];
});

// Roles Factory
$factory->define(App\Role::class, function(Faker\Generator $faker) {
	$roles = ['super user', 'administrator', 'teacher', 'intern', 'student', 'patient'];
	return [
		'role_id' => $faker->unique()->randomElement($roles),
		'role_description' => $faker->sentence,
	];
});
