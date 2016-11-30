@extends('layouts.app')
@section('content')
@include('shared._alerts')
<h1>Formato a1</h1>
<div class="row">
<h3>Datos Generales</h3>
{{ Form::open(['action' => ['FormatsController@store', $patient->user_id]]) }}
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Nombre del paciente')}} : {{Form::text('name',$patient->user->personal_information->name.' '.$patient->user->personal_information->last_name.' '.$patient->user->personal_information->mother_last_name,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-6 col-lg-6">
{{Form::label('Historia clinica')}} : {{Form::text('clinic_history', $format->medical_history_number, ['class'=>'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-6 col-lg-6">
{{Form::label('Genero')}} : {{Form::text('gender',$patient->user->personal_information->gender, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Direccion')}} : {{Form::text('street',$patient->user->personal_information->street, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Codigo postal')}} : {{Form::text('postal_code',$patient->user->personal_information->address->postal_code,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Colonia')}} : {{Form::text('settlement',$patient->user->personal_information->address->settlement,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Delegacion o Municipio')}} : {{Form::text('municipality',$patient->user->personal_information->address->municipality,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Estado')}} : {{Form::text('federal_entity_id',$patient->federalEntity->federal_entity_name,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-3 col-lg-3">
{{Form::label('Edad')}} : {{Form::text('age',$patient->age,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-9 col-lg-9">
{{Form::label('Lugar de nacimiento')}} : {{Form::text('federal_entity_name',$patient->federalEntity->federal_entity_name, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Ocupacion')}} : {{Form::text('ocupation',$patient->ocupation,['class' => 'form-control', 'readonly'] )}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Grado escolar')}} : {{Form::text('school_grade',$patient->school_grade,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Estado civil')}} : {{Form::text('civil_status',$patient->civil_status, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Telefono')}} : {{Form::text('phone',$patient->phone, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-3">
{{Form::label('¿Cuenta con servicio medico?')}} : {{Form::text('has_medical_service',$patient->has_medical_service,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('Nombre del servicio medico')}} : {{Form::text('service_name',$patient->service_name,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-5">
{{Form::label('Otro')}} : {{Form::text('service_name', $patient->service_name, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Referido por')}} : {{Form::text('intern_id', $intern->personal_information->fullname() , ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Motivo de consulta')}} :{{Form::text('consultation_reason', $format->consultation_reason, ['class' => 'form-control', 'readonly'])}}
</div>
</div>
<div class="row">
<h3>Estado General</h3>
<div class="col-sm-12 col-md-4 col-lg-3">
{{Form::label('¿Padece alguna enfermedad?')}} : {{Form::text('has_disease',$format->has_disease,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-4">
{{Form::label('¿Cuál enfermedad?')}} : {{Form::text('general_disease',$format->general_diseases->disease_name,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-5">
{{Form::label('Otra')}} : {{Form::text('other_disease',$format->other_disease, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-4 col-lg-3">
{{Form::label('¿Esta bajo tratamiento médico?')}} : {{Form::text('medical_treatment',$format->medical_treatment,['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-8 col-lg-9">
{{Form::label('Terapeutica empleada')}} : {{Form::textArea('therapeutic_used',$format->therapeutic_used, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Observaciones')}} : {{Form::textArea('observations',$format->observations, ['class' => 'form-control', 'readonly'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Diagnóstico de presunción')}} : {{Form::text('dental_disease',$format->dental_diseases->disease_name,['class' => 'form-control', 'readonly'])}}
</div>
{{-- in process --}} 
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::label('Remisión jerarquizada')}} : {{Form::select('subject_id',$subject->pluck('subject_name', 'subject_id'), null ,['class' => 'form-control', 'readonly'])}}
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
{{Form::submit('Agregar', ['class' => 'btn btn-success'])}}
</div>
<div class="col-sm-12 col-md-12 col-lg-12">
<table class="table table-hover table-triped">
	<thead>
		<tr>
			<th>Nombre del alumno</th>
			<th>Asignatura</th>
			<th>Grupo</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>{{$student->first()->personal_information->fullname()}}</td>
			<td>{{$student->first()->courses[0]->subject->subject_name}}</td>
			<td>{{$student->first()->courses[0]->group->group_id}}</td>
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
<!-- in process -->
<div class="col-sm-12 col-md-12 col-lg-12">
{{Form::submit('Guardar Formato', ['class' => 'btn btn-info form-control'])}}
</div>

{{Form::close() }}
</div>

@endsection