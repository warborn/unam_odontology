@extends('layouts.app')
@section('content')
@include('shared._alerts')
<div class="container">
	{{ Form::open(['url' => ['/courses/'.$course->course_id.'/teacher/']]) }}
	<div class="form-group">
		{{Form::hidden('course_id', $course->course_id)}}
		{{Form::label('Periodo:', null, ['class'=>'col-sm-2 control-label'])}}
		<div class="col-sm-10">
			{{Form::label($course->period_id ,null, ['class'=>'form-control-static'])}}
		</div>
		{{Form::label('Asignatura:', null, ['class'=>'col-sm-2 control-label'])}}
		<div class="col-sm-10">
			{{Form::label($course->subject->subject_name ,null, ['class'=>'form-control-static'])}}
		</div>
		{{Form::label('Grupo:', null, ['class'=>'col-sm-2 control-label'])}}
		<div class="col-sm-10">
			{{Form::label($course->group_id ,null, ['class'=>'form-control-static'])}}
		</div>
		<div class="col-sm-4">
			<select class="form-control">
				<option selected disabled>Profesores</option>
				@foreach($teachers as $teacher)
				<option value="{{$teacher->teacher_id}}">{{$teacher->personal_information->fullname()}}</option>
				@endforeach
			</select>
		</div>
	</div>
	{{ Form::submit('Crear curso', ['class' => 'btn btn-info'])}}
	{{Form::close()}}
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
			@foreach($teachers as $teacher)
			<tr>
				<td>{{$teacher->personal_information->name}}</td>
				<td>{{$teacher->personal_information->last_name}}</td>
				<td>{{$teacher->personal_information->mother_last_name}}</td>
				<td>
					<a class="btn btn-danger" href="javascript:void(0);" onclick="$(this).find('form').submit();" >
						<form action="{{ url('/courses/' . $teacher->teacher_id) }}" method="post">
							<input type="hidden" name="_method" value="DELETE">
						</form>DELETE
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection