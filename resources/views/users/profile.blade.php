@extends('layouts.app')

@section('content')
<ul class="nav nav-tabs nav-justified" role="tablist">
  <li role="presentation" class="active" id="perfil_a"><a href="#perfil"  role="tab" data-toggle="tab">Perfil</a></li>
  <li role="presentation"><a href="#cambiarContraseña" role="tab" data-toggle="tab">Cambiar contraseña</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="perfil">
		<h3>Datos personales</h3>

		<form class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label">Usuario</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->user_id}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Nombre</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->name}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Apellido paterno</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->last_name}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Apellido materno</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->mother_last_name}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->email}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Teléfono</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->phone}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Sexo</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->gender}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Dirección</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->full_address()}}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Calle</label>
				<div class="col-sm-10">
					<p class="form-control-static">{{$user->personal_information->street}}</p>
				</div>
			</div>

	</div>
	<div role="tabpanel" class="tab-pane" id="cambiarContraseña">
		<h3>Cambiar Contraseña</h3>
		<form class="form-horizontal">
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Nueva Contraseña</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="inputPassword3">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Repetir Contraseña</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="inputPassword3">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Aceptar</button>
				</div>
			</div>
		</form>
	</div>
	<div role="tabpanel" class="tab-pane" id="profesores">jdasjksajhsdhj</div>
	<div role="tabpanel" class="tab-pane" id="asignaturas">...</div>
	<div role="tabpanel" class="tab-pane" id="periodo">...</div>
	<div role="tabpanel" class="tab-pane" id="grupo">...</div>
	<div role="tabpanel" class="tab-pane" id="privilegios">...</div>
</div>
@endsection