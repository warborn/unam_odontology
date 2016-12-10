@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
<h1>Grupos Asignados</h1>	
</div>
</div>
<div class="table-responsive">
<table class="table table-hover table-striped">
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
</div>
@endsection