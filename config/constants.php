<?php


// Define privileges ids constants based on controller actions
return [
	// Account privileges
	'accounts' => [
		'index'    					 => 'CULCNT',
		'show'                       => 'CULCNT',
		'store_role'                 => 'AGNROLCEN',
		'destroy_role'               => 'BAJROLCEN',
		'store_disabled_privilege'   => 'DBIPIL',
		'destroy_disabled_privilege' => 'HLIPIL',
		'activate'                   => 'AIVCEN',
		'deactivate'                 => 'IILCEN'
	],
	// Movement privileges
	'movements' => [
		'index' => 'CULMIE'
	],
	// Course privileges
	'courses' => [
		'index'           => 'CULCRS',
		'create'          => 'ALTCRS',
		'store'           => 'ALTCRS',
		'show'            => 'CULCRS',
		'edit'            => 'MFICRS',
		'update'          => 'MFICRS',
		'destroy'         => 'BAJCRS',
		'store_teacher'   => 'AGNPFECRS',
		'destroy_teacher' => 'BAJPFECRS',
	],
	// Catalogs privileges
	'catalogs' => [
		'index' => 'CULCLO',
		'display' => 'CULCLO',
		'address_js' => 'CULCLO',
		'datetimepicker_js' => 'CULCLO'
	],
	'groups' => [
		'index'   => 'CULGUP',
		'store'   => 'ALTGUP',
		'show'    => 'CULGUP',
		'update'  => 'MFIGUP',
		'destroy' => 'BAJGUP'
	],
	'periods' => [
		'index'   => 'CULPIOELA',
		'store'   => 'ALTPIOEOL',
		'show'    => 'CULPIOELA',
		'update'  => 'MFIPIOEOL',
		'destroy' => 'BAJPIOEOL'
	],
	'subjects'  => [
		'index'   => 'CULAAT',
		'store'   => 'ALTANA',
		'show'    => 'CULAAT',
		'update'  => 'MFIANA',
		'destroy' => 'BAJANA'
	],
	'diseases'  => [
		'index'   => '',
		'store'   => '',
		'show'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'clinics'  => [
		'index'   => '',
		'store'   => '',
		'show'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'addresses'  => [
		'index'   => '',
		'store'   => '',
		'show'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'federal-entities'  => [
		'index'   => '',
		'store'   => '',
		'show'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'roles'  => [
		'index'   => '',
		'store'   => '',
		'show'    => '',
		'update'  => '',
		'destroy' => ''
	],
	'privileges'  => [
		'index'   => '',
		'store'   => '',
		'show'    => '',
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
		'store'   => [
			'super_user'    => '',
			'administrator' => 'AGNROLASTC',
			'teacher'       => 'AGNROLPFEC',
			'intern'        => 'AGNROLPANC',
			'student'       => 'AGNROLEDIC',
		],
		'destroy' => [
			'super_user'    => '',
			'administrator' => 'BAJROLASTC',
			'teacher'       => 'BAJROLPFEC',
			'intern'        => 'BAJROLPANC',
			'student'       => 'BAJROLEDIC',
		]
	]
];