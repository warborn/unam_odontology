<?php


// Define privileges ids constants based on controller actions
return [
	// Account privileges
	'accounts' => [
		'index'    					         => 'CULCNT',
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
		'index'             => 'CULCLO',
		'display'           => 'CULCLO',
		'address_js'        => 'CULCLO',
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
		'index'   => 'CULEME',
		'store'   => 'ALTERM',
		'show'    => 'CULEME',
		'update'  => 'MFIERM',
		'destroy' => 'BAJERM'
	],
	'clinics'  => [
		'index'   => 'CULCNI',
		'store'   => 'ALTCNI',
		'show'    => 'CULCNI',
		'update'  => 'MFICNI',
		'destroy' => 'BAJCNI'
	],
	'addresses'  => [
		'index'   => 'CULDCI',
		'store'   => 'ALTDCC',
		'show'    => 'CULDCI',
		'update'  => 'MFIDCC',
		'destroy' => 'BAJDCC'
	],
	'federal-entities'  => [
		'index'   => 'CULEDAFAT',
		'store'   => 'ALTEIDFRA',
		'show'    => 'CULEDAFAT',
		'update'  => 'MFIEIDFRA',
		'destroy' => 'BAJEIDFRA'
	],
	'roles'  => [
		'index'             => 'CULRLE',
		'store'             => 'ALTROL',
		'show'              => 'CULRLE',
		'update'            => 'MFIROL',
		'destroy'           => 'BAJROL',
		'index_privileges'  => 'CULPLEROL',
		'store_privilege'   => 'AGNPILROL',
		'destroy_privilege' => 'BAJPILROL'
	],
	'privileges'  => [
		'index'   => 'CULPLE',
		'store'   => 'ALTPIL',
		'show'    => 'CULPLE',
		'update'  => 'MFIPIL',
		'destroy' => 'BAJPIL'
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
			'super_user'    => 'AGNROLSPEU',
			'administrator' => 'AGNROLASTC',
			'teacher'       => 'AGNROLPFEC',
			'intern'        => 'AGNROLPANC',
			'student'       => 'AGNROLEDIC',
		],
		'destroy' => [
			'super_user'    => 'BAJROLSPEU',
			'administrator' => 'BAJROLASTC',
			'teacher'       => 'BAJROLPFEC',
			'intern'        => 'BAJROLPANC',
			'student'       => 'BAJROLEDIC',
		]
	]
];