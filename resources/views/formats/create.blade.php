@extends('layouts.app')
@section('content')
@include('shared._alerts')
<h1>Formato a1</h1>
<h3>Datos Generales</h3>
{{ Form::open(['action' => ['FormatsController@store', $patient->user_id]]) }}
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Nombre del paciente')}} : {{Form::text('name',$patient->user->personal_information->name.' '.$patient->user->personal_information->last_name.' '.$patient->user->personal_information->mother_last_name,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-6 col-lg-6">
{{Form::label('Historia clinica')}} : {{Form::text('clinic_history', null, ['class'=>'form-control'])}}
</div>
<div class="col-sm-12 col-md-6 col-lg-6">
{{Form::label('Genero')}} : {{Form::select('gender', ['M'=>'Mujer','H'=>'Hombre'],$patient->user->personal_information->gender, ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Direccion')}} : {{Form::text('street',$patient->user->personal_information->street, ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Codigo postal')}} : {{Form::text('postal_code',$patient->user->personal_information->address,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Colonia')}} : {{Form::text('settlement',$patient->user->personal_information->address,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Delegacion o Municipio')}} : {{Form::text('municipality',$patient->user->personal_information->address,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Estado')}} : {{Form::select('federal_entity_id',$federal->pluck('federal_entity_name'),$patient->federalEntity->federal_entity_name,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Edad')}} : {{Form::selectRange('age',1,99,$patient->age,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-9 col-lg-9">
{{Form::label('Lugar de nacimiento')}} : {{Form::select('federal_entity_name',$federal->pluck('federal_entity_name'),$patient->federalEntity->federal_entity_name, ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Ocupacion')}} : {{Form::select('ocupation',['Seleccione','Empleado','Estudiante', 'Otro'],$patient->ocupation,['class' => 'form-control'] )}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Grado escolar')}} : {{Form::select('school_grade',['Kinder','Primaria', 'Secundaria', 'Preparatoria', 'Universidad', 'Maestria', 'doctorado'],$patient->school_grade,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Estado civil')}} : {{Form::select('civil_status',['Solter@', 'Casad@', 'Divorciad@', 'Viud@'],$patient->civil_status, ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Telefono')}} : {{Form::text('phone',$patient->phone, ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-3">
{{Form::label('¿Cuenta con servicio medico?')}} : {{Form::select('has_medical_service',['Si', 'No'],$patient->has_medical_service,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Nombre del servicio medico')}} : {{Form::select('service_name',['Seleccione','IMSS', 'ISSSTE', 'POPULAR'],$patient->service_name,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-5">
{{Form::label('Otro')}} : {{Form::text('service_name', $patient->service_name, ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Referido por')}} : {{Form::text('intern_id', 'leonel guadaberto', ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Motivo de consulta')}} :{{Form::text('consultation_reason', null, ['class' => 'form-control'])}}
</div>
<h3>Estado General</h3>
<div class="col-sm-12 col-md-4 col-lg-3">
{{Form::label('¿Padece alguna enfermedad?')}} : {{Form::select('has_disease',['Si', 'No'],null,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('¿Cuál enfermedad?')}} : {{Form::select('general_disease',$medical->pluck('disease_id', 'disease_name'),null,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-5">
{{Form::label('Otra')}} : {{Form::text('other_disease', null , ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-3">
{{Form::label('¿Esta bajo tratamiento médico?')}} : {{Form::select('medical_treatment',['Si', 'No'],null,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-8 col-lg-9">
{{Form::label('Terapeutica empleada')}} : {{Form::textArea('therapeutic_used', null , ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Observaciones')}} : {{Form::textArea('observations', null , ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Diagnóstico de presunción')}} : {{Form::select('dental_disease',$dental->pluck('disease_id', 'disease_name'),null,['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Remisión jerarquizada')}} : {{Form::text('referred_by', null , ['class' => 'form-control'])}}
</div>
<div class="col-sm-12 col-md-8 col-lg-8">
{{Form::label('Alumno')}} :
<select class="form-control" value="user_student_id">
	<option value="">Seleccione alumno</option>
	@foreach($student as $std)
		<option value={{$std->user_id}}>{{$std->personal_information->fullname()}}</option>
	@endforeach
</select>
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::submit('Agregar', ['class' => 'btn btn-success form-control'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
<table class="table table-hover table-triped">
	<thead>
		<tr>
			<th>Nombre del alumno</th>
			<th>Grupo</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>juan</td>
			<td>6to</td>
			<td>
				<form action="" method="POST">
							{{ method_field('DELETE') }}
							<input type="submit" value="Eliminar" class="btn btn-danger">
					  </form>
			</td>
		</tr>
	</tbody>
</table>
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::submit('Guardar Formato', ['class' => 'btn btn-info form-control'])}}
</div>

{{Form::close() }}
@endsection