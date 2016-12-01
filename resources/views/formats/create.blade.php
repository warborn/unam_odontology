@extends('layouts.app')
@section('content')
@include('shared._alerts')
<h3>Datos Generales</h3>
{{ Form::open(['action' => ['FormatsController@store', $patient->user_id]]) }}
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Nombre del paciente')}} : {{Form::text('name',$patient->user->personal_information->fullname(),['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-6 col-lg-6 form-group">
		{{Form::label('Historia clinica')}} : {{Form::text('clinic_history', null, ['class'=>'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-6 col-lg-6 form-group">
		{{Form::label('Género')}} : {{Form::select('gender', ['M'=>'Mujer','H'=>'Hombre'],$patient->user->personal_information->gender, ['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Dirección')}} : {{Form::text('street',$patient->user->personal_information->street, ['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
		{{Form::label('Codigo postal')}} : {{Form::text('postal_code',$patient->user->personal_information->address->postal_code,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
		{{Form::label('Colonia')}} : {{Form::text('settlement',$patient->user->personal_information->address->settlement,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
		{{Form::label('Delegación o Municipio')}} : {{Form::text('municipality',$patient->user->personal_information->address->municipality,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
		{{Form::label('Estado')}} : {{Form::select('federal_entity_id',$federal->pluck('federal_entity_name'),$patient->federalEntity->federal_entity_name,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
		{{Form::label('Edad')}} : {{Form::selectRange('age',1,99,$patient->age,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-9 col-lg-9 form-group">
		{{Form::label('Lugar de nacimiento')}} : {{Form::select('federal_entity_name',$federal->pluck('federal_entity_name'),$patient->federalEntity->federal_entity_name, ['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Ocupación')}} : {{Form::select('ocupation',['Seleccione','Empleado','Estudiante', 'Otro'],$patient->ocupation,['class' => 'form-control', 'disabled'] )}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Grado escolar')}} : {{Form::select('school_grade',['Kinder','Primaria', 'Secundaria', 'Preparatoria', 'Universidad', 'Maestria', 'doctorado'],$patient->school_grade,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Estado civil')}} : {{Form::select('civil_status',['Solter@', 'Casad@', 'Divorciad@', 'Viud@'],$patient->civil_status, ['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Telefono')}} : {{Form::text('phone',$patient->phone, ['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
		{{Form::label('¿Cuenta con servicio medico?')}} : {{Form::select('has_medical_service',['1' => 'Si', '0' => 'No'],$patient->has_medical_service,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Nombre del servicio medico')}} : {{Form::select('service_name',['Seleccione','IMSS', 'ISSSTE', 'POPULAR'],$patient->service_name,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-5 form-group">
		@if($patient->has_medical_service)
			{{Form::label('Otro')}} : {{Form::text('service_name', $patient->service_name, ['class' => 'form-control', 'disabled'])}}
		@else
			{{Form::label('Otro')}} : {{Form::text('service_name', $patient->service_name, ['class' => 'form-control'])}}
		@endif
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Referido por')}} : {{Form::text('intern_id', null, ['class' => 'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Motivo de consulta')}} :{{Form::text('consultation_reason', null, ['class' => 'form-control'])}}
	</div>
</div>

<div class="row">
	<h3>Estado General</h3>
	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
		{{Form::label('¿Padece alguna enfermedad?')}} : {{Form::select('has_disease',['1' => 'Si', '0' => 'No'],null,['class' => 'form-control', 'id' => 'has_disease'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('¿Cuál enfermedad?')}} :
		<select class="form-control" name="general_disease" class="form-control" id="general_disease">
			<option selected disabled>Selecciona una enfermedad</option>
			@foreach($general as $disease)
			<option value={{$disease->disease_id}}>{{$disease->disease_name}}</option>
			@endforeach
		</select>
	</div>

	<div class="col-sm-12 col-md-4 col-lg-5 form-group">
		{{Form::label('Otra')}} : {{Form::text('other_disease', null , ['class' => 'form-control', 'id' => 'other_disease'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
		{{Form::label('¿Esta bajo tratamiento médico?')}} : {{Form::select('medical_treatment',['1' => 'Si', '0' => 'No'],null,['class' => 'form-control', 'id' => 'medical_treatment'])}}
	</div>

	<div class="col-sm-12 col-md-8 col-lg-9 form-group">
		{{Form::label('Terapeutica empleada')}} : {{Form::textArea('therapeutic_used', null , ['class' => 'form-control', 'rows' => 3, 'id' => 'therapeutic_used'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Observaciones')}} : {{Form::textArea('observations', null , ['class' => 'form-control', 'rows' => 4])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Diagnóstico de presunción')}} : {{Form::select('dental_disease',$dental->pluck('disease_name', 'disease_id'),null,['class' => 'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12">
		{{Form::submit('Guardar Formato', ['class' => 'btn btn-info form-control'])}}
	</div>
</div>
{{Form::close() }}

@push('js')
<script type="text/javascript">
	 // change disease inputs
  var $generalDisease = $('#general_disease');
  var $otherDisease = $('#other_disease');
	$('#has_disease').on('change', function() { 
		if(this.value == 0) {
			$generalDisease.attr('disabled', true)[0].selectedIndex = 0;
			$otherDisease.attr('disabled', true).val('');
		} else {
			$generalDisease.removeAttr('disabled');
			$otherDisease.removeAttr('disabled');
		}
	});

	$generalDisease.on('change', function() {
		if(this.value) {
			$otherDisease.attr('disabled', true);
		} else {
			$otherDisease.removeAttr('disabled');
		}
	});

	$('#medical_treatment').on('change', function(){
		if(this.value == 0) {
			$('#therapeutic_used').attr('disabled', true);
		} else {
			$('#therapeutic_used').removeAttr('disabled');
		}
	});
</script>
@endpush

@endsection