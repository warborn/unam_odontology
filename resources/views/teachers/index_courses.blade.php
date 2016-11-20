@extends('layouts.app')

@section('content')
<h1>Grupos Asignados</h1>
<table class="table table-hover">
	<tr>
		<th>Asignatura</th>
		<th>Grupos</th>
		<th>Periodo</th>
		<th>&nbsp;</th>
	</tr>
	@foreach($courses as $course)
	<tr>
		<td>{{$course->subject->subject_name}}</td>
		<td>{{$course->group->group_id}}</td>
		<td>{{$course->period->period_id}}</td>
		<td><a class="btn btn-primary" href="{{url('teacher/courses/' . $course->course_id)}}">Ir a grupo</a></td>
	</tr>
	@endforeach
</table>
@endsection