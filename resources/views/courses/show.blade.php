@extends('layouts.app')
@section('content')
@include('shared._alerts')

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
	</div>
</div>

@if(account()->allow_action('courses.store_teacher'))
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<h3>Curso: {{$course->info()}}</h3>

		@if(count($users) > 0)
		{{ Form::open(['action' => ['CoursesController@store_teacher', $course->course_id], 'class' => 'form-inline']) }}
		<div class="form-group">
			{{ Form::select('user_id', $users, null, ['class' => 'form-control'] )}}
		</div>
		{{ Form::submit('Agregar profesor', ['class' => 'btn btn-info'])}}
		{{Form::close()}}
		@endif
	</div>
</div>
@endif

<div class="table-responsive">
<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Apellido paterno</th>
			<th>Apellido materno</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		@foreach($course->teachers as $teacher)
		<tr>
			<td>{{$teacher->personal_information->name}}</td>
			<td>{{$teacher->personal_information->last_name}}</td>
			<td>{{$teacher->personal_information->mother_last_name}}</td>
			<td>
			@if(account()->allow_action('courses.destroy_teacher'))
			<form action="{{ url('/courses/' . $course->course_id . '/teachers/' . $teacher->user_id) }}" method="POST">
					{{ method_field('DELETE') }}
					<input type="submit" value="Eliminar" class="btn btn-danger">
			  </form>
			</td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@endsection