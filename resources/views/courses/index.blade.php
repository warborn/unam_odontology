@extends('layouts.app')
@section('content')
@include('shared._alerts')
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
	</div>
</div>
@if(account()->allow_action('courses.create'))
<div class="row">
	<div class="col-lg-10">
		<a href="{{url('/courses/create')}}"class="btn btn-success">Agregar Curso</a>
	</div>
</div>
@endif
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Periodo</th>
					<th>Asignatura</th>
					<th>Grupo</th>
					<th>Profesor(es)</th>
					<th># Estudiantes</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach($courses as $course)
				<tr>
					<td>{{$course->period->period_id}}</td>
					<td>[{{$course->subject->subject_id}}] {{$course->subject->subject_name}}</td>
					<td>{{$course->group_id}}</td>
					<td>
						@foreach($course->teachers as $teacher)
							<span class="block">{{$teacher->personal_information->fullname()}}</span>
						@endforeach
					</td>
					<td>{{$course->students_count}}</td>
					<td><a class="btn btn-success" href="{{ url('/courses/' . $course->course_id) }}">Administrar profesores</a></td>

					@if(account()->allow_action('courses.edit'))
					<td><a class="btn btn-info" href="{{ url('/courses/' . $course->course_id . '/edit') }}">Editar</a></td>
					@endif
					@if(account()->allow_action('courses.destroy'))
					<td>
						<form action="{{ url('/courses/' . $course->course_id) }}" method="POST">
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
	</div>
</div>

<div class="row">
	<div class="text-center">
		{{ $courses->links() }}
	</div>
</div>

@endsection