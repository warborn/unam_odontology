@extends('layouts.app')

@section('content')
<table class="table table-hover">
	<thead>
		<tr>
			<th>Nombre de Usuario</th>
			<th>Nombre</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		@foreach($patients as $patient)
		<tr>
			<td>{{$patient->user->user_id}}</td>
			<td>{{$patient->user->personal_information->fullname()}}</td>
			<td><a href="{{url('/patients/' . $patient->user_id . '/formats/create')}}" class="btn btn-info">Llenar formato</a></td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection