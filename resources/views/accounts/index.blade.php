@extends('layouts.app')

@section('content')
@include('shared._alerts')

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
		<h3>Cuentas</h3>
	</div>
</div>
<div class="table-responsive">
<table class="table table-hover table-striped">
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
		@if(!$account->is(account()) && account()->can_action_over($account))
		<tr>
			<td>{{$account->user->user_id}}</td>
			<td>{{$account->user->personal_information->fullname()}}</td>
			<td>{{$account->user->personal_information->email}}</td>
			<td>{{$account->user->personal_information->phone}}</td>
			<td>{{translate_account_status($account->status())}}</td>
			<td>
				<a href="{{url('accounts/' . $account->user_id)}}" class="btn btn-info">Administrar</a>
			</td>
		</tr>
		@endif
	@endforeach
	</tbody>
</table>
</div>

@endsection