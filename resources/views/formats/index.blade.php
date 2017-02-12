@extends('layouts.app')
@section('content')
@include('shared._alerts')
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
	</div>
</div>

<div class="row">
@if(account()->allow_action('formats.create'))
	<div class="form-group col-lg-2 col-sm-12 col-md-12">
		<a href="{{url('/formats/create')}}" class="btn btn-success btn-block">Agregar Formato</a>
	</div>
@endif
	<div class="col-lg-10 col-sm-12 col-md-12">
		<div class="row">
			<form action="{{ url('/formats') }}" method="GET" id="search-form">
		    <div class="form-group col-lg-3 col-sm-12 col-md-12">
		        <div class='input-group date' id="datetimepicker1">
		            <input type='text' class="form-control" name="start_date" placeholder="Fecha de inicio" value="{{$start_date}}"/>
		            <span class="input-group-addon">
		                <span class="glyphicon glyphicon-calendar"></span>
		            </span>
		        </div>
		    </div>

		    <div class="form-group col-lg-3 col-sm-12 col-md-12">
		        <div class='input-group date' id="datetimepicker2">
		            <input type='text' class="form-control" name="end_date" placeholder="Fecha de fín" value="{{$end_date}}"/>
		            <span class="input-group-addon">
		                <span class="glyphicon glyphicon-calendar"></span>
		            </span>
		        </div>
		    </div>

		    <div class="form-group col-lg-4 col-sm-12 col-md-12">
		    	<div class='input-group' >
            <input type="text" class="form-control" name="search" placeholder="Folio, nombre de paciente o pasante" value="{{$search}}" />
            <span class="input-group-addon" id="search-btn">
                {{-- <span class="glyphicon glyphicon-search"></span> --}}
                Buscar
            </span>
	        </div>
		    </div>

		    <div class="form-group col-lg-2 col-sm-12 col-md-12">
		      <button class="btn btn-info btn-block" type="reset" id="clear-btn">Limpiar</button>
		    </div>
			</form>
		</div>
	</div>
</div>
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
						<th>Enfermedad odontologica</th>
						<th>Estatus</th>
						<th>Fecha</th>
						<th>&nbsp;</th>
						<th>&nbsp;</th>
						{{-- <th>&nbsp;</th> --}}
					</tr>
				</thead>
				<tbody>
					@foreach($formats as $format)
					<tr>
						<td>{{$format->format_id}}</td>
						<td>{{$format->intern->personal_information->fullname()}}</td>
						<td>{{$format->patient->personal_information->fullname()}}</td>
						<td>{{$format->consultation_reason}}</td>
						<td>{{$format->dentalDisease->disease_name}}</td>
						<td>{{$format->format_status}}</td>
						<td>{{date('d M y', strtotime($format->fill_datetime))}}</td>
						<td><a class="btn btn-success" href="{{ url('/formats/' . $format->format_id) }}">Mostrar</a></td>
						@if(account()->allow_action('formats.edit') && $format->filled_by(intern()) )
						<td><a class="btn btn-info" href="{{ url('/formats/' . $format->format_id. '/edit') }}">Editar</a></td>
						@endif
						{{-- <td>
							<form action="{{ url('/formats/' . $format->format_id) }}" method="POST">
								{{ method_field('DELETE') }}
								<input type="submit" value="Eliminar" class="btn btn-danger">
							</form>
						</td> --}}
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="text-center">
		{{ $formats->links() }}
	</div>
</div>

@push('js')
<script type="text/javascript">
	@include('shared._datetimepicker_js')

  $("#clear-btn").click(function() {
    window.location.href = '/formats';
  });

  var $form = $('#search-form');

  $("#search-btn").click(function() {
  	$form.submit();
  });
</script>
@endpush
@endsection