<?php

function translate_status($status) {
	$new_status = $status == null ? 'no registrado' : $status;
	switch($status) {
		case 'pending' : $new_status =  'pendiente'; break;
		case 'accepted' : $new_status =  'aceptado'; break;
		case 'rejected' : $new_status =  'rechazado'; break;
	}
	return ucwords($new_status);
}

function translate_account_status($status) {
	$new_status = $status == null ? 'activa' : $status;
	switch($status) {
		case 'deleted' : $new_status =  'eliminada'; break;
		case 'disabled' : $new_status =  'deshabilitada'; break;
	}
	return ucwords($new_status);
}


function translate_student_status($status) {
	$new_status = $status == null ? 'no registrado' : $status;
	switch($status) {
		case 'pending' : $new_status =  'pendiente'; break;
		case 'accepted' : $new_status =  'aceptado'; break;
		case 'rechazado' : $new_status =  'rechazado'; break;
	}
	return ucwords($new_status);
}

function clinic() {
	return App\Clinic::find(session()->get('clinic_id'));
}

function account() {
	return App\Account::find(session()->get('account_id'));
}

function to_associative($array) {
	$new_array = [];
	foreach ($array as $element) {
		$new_array[$element] = $element;
	}
	return $new_array;
}