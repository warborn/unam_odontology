<td>
  <form action="{{url('teacher/courses/' . $course->course_id . '/students/' . $student->user_id)}}" method="POST">
  	@if ($course->has_student($student))
  		{{ method_field('PATCH') }}
  		<input type="hidden" name="status" value='accepted'>
  		<input type="submit" value="Aceptar" class="btn btn-primary">
  	@endif
  </form>
</td>