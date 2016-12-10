@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<h1>Solicitud de Alumnos</h1>
</div>
</div>
<div class="table-responsive">
<table class="table table-hover table-striped">
	<tr>
		<th>Nombre del Alumno</th>
		<th>Asignatura</th>
		<th>Grupos</th>
		<th>Periodo</th>
		<th>Semestre</th>
		<th>Estado</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
	</tr>
	@foreach($course->students as $student)
	<tr>
		<td>{{$student->user->personal_information->fullname()}}</td>
		<td>{{$course->subject->subject_name}}</td>
		<td>{{$course->group->group_id}}</td>
		<td>{{$course->period->period_id}}</td>
		<td>{{$course->subject->semester}}</td>
		<td>{{translate_status($student->course_status($course))}}</td>
		@if($student->course_status($course) == 'accepted')
			@include('teachers._reject_button')
		@elseif($student->course_status($course) == 'rejected')
			@include('teachers._accept_button')
		@else
			@include('teachers._accept_button')
			@include('teachers._reject_button')
		@endif
	</tr>
	@endforeach
</table>
</div>
@endsection