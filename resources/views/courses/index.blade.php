@extends('layouts.app')
@section('content')
	@foreach($courses as $courses)
		{{$courses->course_id}},{{$courses->group_id}},{{$courses->periods->period_start_date}},{{$courses->periods->period_end_date}},{{$courses->subjects->subject_name}}<br> 
	@endforeach
@endsection