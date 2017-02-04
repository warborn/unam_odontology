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
	]

];