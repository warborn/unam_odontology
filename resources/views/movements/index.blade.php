@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
		<h3>Movimientos</h3>
	</div>
</div>
<div class="table-responsive">
<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>Realizó</th>
			<th>Afectado</th>
			<th>Fecha</th>
			<th>Movimiento</th>
			<th>IP</th>
		</tr>
	</thead>
	<tbody>
		@foreach($movements as $movement)
		<tr>
			<td>[{{$movement->maker_account->user->user_id}}] {{$movement->maker_account->user->personal_information->fullname()}}</td>
			<td>
			@if(!isset($movement->receiver_account))
			&nbsp;
			@else
				@if($movement->receiver_account->is_patient())
				[*PACIENTE]
				@else
				[{{$movement->receiver_account->user->user_id}}]
				@endif
			{{$movement->receiver_account->user->personal_information->fullname()}}
			@endif
			</td>
			<td>{{$movement->timestamp}}</td>
			<td>{{$movement->privilege->privilege_name}}</td>
			<td>{{$movement->ip}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
@endsection