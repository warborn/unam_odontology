@extends('layouts.app')

@section('content')
<h1>Solicitud de Alumnos</h1>
<table class="table table-hover">
	<tr>
		<td><strong>Nombre del Alumno</strong></td>
		<td><strong>Asignatura</strong></td>
		<td><strong>Grupos</strong></td>
		<td><strong>Periodo</strong></td>
		<td><strong>Semestre</strong></td>
		<td>&nbsp;</td>
	</tr>
	@foreach($course->students as $student)
	<tr>
		<td>{{$student->user->personal_information->fullname()}}</td>
		<td>{{$course->subject->subject_name}}</td>
		<td>{{$course->group->group_id}}</td>
		<td>{{$course->period->period_id}}</td>
		<td>{{$course->subject->semester}}</td>
		<td><button type="button" class="btn btn-success">{{$student->pivot->status}}</button></td>
	</tr>
	@endforeach
</table>
@endsection