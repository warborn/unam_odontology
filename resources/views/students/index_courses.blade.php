@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
		<h1>Cursos</h1>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-hover table-striped">
		<tr>
			<th>Asignatura</th>
			<th>Grupo</th>
			<th>Periodo</th>
			<th>Semestre</th>
			<th>Estado</th>
			<th>&nbsp;</th>
		</tr>
		@foreach($courses as $course)
		<tr>
			<td>{{$course->subject->subject_name}}</td>
			<td>{{$course->group->group_id}}</td>
			<td>{{$course->period->period_id}}</td>
			<td>{{$course->subject->semester}}</td>
			<td>{{translate_status($student->course_status($course))}}</td>
			@if(account()->allow_action('students.update_course_request'))
				@if($student->course_status($course) != 'accepted')
				<td>
					<form action="{{url('student/course/' . $course->course_id )}}" method="POST">
						@if ($course->has_student($student))
						{{ method_field('DELETE') }}
						<input type="submit" value="Cancelar" class="btn btn-danger">
						@else
						<input type="submit" value="Alta" class="btn btn-primary">
						@endif
					</form>
				</td>
				@else
				<td></td>
				@endif
			@endif
		</tr>
		@endforeach
	</table>
</div>
@endsection