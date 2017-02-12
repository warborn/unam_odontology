@extends('layouts.app')
@section('content')
@include('shared._alerts')

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
	</div>
</div>

{{ Form::open(['action' => ['CoursesController@store']]) }}
<div class="form-group">
	{{Form::label('Grupo')}}: 
	{{ Form::select('group_id', $groups, old('group_id'), ['class' => 'form-control'] )}}<br>
	{{Form::label('Periodo')}}: {{ Form::select('period_id', $periods, old('period_id'), ['class' => 'form-control'] )}}<br>
	{{Form::label('Asignatura')}}: {{ Form::select('subject_id', $subjects, old('subject_id'), ['class' => 'form-control'] )}}<br>
	{{ Form::submit('Crear curso', ['class' => 'btn btn-success form-control'])}}
</div>
{{Form::close() }}

@endsection