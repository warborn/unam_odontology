@extends('layouts.app')
@section('content')
@include('shared._alerts')
<h3>Datos Generales</h3>
{{ Form::open(['action' => ['FormatsController@store']]) }}
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-4 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		{{Form::label('Nombre(s)')}} : {{Form::text('name',old('name'),['class' => 'form-control'])}}
		@if ($errors->has('name'))
      <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
      </span>
    @endif
	</div>

	<div class="col-sm-12 col-md-12 col-lg-4 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
		{{Form::label('Apellido Paterno')}} : {{Form::text('last_name',old('last_name'),['class' => 'form-control'])}}
		@if ($errors->has('last_name'))
	    <span class="help-block">
	        <strong>{{ $errors->first('last_name') }}</strong>
	    </span>
	  @endif
	</div>

	<div class="col-sm-12 col-md-12 col-lg-4 form-group{{ $errors->has('mother_last_name') ? ' has-error' : '' }}">
	{{Form::label('Apellido Materno')}} : {{Form::text('mother_last_name',old('mother_last_name'),['class' => 'form-control'])}}
		@if ($errors->has('mother_last_name'))
	    <span class="help-block">
	        <strong>{{ $errors->first('mother_last_name') }}</strong>
	    </span>
	  @endif
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
		{{Form::label('Género')}} : {{Form::select('gender', ['M'=>'Mujer','H'=>'Hombre'],old('gender'), ['class' => 'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group{{ $errors->has('street') ? ' has-error' : '' }}">
		{{Form::label('Dirección')}} : {{Form::text('street',old('street'), ['class' => 'form-control'])}}
		@if ($errors->has('street'))
	    <span class="help-block">
	        <strong>{{ $errors->first('street') }}</strong>
	    </span>
	  @endif
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
		{{Form::label('Codigo postal')}} : {{Form::text('postal_code',old('postal_code'),['class' => 'form-control', 'id' => 'postal-code'])}}
		@if ($errors->has('postal_code'))
	    <span class="help-block">
	        <strong>{{ $errors->first('postal_code') }}</strong>
	    </span>
	  @endif
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group{{ $errors->has('settlement') ? ' has-error' : '' }}">
		{{Form::label('Colonia')}} : {{Form::select('settlement',[],old('settlement'),['class' => 'form-control', 'id' => 'settlement'])}}
		@if ($errors->has('settlement'))
	    <span class="help-block">
	        <strong>{{ $errors->first('settlement') }}</strong>
	    </span>
	  @endif
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group{{ $errors->has('municipality') ? ' has-error' : '' }}">
		{{Form::label('Delegación o Municipio')}} : {{Form::select('municipality',[],old('municipality'),['class' => 'form-control', 'id' => 'municipality', 'disabled'])}}
		@if ($errors->has('municipality'))
	    <span class="help-block">
	        <strong>{{ $errors->first('municipality') }}</strong>
	    </span>
	  @endif
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group{{ $errors->has('state') ? ' has-error' : '' }}">
		{{Form::label('Estado')}} : {{Form::select('state',$federal->pluck('federal_entity_name', 'federal_entity_id'),old('federal_entity_id'),['class' => 'form-control', 'id' => 'state', 'disabled'])}}
		@if ($errors->has('state'))
	    <span class="help-block">
	        <strong>{{ $errors->first('state') }}</strong>
	    </span>
	  @endif
	</div>

	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
		{{Form::label('Edad')}} : {{Form::selectRange('age',1,99,old('age'),['class' => 'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-9 col-lg-9 form-group">
		{{Form::label('Lugar de nacimiento')}} : {{Form::select('federal_entity_id',$federal->pluck('federal_entity_name', 'federal_entity_id'),old('federal_entity_name'), ['class' => 'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Ocupación')}} : {{Form::select('ocupation',$ocupations,old('ocupation'),['class' => 'form-control'] )}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Grado escolar')}} : {{Form::select('school_grade',$school_grades,old('school_grade'),['class' => 'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Estado civil')}} : {{Form::select('civil_status',$civil_status,old('civil_status'), ['class' => 'form-control'])}}
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12 form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
		{{Form::label('Telefono')}} : {{Form::text('phone',old('phone'), ['class' => 'form-control'])}}
		@if ($errors->has('phone'))
	    <span class="help-block">
	        <strong>{{ $errors->first('phone') }}</strong>
	    </span>
	  @endif
	</div>

	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
		{{Form::label('¿Cuenta con servicio medico?')}} : {{Form::select('has_medical_service',['1' => 'Si', '0' => 'No'],old('has_medical_service'),['class' => 'form-control', 'id' => 'has_medical_service'])}}
	</div>

	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
		{{Form::label('Nombre del servicio medico')}} : 
		@if(old('has_medical_service') == '0')
		<select class="form-control" name="medical_service" class="form-control" id="medical_service" disabled>
		@else
		<select class="form-control" name="medical_service" class="form-control" id="medical_service">
		@endif
			<option selected disabled>Selecciona un servicio médico</option>
			@foreach($medical_services as $service)
				@if(old('medical_service') == $service)
					<option value={{$service}} selected>{{$service}}</option>
				@else
					<option value={{$service}}>{{$service}}</option>
				@endif
			@endforeach
		</select>
	</div>

	<div class="col-sm-12 col-md-4 col-lg-5 form-group{{ $errors->has('other_medical_service') ? ' has-error' : '' }}">
		{{Form::label('Otro')}} : 
		@if(old('has_medical_service') == '0')
		{{Form::text('other_medical_service', old('other_medical_service') , ['class' => 'form-control', 'id' => 'other_medical_service'])}}
		@else
		{{Form::text('other_medical_service', old('other_medical_service') , ['class' => 'form-control', 'id' => 'other_medical_service'])}}
		@endif
		@if ($errors->has('other_medical_service'))
      <span class="help-block">
          <strong>{{ $errors->first('other_medical_service') }}</strong>
      </span>
    @endif
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
		{{Form::text('other_disease', old('other_disease') , ['class' => 'form-control', 'id' => 'other_disease'])}}
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
		{{Form::textArea('therapeutic_used', old('therapeutic_used') , ['class' => 'form-control', 'rows' => 3, 'id' => 'therapeutic_used'])}}
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
		{{Form::label('Diagnóstico de presunción')}} : 

		<select class="form-control" name="dental_disease" class="form-control">
			@foreach($dental as $disease)
				@if(old('dental_disease') == $disease->disease_id)
					<option value="{{$disease->disease_id}}" selected>{{$disease->disease_id}} - {{$disease->disease_name}}</option>
				@else
					<option value="{{$disease->disease_id}}">{{$disease->disease_id}} - {{$disease->disease_name}}</option>
				@endif
			@endforeach
		</select>
	</div>

	<div class="col-sm-12 col-md-12 col-lg-12">
		{{Form::submit('Guardar Formato', ['class' => 'btn btn-info form-control'])}}
	</div>
</div>
{{Form::close() }}

@include('formats._other_field_js')
@include('shared._address_js')

@endsection