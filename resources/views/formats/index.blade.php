@extends('layouts.app')
@section('content')
@include('shared._alerts')
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Folio</th>
						<th>Pasante</th>
						<th>Paciente</th>
						<th>Razón de consulta</th>
						<th>Clave enfermedad</th>
						<th>Enfermedad odontologica</th>
						<th>Estatus</th>
						<th>Fecha</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					@foreach($formats as $format)
					<tr>
						<td>{{$format->format_id}}</td>
						<td>{{$format->intern->personal_information->fullname()}}</td>
						<td>{{$format->patient->personal_information->fullname()}}</td>
						<td>{{$format->consultation_reason}}</td>
						<td>{{$format->dentalDisease->disease_id}}</td>
						<td>{{$format->dentalDisease->disease_name}}</td>
						<td>{{$format->format_status}}</td>
						<td>{{$format->hour_date_fill}}</td>
						<td><a class="btn btn-success" href="{{ url('/formats/' . $format->format_id) }}">Mostrar</a></td>
						<td><a class="btn btn-info" href="{{ url('/formats/' . $format->format_id. '/edit') }}">Editar</a></td>
						<td>
							<form action="{{ url('/formats/' . $format->format_id) }}" method="POST">
								{{ method_field('DELETE') }}
								<input type="submit" value="Eliminar" class="btn btn-danger">
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
				{{ $formats->links() }}
			</table>
		</div>
	</div>
</div>
@endsection