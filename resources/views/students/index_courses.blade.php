@extends('layouts.app')

@section('content')
	<h1>Grupos</h1>
	  	<table class="table table-hover">
			<tr>
			  <td><strong>Asignatura</strong></td>
			   <td><strong>Grupos</strong></td>
			  <td><strong>Periodo</strong></td>
			  <td><strong>Semestre</strong></td>
              <td>&nbsp;</td>
			</tr>
			@foreach($courses as $course)
			<tr>
			  <td>{{$course->subject->subject_name}}</td>
			  <td>{{$course->group->group_id}}</td>
			  <td>{{$course->period->period_id}}</td>
			  <td>{{$course->subject->semester}}</td>
			  <td><a href="{{url('student/course/' . $course->course_id )}}"type="button" class="btn btn-info">
			  	@if ($course->students()->find($student->user_id))
			  		{{$course->students()->find($student->user_id)->pivot->status}}
			  	@else
			  		Alta
			  	@endif
			  </a></td>
			  </tr>
			@endforeach
		</table>
		
@endsection