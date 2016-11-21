@extends('layouts.app')
@section('content')
@include('shared._alerts')
<div class="row">
	<div class="col-lg-10">
		<a href="{{url('/courses/create')}}"class="btn btn-success">Agregar Curso</a>
	</div>
</div>
<div class="row">
	<div class="col-lg-10">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Curso</th>
					<th>Grupo</th>
					<th>Periodo</th>
					<th>Asignatura</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach($courses as $course)
				<tr>
					<td>{{$course->course_id}}</td>
					<td>{{$course->group_id}}</td>
					<td>{{$course->period->period_id}}</td>
					<td>{{$course->subject->subject_name}}</td>
					<td><a class="btn btn-success" href="{{ url('/courses/' . $course->course_id) }}">Mostrar</a></td>
					<td><a class="btn btn-info" href="{{ url('/courses/' . $course->course_id . '/edit') }}">Editar</a></td>
					<td>
						<form action="{{ url('/courses/' . $course->course_id) }}" method="POST">
							{{ method_field('DELETE') }}
							<input type="submit" value="Eliminar" class="btn btn-danger">
					  </form>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection