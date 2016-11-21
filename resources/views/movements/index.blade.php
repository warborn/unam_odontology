@extends('layouts.app')

@section('content')
<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre de Usuario</th>
			<th>Nombre de Usuario Afectado</th>
			<th>IP</th>
			<th>Fecha</th>
			<th>Descripción del movimiento</th>
		</tr>
	</thead>
	<tbody>
		@foreach($movements as $movement)
		<tr>
			<td>{{$movement->maker_account->user->user_id}}</td>
			<td>{{$movement->receiver_account->user->user_id}}</td>
			<td>{{$movement->ip}}</td>
			<td>{{$movement->timestamp}}</td>
			<td>{{$movement->privilege->privilege_name}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection