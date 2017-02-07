<?php


// Define privileges ids constants based on controller actions
return [
	// Account privileges
	'accounts' => [
		'index'    => 'CULCNT',
		'show'     => 'CULCNT',
		'store_role' => 'AGNROLCEN',
		'destroy_role' => 'BAJROLCEN',
		'store_disabled_privilege' => 'DBIPIL',
		'destroy_disabled_privilege' => 'HLIPIL',
		'activate' => 'AIVCEN',
		'deactivate' => 'IILCEN'
	],
	'movements' => [
		'index' => 'CULMIE'
	],
	'subjects'  => [
		'create'  => '',
		'store'   => '',
		'show'    => '',
		'edit'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'diseases'  => [
		'create'  => '',
		'store'   => '',
		'show'    => '',
		'edit'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'groups' => [
		'create'  => '',
		'store'   => '',
		'show'    => '',
		'edit'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'periods' => [
		'create'  => '',
		'store'   => '',
		'show'    => '',
		'edit'    => '',
		'update'  => '',
		'destroy' => ''
	],

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
		'index_courses' 				=> 'CULCRSANA',
		'show_course'  					=> 'CULCRSANA',
		'update_student_status' => 'GIOSITCRS'
	],
	// Student privileges
	'students' => [
		'index_courses'				 		 => 'CULCRSAER',
		'store_course'				 	   => 'SCICRS',
		'destroy_course' 				   => 'SCICRS',
		'update_course_request' 	 => 'SCICRS',
	  'index_accepted_courses'   => 'AGNEDIFMA',
	],


	// Role ids
	'id' => [
		'super_user'    => 'SPEUAR',
		'administrator' => 'ADMINISTRA',
		'teacher'       => 'PROFESOR',
		'intern'        => 'PASANTE',
		'student'       => 'ESTUDIANTE'
	],
	// Role assignation privileges
	'role' => [
		'store' => [
			'super_user' => '',
			'administrator' => 'AGNROLASTC',
			'teacher' => 'AGNROLPFEC',
			'intern' => 'AGNROLPANC',
			'student' => 'AGNROLEDIC',
		],
		'destroy' => [
			'super_user' => '',
			'administrator' => 'BAJROLASTC',
			'teacher' => 'BAJROLPFEC',
			'intern' => 'BAJROLPANC',
			'student' => 'BAJROLEDIC',
		]
	]
];