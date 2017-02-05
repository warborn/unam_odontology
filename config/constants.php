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


	// Role ids
	'id' => [
		'super_user' => 'SPEUAR',
		'administrator' => 'ADMINISTRA',
		'teacher' => 'PROFESOR',
		'intern' => 'PASANTE',
		'student' => 'ESTUDIANTE'
	] 

];