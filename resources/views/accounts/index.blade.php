@extends('layouts.app')

@section('content')
@include('shared._alerts')

<h3>Cuentas</h3>

<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre de usuario</th>
			<th>Nombre</th>
			<th>Correo Electrónico</th>
			<th>Teléfono</th>
			<th>Cuenta</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	@foreach($accounts as $account)
		<tr>
			<td>{{$account->user->user_id}}</td>
			<td>{{$account->user->personal_information->fullname()}}</td>
			<td>{{$account->user->personal_information->email}}</td>
			<td>{{$account->user->personal_information->phone}}</td>
			<td>{{translate_account_status($account->status())}}</td>
			<td>
				<a href="{{url('accounts/' . $account->account_id)}}" class="btn btn-info">Administrar</a>
			</td>
		</tr>
	</tbody>
	@endforeach
</table>
@endsection