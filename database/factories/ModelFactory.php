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
        'password' => bcrypt('password'),
        'activated' => true,
    ];
});

// Personal Informations Factory
$factory->define(App\PersonalInformation::class, function(Faker\Generator $faker) {
	$genders = ['H', 'M'];
	return [
		'name' => $faker->firstName,
		'last_name' => $faker->lastName,
		'mother_last_name' => $faker->lastName,
		'email' => $faker->email,
		'phone' => $faker->phoneNumber,
		'gender' => $faker->randomElement($genders)
	];
});

// Privileges Factory
$factory->define(App\Privilege::class, function(Faker\Generator $faker) {
	$privileges = ['add new user', 'add role to user', 'add format', 'update format', 'delete format', 'delete user', 'enable user', 'disable user'];
	return [
		'privilege_name' => $faker->unique()->randomElement($privileges),
	];
});

// Roles Factory
$factory->define(App\Role::class, function(Faker\Generator $faker) {
	$roles = ['super user', 'administrator', 'teacher', 'intern', 'student', 'patient'];
	return [
		'role_name' => $faker->unique()->randomElement($roles),
		'role_description' => $faker->sentence,
	];
});

// Federal Entities Factory
$factory->define(App\FederalEntity::class, function(Faker\Generator $faker) {
	return [
		'federal_entity_name' => $faker->unique()->state,
	];
});

// Addresses Factory
$factory->define(App\Address::class, function(Faker\Generator $faker) {
	return [
		'postal_code' => $faker->numerify('#####'),
		'settlement' => $faker->streetName,
		'municipality' => $faker->city,
	];
});

// Clinics Factory
$factory->define(App\Clinic::class, function(Faker\Generator $faker) {
	// $clinics = ['Almaraz', 'Acatlán', 'Cuautitlán', 'Ecatepec', 'Aragón',
	// 'Iztacala', 'Cuautepec', 'Molinito'];
	$clinics = ['Almaraz', 'Iztacala'];

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
	$semesters = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
	return [
		'subject_name'=> $faker->unique()->randomElement($subjects),
		'semester'=> $faker->randomElement($semesters),
	];
});

//Groups Factory
$factory->define(App\Group::class, function(Faker\Generator $faker) {
	return [
		'group_id'=> $faker->unique()->numerify('####'),
	];
});

// Periods Factory
$factory->define(App\Period::class, function(Faker\Generator $faker) {
	$period = $faker->randomElement($period =['1','2']);
	$age = $faker->unique()->numerify('20##');
	if($period == '1'){
		$start = $faker->numerify( $age.'-08-04');
		$end = $faker->numerify( $age.'-11-24');
	}else{
		$start = $faker->numerify( $age.'-01-04');
		$end = $faker->numerify( $age.'-05-24');
	}
	return [
		'period_id'=> $age. '-' . $period,
		'period_start_date'=> $start,
		'period_end_date'=> $end,
	];
});

// Diseases Factory
$factory->define(App\Disease::class, function(Faker\Generator $faker) {
	$type_of_disease = $faker->randomElement($type=['general', 'odontológica']);
	if($type_of_disease == 'dental'){
		$disease_id = $faker->unique()->numerify('d###');
	}else{
		$disease_id = $faker->unique()->numerify('m###');
	}
	return [
		'disease_id'=>$disease_id,
		'disease_name'=> $faker->sentence(6, true),
		'type_of_disease'=> $type_of_disease, 
	];
});

// Students Factory
$factory->define(App\Student::class, function(Faker\Generator $faker) {
	return [
		'account_number' => $faker->unique()->numerify('311######'),
	];
});

// Teachers Factory
$factory->define(App\Teacher::class, function(Faker\Generator $faker) {
	return [
		'RFC' => $faker->unique()->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
	];
});

// Interns Factory
$factory->define(App\Intern::class, function(Faker\Generator $faker) {
	return [
		'service_start_date' => (date('Y') . '-01-30'),
		'service_end_date' => (date('Y') . '-06-30'),
		'account_number' => $faker->unique()->numerify('311######'),
	];
});

// Patients Factory
$factory->define(App\Patient::class, function(Faker\Generator $faker) {
	$grades = ['kinder', 'primaria', 'medio superior', 'superior', 'posgrado', 'maestria', 'doctorado'];
	$civil_status = ['soltero', 'casado', 'viudo/a'];
	$services = ['IMSS', 'ISSTE'];
	$option = [0, 1];
	$medical_service = $faker->randomElement($option);
	$service_name = ($medical_service == 1 ? $faker->randomElement($services) : null);
	return [
		'age' => $faker->numberBetween(1, 100),
		'ocupation' => $faker->jobTitle,
		'school_grade' => $faker->randomElement($grades),
		'civil_status' => $faker->randomElement($civil_status),
		'phone' => $faker->phoneNumber,
		'has_medical_service' => $medical_service,
		'service_name' => $service_name,
	];
});

// Formats Factory
$factory->define(App\Format::class, function(Faker\Generator $faker) {
	$status = ['completado', 'no completado'];
	$option = [0, 1];
	return [
		'format_id'=> $faker->unique()->numerify('f###'),
		'medical_history_number'=> $faker->numerify('ab##cd##'),
		'hour_date_fill'=> $faker->dateTimeThisMonth($max='now'),
		'consultation_reason'=> $faker->text($maxNbChars = 50),
		'has_disease'=> $faker->randomElement($option),
		'other_disease'=> $faker->text($maxNbChars = 30),
		'medical_treatment'=> $faker->text($maxNbChars = 50),
		'therapeutic_used'=> $faker->text($maxNbChars = 30) ,
		'observations'=> $faker->text($maxNbChars = 150),
		'referred_by'=> $faker->name($gender = null|'male'|'female'),
		'format_status'=> $faker->randomElement($status),
		];
});

// Movements Factory
$factory->define(App\Movement::class, function(Faker\Generator $faker) {
	return [
		'timestamp' => $faker->date('Y-m-d H:i:s'),
		'ip' => $faker->ipv4,
	];
});
