@extends('layouts.app')
@section('content')
@include('shared._alerts')
<h3>Datos Generales</h3>
{{ Form::open(['action' => ['FormatsController@store', $patient->user_id]]) }}
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Nombre del paciente')}} : {{Form::text('name',$patient->user->personal_information->fullname(),['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-6 col-lg-6 form-group{{ $errors->has('medical_history_number') ? ' has-error' : '' }}">
		{{Form::label('No. Historia clinica')}} : {{Form::text('medical_history_number', old('medical_history_number'), ['class'=>'form-control'])}}
		@if ($errors->has('medical_history_number'))
      <span class="help-block">
          <strong>{{ $errors->first('medical_history_number') }}</strong>
      </span>
    @endif
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
		{{Form::label('Nombre del servicio medico')}} : {{Form::select('medical_service',['0' => 'Seleccione','IMSS', 'ISSSTE', 'POPULAR'],$patient->medical_service,['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-5 form-group">
		{{Form::label('Otro')}} : {{Form::text('other_medical_service', $patient->other_medical_service, ['class' => 'form-control', 'disabled'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group{{ $errors->has('referred_by') ? ' has-error' : '' }}">
		{{Form::label('Referido por')}} : {{Form::text('referred_by', old('referred_by'), ['class' => 'form-control'])}}
		@if ($errors->has('referred_by'))
      <span class="help-block">
          <strong>{{ $errors->first('referred_by') }}</strong>
      </span>
    @endif
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group{{ $errors->has('consultation_reason') ? ' has-error' : '' }}">
		{{Form::label('Motivo de consulta')}} :{{Form::text('consultation_reason', old('consultation_reason'), ['class' => 'form-control'])}}
		@if ($errors->has('consultation_reason'))
      <span class="help-block">
          <strong>{{ $errors->first('consultation_reason') }}</strong>
      </span>
    @endif
	</div>
</div>

<div class="row">
	<h3>Estado General</h3>
	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
		{{Form::label('¿Padece alguna enfermedad?')}} : {{Form::select('has_disease',['1' => 'Si', '0' => 'No'],old('has_disease'),['class' => 'form-control', 'id' => 'has_disease'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('¿Cuál enfermedad?')}} :
		@if(old('has_disease') == '0')
		<select class="form-control" name="general_disease" class="form-control" id="general_disease" disabled>
		@else
		<select class="form-control" name="general_disease" class="form-control" id="general_disease">
		@endif
			<option selected disabled>Selecciona una enfermedad</option>
			@foreach($general as $disease)
				@if(old('general_disease') == $disease->disease_id)
					<option value={{$disease->disease_id}} selected>{{$disease->disease_name}}</option>
				@else
					<option value={{$disease->disease_id}}>{{$disease->disease_name}}</option>
				@endif
			@endforeach
		</select>
	</div>

	<div class="col-sm-12 col-md-4 col-lg-5 form-group{{ $errors->has('other_disease') ? ' has-error' : '' }}">
		{{Form::label('Otra')}} : 
		@if(old('has_disease') == '0')
		{{Form::text('other_disease', old('other_disease') , ['class' => 'form-control', 'id' => 'other_disease', 'disabled'])}}
		@else
		{{Form::text('other_disease', old('other_disease') , ['class' => 'form-control', 'id' => 'other_disease'])}}
		@endif
		@if ($errors->has('other_disease'))
      <span class="help-block">
          <strong>{{ $errors->first('other_disease') }}</strong>
      </span>
    @endif
	</div>

	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
		{{Form::label('¿Esta bajo tratamiento médico?')}} : {{Form::select('medical_treatment',['1' => 'Si', '0' => 'No'], old('medical_treatment'),['class' => 'form-control', 'id' => 'medical_treatment'])}}
	</div>
	
	<div class="col-sm-12 col-md-8 col-lg-9 form-group{{ $errors->has('therapeutic_used') ? ' has-error' : '' }}">
		{{Form::label('Terapeutica empleada')}} : 
		@if(old('medical_treatment') == '0')
		{{Form::textArea('therapeutic_used', old('therapeutic_used') , ['class' => 'form-control', 'rows' => 3, 'id' => 'therapeutic_used', 'disabled'])}}
		@else
		{{Form::textArea('therapeutic_used', old('therapeutic_used') , ['class' => 'form-control', 'rows' => 3, 'id' => 'therapeutic_used'])}}
		@endif
		@if ($errors->has('therapeutic_used'))
      <span class="help-block">
          <strong>{{ $errors->first('therapeutic_used') }}</strong>
      </span>
    @endif
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group{{ $errors->has('observations') ? ' has-error' : '' }}">
		{{Form::label('Observaciones')}} : {{Form::textArea('observations', old('observations') , ['class' => 'form-control', 'rows' => 4])}}
		@if ($errors->has('observations'))
      <span class="help-block">
          <strong>{{ $errors->first('observations') }}</strong>
      </span>
    @endif
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
		{{Form::label('Diagnóstico de presunción')}} : {{Form::select('dental_disease',$dental->pluck('disease_name', 'disease_id'),old('dental_disease'),['class' => 'form-control'])}}
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