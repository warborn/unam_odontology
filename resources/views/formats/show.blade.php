@extends('layouts.app')
@section('content')
@include('shared._alerts')
<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
	</div>
</div>

<div class="row">
	@if(account()->allow_action('formats.store_student') && count($students) > 0)
	<div class="remission">
		{{ Form::open(['action' => ['FormatsController@store_student', $format->format_id]]) }}
		<div class="col-sm-12 col-md-4 col-lg-4 form-group">
			{{Form::label('Estudiantes')}} :
			<select class="form-control" name="user_id" id="students">
				<option selected disabled>Seleccione estudiante</option>
				@foreach($students as $student)
				<option value={{$student->user_id}}>{{$student->personal_information->fullname()}}</option>
				@endforeach
			</select>
		</div>

		<div class="col-sm-12 col-md-6 col-lg-6 form-group">
			{{Form::label('Remisión jerarquizada')}} : 
			<select class="form-control" name="course_id" id="courses" disabled>
			</select>
		</div>

		<div class="col-sm-12 col-md-2 col-lg-2 form-group">
			{{ Form::submit('Asignar a paciente', ['class' => 'btn btn-info form-control bottom'])}}
		</div>
		{{Form::close() }}
	</div>
	@endif
	
	<div class="col-sm-12 col-md-12 col-lg-12 table-responsive">
		<h4>Estudiantes Asignados</h4>
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Asignatura</th>
					<th>Grupo</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody id="remissions">
				@foreach($assigned_students as $student)
				<tr>
					<td>
						{{$student->personal_information->fullname()}}
					</td>
					<td>
						{{$student->subject_name}}
					</td>
					<td>
						{{$student->group_id}}
					</td>
					@if(account()->allow_action('formats.destroy_student'))
					<td>
						<form action="{{url('formats/' . $format->format_id . '/students/' . $student->user_id  )}}" method="POST">
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
</div>

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
	<h4>Datos Generales</h4>
	{{Form::label('Nombre del paciente')}} : {{Form::text('name',$patient->user->personal_information->name.' '.$patient->user->personal_information->last_name.' '.$patient->user->personal_information->mother_last_name,['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-6 col-lg-6 form-group">
	{{Form::label('Historia clinica')}} : {{Form::text('clinic_history', $format->medical_history_number, ['class'=>'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-6 col-lg-6 form-group">
	{{Form::label('Genero')}} : {{Form::text('gender',$patient->user->personal_information->gender, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
	{{Form::label('Direccion')}} : {{Form::text('street',$patient->user->personal_information->street, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
	{{Form::label('Codigo postal')}} : {{Form::text('postal_code',$patient->user->personal_information->address->postal_code,['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
	{{Form::label('Colonia')}} : {{Form::text('settlement',$patient->user->personal_information->address->settlement,['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
	{{Form::label('Delegacion o Municipio')}} : {{Form::text('municipality',$patient->user->personal_information->address->municipality,['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
	{{Form::label('Estado')}} : {{Form::text('federal_entity_id',($patient->personal_information->address ? $patient->personal_information->address->federal_entity_id : null),['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-3 col-lg-3 form-group">
	{{Form::label('Edad')}} : {{Form::text('age',$patient->age,['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-9 col-lg-9 form-group">
	{{Form::label('Lugar de nacimiento')}} : {{Form::text('federal_entity_name',($patient->federalEntity ? $patient->federalEntity->federal_entity_name : null), ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
	{{Form::label('Ocupacion')}} : {{Form::text('ocupation',$patient->ocupation,['class' => 'form-control', 'readonly'] )}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
	{{Form::label('Grado escolar')}} : {{Form::text('school_grade',$patient->school_grade,['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
	{{Form::label('Estado civil')}} : {{Form::text('civil_status',$patient->civil_status, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
	{{Form::label('Telefono')}} : {{Form::text('phone',$patient->user->personal_information->phone, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
	{{Form::label('¿Cuenta con servicio medico?')}} : {{Form::text('has_medical_service',($patient->has_medical_service ? 'Sí' : 'No'),['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
	{{Form::label('Nombre del servicio medico')}} : {{Form::text('medical_service',$patient->medical_service,['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-5 form-group">
	{{Form::label('Otro')}} : {{Form::text('other_medical_service', $patient->other_medical_service, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
	{{Form::label('Referido por')}} : {{Form::text('referred_by', $format->referred_by , ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
	{{Form::label('Motivo de consulta')}} :{{Form::text('consultation_reason', $format->consultation_reason, ['class' => 'form-control', 'readonly'])}}
	</div>
</div>

<div class="row">
	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
	{{Form::label('¿Padece alguna enfermedad?')}} : {{Form::text('has_disease',($format->has_disease ? 'Sí' : 'No'),['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-4 form-group">
	@if($format->generalDisease)
	{{Form::label('¿Cuál enfermedad?')}} : {{Form::text('general_disease',$format->generalDisease->disease_name,['class' => 'form-control', 'readonly'])}}
	@else
		{{Form::label('¿Cuál enfermedad?')}} : {{Form::text('general_disease',null,['class' => 'form-control', 'readonly'])}}
	@endif
	</div>
	<div class="col-sm-12 col-md-4 col-lg-5 form-group">
	{{Form::label('Otra')}} : {{Form::text('other_disease',$format->other_disease, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-4 col-lg-3 form-group">
	{{Form::label('¿Esta bajo tratamiento médico?')}} : {{Form::text('medical_treatment', ($format->medical_treatment ? 'Sí' : 'No'),['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-8 col-lg-9 form-group">
	{{Form::label('Terapeutica empleada')}} : {{Form::textArea('therapeutic_used',$format->therapeutic_used, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
	{{Form::label('Observaciones')}} : {{Form::textArea('observations',$format->observations, ['class' => 'form-control', 'readonly'])}}
	</div>
	<div class="col-sm-12 col-md-12 col-lg-12 form-group">
	{{Form::label('Diagnóstico de presunción')}} : {{Form::text('dental_disease',($format->dentalDisease->disease_name),['class' => 'form-control', 'readonly'])}}
	</div>
</div>

@push('js')
<script type="text/javascript">
	$('#students').on('change', function() {
		$.ajax({
			url: '/student/' + this.value + '/courses',
			method: 'GET', 
			dataType: 'JSON', 
			success: function(response) {
				console.log(response);
				var $select = $('#courses');
				$select.removeAttr('disabled');
				$select.find('option').remove();
				$select.append('<option selected disabled>Seleccione un curso</option>');
				$.each(response, function(key, object) {
					console.log(key, object);
					$select.append('<option value=' + object.course_id + '>' + object.group_id + ' ' + object.subject.subject_name + '</option>');
				});
			}, 
			error: function(error) {
				console.log(error.responseText);
			}
		});
	});

</script>
@endpush

@endsection