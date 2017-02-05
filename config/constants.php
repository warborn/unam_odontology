<?php


// Define privileges ids constants based on controller actions
return [
	// Format privileges
	'formats' => [
		'index' 					=> 'CULFMA',
	  'create'          => 'ALTFMA',
	  'store'           => 'ALTFMA',
	  'show'            => 'CULFMA',
	  'edit'            => 'MFIFMA',
	  'update'          => 'MFIFMA',
	  'store_student'   => 'AGNEDIFMA',
	  'destroy_student' => 'BAJEDIFMA'
	],
	// Teacher privileges
	'teachers' => [
		'index_courses' => 'CULCRSANA',
		'show_course'  => 'CULCRSANA',
		'update_student_status' => 'GIOSITCRS'
	],
	// Student privileges
	'students' => [
		'index_courses' => 'CULCRSAER',
		'store_course' => 'SCICRS',
		'destroy_course' => 'SCICRS',
		'update_course_request' => 'SCICRS',
	  'index_accepted_courses'   => 'AGNEDIFMA',
	],


	// Role ids
	'id' => [
		'super_user' => 'SPEUAR',
		'administrator' => 'ADMINISTRA',
		'teacher' => 'PROFESOR',
		'intern' => 'PASANTE',
		'student' => 'ESTUDIANTE'
	] 

];