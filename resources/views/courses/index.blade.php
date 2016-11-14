@extends('layouts.app')
@section('content')
	<table>
		<tr>
			<th>Course id</th>
			<th>Group</th>
			<th>Period</th>
			<th>Subject</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		@foreach($courses as $course)
		<tr>
			<td>{{$course->course_id}}</td>
			<td>{{$course->group_id}}</td>
			<td>{{$course->period->period_id}}</td>
			<td>{{$course->subject->subject_name}}</td>
			<td><a href="{{ url('/courses/' . $course->course_id . '/edit') }}">Edit</a></td>
			<td>
				<a href="javascript:void(0);" onclick="$(this).find('form').submit();" >
			    <form action="{{ url('/courses/' . $course->course_id) }}" method="post">
			        <input type="hidden" name="_method" value="DELETE">
			    </form>DELETE
				</a>
			</td>
		</tr>
		@endforeach
	</table>
@endsection