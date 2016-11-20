@extends('layouts.app')
@section('content')
@include('shared._alerts')

{{ Form::open(['action' => ['CoursesController@update', 'course' => $course->course_id], 'method' => 'POST', 'method' => 'PATCH' ]) }}
	<div class="form-group">
	{{Form::label('Grupo')}}: 
	{{ Form::select('group_id', $groups, null, ['class' => 'form-control'] )}}<br>
	{{Form::label('Periodo')}}: {{ Form::select('period_id', $periods, null, ['class' => 'form-control'] )}}<br>
	{{Form::label('Asignatura')}}: {{ Form::select('subject_id', $subjects, null, ['class' => 'form-control'] )}}<br>
	{{ Form::submit('Modificar curso', ['class' => 'btn btn-info form-control'])}}
</div>
{{Form::close() }}
@endsection