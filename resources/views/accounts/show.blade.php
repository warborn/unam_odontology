@extends('layouts.app')

@section('content')
@include('shared._alerts')

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
		<h3>Cuenta: {{$account->user_id}}</h3>

		@if(account()->allow_action('accounts.store_role') && account()->can_action_over($account) && count($roles) > 0)
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
					@if(account()->allow_action('accounts.destroy_role') &&  account()->allow_role_action('role.destroy', $role))
					<td>
						<form action="{{url('accounts/' . $account->user_id . '/roles/' . $role->role_id  )}}" method="POST">
							{{ method_field('DELETE') }}
							<input type="submit" value="Eliminar" class="btn btn-danger">
						</form>
					</td>
					@endif
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
					<td>{{$privilege['privilege_id']}} - {{$privilege['privilege_name']}}</td>
					<td>
					@if(account()->can_action_over($account))
						@if($privilege['status'] == 'enabled' && account()->allow_action('accounts.store_disabled_privilege'))
						<form action="{{url('accounts/' . $account->user_id . '/privileges/' . $privilege_id  )}}" method="POST">
							<input type="submit" value="Deshabilitar" class="btn btn-danger">
						</form>
						@elseif($privilege['status'] == 'disabled' && account()->allow_action('accounts.destroy_disabled_privilege'))
						<form action="{{url('accounts/' . $account->user_id . '/privileges/' . $privilege_id  )}}" method="POST">
							{{ method_field('DELETE') }}
							<input type="submit" value="Habilitar" class="btn btn-primary">
						</form>
						@endif
					</td>
					@endif
				</tr>			
			@endforeach
			</tbody>
		</table>
	</div>

@if(account()->allow_action('interns.update') && $account->has_profile('intern'))
<div class="row">
	
<form class="form-horizontal" role="form" method="POST" action="{{ url('interns/' . $account->user->intern->user_id) }}">
{{ csrf_field() }}
{{ method_field('PATCH') }}

	<div class="form-group{{ $errors->has('service_start_date') ? ' has-error' : '' }}">
	    <label for="service_start_date" class="col-md-4 control-label">Fecha de inicio de servicio</label>
	    <div class="col-md-6">
	        <div class="col-md-6 input-group date" id="datetimepicker1">
	            <input type='text' class="form-control" name="service_start_date" placeholder="Fecha de inicio de servicio" value="{{$account->user->intern->service_start_date}}"/>
	            <span class="input-group-addon">
	                <span class="glyphicon glyphicon-calendar"></span>
	            </span>
	        </div>
	        @if ($errors->has('service_start_date'))
	            <span class="help-block">
	                <strong>{{ $errors->first('service_start_date') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group{{ $errors->has('service_end_date') ? ' has-error' : '' }}">
	    <label for="service_end_date" class="col-md-4 control-label">Fecha de fín de servicio</label>
	    <div class="col-md-6">
	        <div class="col-md-6 input-group date" id="datetimepicker2">
	            <input type='text' class="form-control" name="service_end_date" placeholder="Fecha de fín de servicio" value="{{$account->user->intern->service_end_date}}"/>
	            <span class="input-group-addon">
	                <span class="glyphicon glyphicon-calendar"></span>
	            </span>
	        </div>
	        @if ($errors->has('service_end_date'))
	            <span class="help-block">
	                <strong>{{ $errors->first('service_end_date') }}</strong>
	            </span>
	        @endif
	    </div>
	</div>

	<div class="form-group">
	    <div class="col-md-6 col-md-offset-4">
	        <button type="submit" class="btn btn-primary">
	            <i class="fa fa-btn fa-user"></i> Actualizar información de pasante
	        </button>
	    </div>
	</div>
</form>
</div>
@endif

@if($account->isActive())
	@if(account()->allow_action('accounts.deactivate') && account()->can_action_over($account))
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
	@endif
@else
	@if(account()->allow_action('accounts.activate') && account()->can_action_over($account))
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<form action="{{url('accounts/' . $account->user_id . '/activate')}}" method="POST">
				{{ method_field('DELETE') }}
				<input type="submit" value="Activar" class="btn btn-primary">
			</form>
		</div>
	</div>
	@endif
@endif

@if(account()->allow_action('interns.update'))
	@push('js')
	<script type="text/javascript">
	    @include('shared._datetimepicker_js')
	</script>
	@endpush
@endif

@endsection