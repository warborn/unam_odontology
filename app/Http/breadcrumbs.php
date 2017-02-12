<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs) {
	$breadcrumbs->push('Inicio', route('home'));
});

// Accounts
Breadcrumbs::register('accounts.index', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Cuentas', route('accounts.index'));
});

Breadcrumbs::register('accounts.show', function($breadcrumbs, $account) {
	$breadcrumbs->parent('accounts.index');
	$breadcrumbs->push($account->user_id, route('accounts.show', $account->user_id));
});

// Movements
Breadcrumbs::register('movements.index', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Movimientos', route('movements.index'));
});

// Courses
Breadcrumbs::register('courses.index', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Cursos', route('courses.index'));
});

Breadcrumbs::register('courses.create', function($breadcrumbs) {
	$breadcrumbs->parent('courses.index');
	$breadcrumbs->push('Agregar Curso', route('courses.create'));
});

Breadcrumbs::register('courses.show', function($breadcrumbs, $course) {
	$breadcrumbs->parent('courses.index');
	$breadcrumbs->push('Administrar Profesores', route('courses.show', $course->course_id));
});

Breadcrumbs::register('courses.edit', function($breadcrumbs, $course) {
	$breadcrumbs->parent('courses.index');
	$breadcrumbs->push('Editar Curso', route('courses.edit', $course->course_id));
});

// Catalogs
Breadcrumbs::register('catalogs.index', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Catalogos', route('catalogs.index'));
});

// Roles
Breadcrumbs::register('roles.index_privileges', function($breadcrumbs, $role) {
	$breadcrumbs->parent('catalogs.index');
	$breadcrumbs->push('Administrar Privilegios', route('roles.index_privileges', $role->role_id));
});

// Teachers
Breadcrumbs::register('teachers.index_courses', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Cursos Asignados', route('teachers.index_courses'));
});

Breadcrumbs::register('teachers.show_course', function($breadcrumbs, $course) {
	$breadcrumbs->parent('teachers.index_courses');
	$breadcrumbs->push('Administrar Curso', route('teachers.show_course', $course->course_id));
});

// Students
Breadcrumbs::register('students.index_courses', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Cursos Disponibles', route('students.index_courses'));
});

// Formats
Breadcrumbs::register('formats.index', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Formatos', route('formats.index'));
});

Breadcrumbs::register('formats.create', function($breadcrumbs) {
	$breadcrumbs->parent('formats.index');
	$breadcrumbs->push('Agregar', route('formats.create'));
});

Breadcrumbs::register('formats.show', function($breadcrumbs, $format) {
	$breadcrumbs->parent('formats.index');
	$breadcrumbs->push('Ver', route('formats.show', $format->format_id));
});

Breadcrumbs::register('formats.edit', function($breadcrumbs, $format) {
	$breadcrumbs->parent('formats.index');
	$breadcrumbs->push('Editar', route('formats.edit', $format->format_id));
});

// User
Breadcrumbs::register('users.profile', function($breadcrumbs) {
	$breadcrumbs->parent('home');
	$breadcrumbs->push('Mi Perfil', route('users.profile'));
});