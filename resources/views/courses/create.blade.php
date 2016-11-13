@extends('layouts.app')

@section('content')
{{ Form::open(['action' => 'CoursesController@store']) }}
	{{Form::label('Grupo')}}: {{ Form::select('group_id', $groups )}}<br>
	{{Form::label('Periodo')}}: {{ Form::select('period_id', $periods )}}<br>
	{{Form::label('Asignatura')}}: {{ Form::select('subject_id', $subjects )}}<br>
	{{ Form::submit('Crear curso')}}
{{Form::close() }}

@endsection