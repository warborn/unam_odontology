@extends('layouts.app')
@section('content')
@include('shared._alerts')

{{ Form::open(['action' => ['CoursesController@store']]) }}
<div class="form-group">
	{{Form::label('Grupo')}}: 
	{{ Form::select('group_id', $groups, null, ['class' => 'form-control'] )}}<br>
	{{Form::label('Periodo')}}: {{ Form::select('period_id', $periods, null, ['class' => 'form-control'] )}}<br>
	{{Form::label('Asignatura')}}: {{ Form::select('subject_id', $subjects, null, ['class' => 'form-control'] )}}<br>
	{{ Form::submit('Crear curso', ['class' => 'btn btn-success form-control'])}}
</div>
{{Form::close() }}

@endsection