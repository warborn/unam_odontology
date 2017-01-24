@extends('layouts.app')

@section('content')
@include('shared._alerts')

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<h3>Cuenta: {{$account->user->user_id}}</h3>

		@if(count($roles) > 0)
		{{ Form::open(['action' => ['AccountsController@store_role', $account->user_id], 'class' => 'form-inline', ]) }}
		<div class="form-group">
			{{ Form::select('role_id', $roles, null, ['class' => 'form-control'] )}}
			{{ Form::submit('Agregar rol', ['class' => 'btn btn-info form-control'])}}
		</div>
		{{Form::close() }}
		@endif
	</div>
</div>

	<div class="table-responsive">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Rol</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach($account->roles as $role)
				<tr>
					<td>{{$role->role_name}}</td>
					<td>
						<form action="{{url('accounts/' . $account->user_id . '/roles/' . $role->role_id  )}}" method="POST">
							{{ method_field('DELETE') }}
							<input type="submit" value="Eliminar" class="btn btn-danger">
						</form>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

	<div class="table-responsive">
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Privilegio</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach($account->all_privileges() as $privilege_id => $privilege)
				<tr>
					<td>{{$privilege['privilege_name']}}</td>
					<td>
						@if($privilege['status'] == 'enabled')
						<form action="{{url('accounts/' . $account->user_id . '/privileges/' . $privilege_id  )}}" method="POST">
							<input type="submit" value="Deshabilitar" class="btn btn-danger">
						</form>
						@elseif($privilege['status'] == 'disabled')
						<form action="{{url('accounts/' . $account->user_id . '/privileges/' . $privilege_id  )}}" method="POST">
							{{ method_field('DELETE') }}
							<input type="submit" value="Habilitar" class="btn btn-primary">
						</form>
						@endif
					</td>
				</tr>			
			@endforeach
			</tbody>
		</table>
	</div>

@if($account->isActive())

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseDeactiveForm" aria-expanded="false" aria-controls="collapseExample">
			Desactivar Cuenta
		</button>
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<div class="collapse" id="collapseDeactiveForm">
			<div class="well">
				{{ Form::open(['action' => ['AccountsController@deactivate', $account->user_id]]) }}
				<div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
					{{ Form::select('status', $deactivation, null, ['class' => 'form-control'] )}}
					@if ($errors->has('status'))
              <span class="help-block">
                  <strong>{{ $errors->first('status') }}</strong>
              </span>
          @endif
				</div>
				<div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
					{{ Form::textarea('reason', null, ['class' => 'form-control', 'placeholder' => 'razón'])}}
					@if ($errors->has('reason'))
              <span class="help-block">
                  <strong>{{ $errors->first('reason') }}</strong>
              </span>
          @endif
				</div>
				<div class="form-group">
					{{ Form::submit('Desactivar', ['class' => 'btn btn-danger form-control'])}}
				</div>
				{{Form::close() }}
			</div>
		</div>
	</div>
</div>
@else
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<form action="{{url('accounts/' . $account->user_id . '/activate')}}" method="POST">
			{{ method_field('DELETE') }}
			<input type="submit" value="Activar" class="btn btn-primary">
		</form>
	</div>
</div>
@endif

@endsection