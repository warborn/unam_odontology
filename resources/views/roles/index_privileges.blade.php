@extends('layouts.app')

@section('content')
@include('shared._alerts')

<h3>Rol - {{ucwords($role->role_name)}}</h3>

@if(account()->allow_action('roles.store_privilege') && count($privileges) > 0)
{{ Form::open(['action' => ['RolesController@store_privilege', $role->role_id], 'class' => 'form-inline', ]) }}
<div class="form-group">
	{{ Form::select('privilege_id', $privileges, null, ['class' => 'form-control'] )}}
	{{ Form::submit('Agregar privilegio', ['class' => 'btn btn-info form-control'])}}
</div>
{{Form::close() }}
@endif

<!-- Tabla de profesores en la asignatura -->
<table class="table table-hover table-striped">
	<thead>
		<tr>
		<th>Privilegio</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	@foreach($role->privileges as $privilege)
		<tr>
			<td>{{$privilege->privilege_name}}</td>
			@if(account()->allow_action('roles.destroy_privilege'))
			<td>
				<form action="{{url('roles/' . $role->role_id . '/privileges/' . $privilege->privilege_id )}}" method="POST">
		  		{{ method_field('DELETE') }}
		  		<input type="submit" value="Eliminar" class="btn btn-danger">
			  </form>
			</td>
			@endif
		</tr>
	</tbody>
	@endforeach
</table>
@endsection