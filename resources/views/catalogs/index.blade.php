@extends('layouts.app')

@section('content')

<form>
	<div class="form-group">
		<select id="catalogs-select" class="form-control">
		@foreach($catalogs as $key => $catalog)
			@if($catalog['enabled'])
			<option value="{{$key}}">{{$catalog['body']}}</option>
			@endif
		@endforeach
		</select>
	</div>
</form>

<div class="table-responsive">
	<table class="table table-hover table-striped">
		<thead>
			<tr id="table-header-row">
			</tr>
		</thead>
		<tbody id="table-content">
		</tbody>
	</table>
</div>

<div id="catalog-container">
	
</div>

	@include('catalogs._catalogs_js')
@endsection