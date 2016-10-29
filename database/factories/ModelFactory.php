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

// Federal Entities Factory
$factory->define(App\FederalEntity::class, function(Faker\Generator $faker) {
	return [
		'federal_entity_id' => $faker->unique()->state,
	];
});

// Addresses Factory
$factory->define(App\Address::class, function(Faker\Generator $faker) {
	return [
		'address_id' => $faker->unique()->numerify('AD##'),
		'postal_code' => $faker->postcode,
		'settlement' => $faker->streetName,
		'municipality' => $faker->city,
	];
});

// Clinics Factory
$factory->define(App\Clinic::class, function(Faker\Generator $faker) {
	$clinics = ['Acatlán', 'Cuautitlán', 'Almaraz', 'Ecatepec', 'Aragón',
	'Iztacala', 'Cuautepec', 'Molinito'];

	return [
		'clinic_id' => $faker->unique()->randomElement($clinics),
		'clinic_email' => $faker->email,
		'clinic_phone' => $faker->phoneNumber,
		'street' => $faker->streetAddress,
	];
});

// Subjects Factory
$factory->define(App\Subject::class, function(Faker\Generator $faker) {
	$subjects = ['dientes 1', 'dientes 2', 'dientes 3', 'sacando molares 1', 'sacando molares 2', 'terapeando al paciente 1', 'el raton de los dientes 1', 'anestesia local 1', 'anestesia local 2'];
	$semesters = ['1er', '2do', '3ro', '4to', '5to', '6to', '7mo', '8vo', '9no'];
	return [
		'subject_id'=> $faker->unique()->randomElement($subjects),
		'semester'=> $faker->randomElement($semesters),
	];
});

//Groups Factory
$factory->define(App\Group::class, function(Faker\Generator $faker) {
	return [
		'group_id'=> $faker->unique()->numerify('####'),
	];
});

