<td>
  <form action="{{url('teacher/courses/' . $course->course_id . '/students/' . $student->user_id)}}" method="POST">
  	@if ($course->has_student($student))
  		{{ method_field('PATCH') }}
  		<input type="hidden" name="status" value='rejected'>
  		<input type="submit" value="Rechazar" class="btn btn-danger">
  	@endif
  </form>
</td>