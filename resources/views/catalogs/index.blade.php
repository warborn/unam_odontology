@extends('layouts.app')

@section('content')

<form>
	<div class="form-group">
		<select id="catalogs-select" class="form-control">
			<option value="group">Grupos</option>
			<option value="period">Periodos</option>
			<option value="subject">Asignaturas</option>
			<option value="privilege">Privilegios</option>
			<option value="role">Roles</option>
			<option value="federal-entity">Entidades federativas</option>
			<option value="disease">Enfermedades</option>
			<option value="address">Direcciones</option>
			<option value="clinic">Clinicas</option>
		</select>
	</div>
</form>

<div class="table-responsive">
	<table class="table table-hover table-striped">
		<thead>
			<tr id="table-header-row">
			</tr>
		</thead>
		<tbody id="table-content">
		</tbody>
	</table>
</div>

<div id="catalog-container">
	
</div>

	@include('catalogs._catalogs_js')
@endsection