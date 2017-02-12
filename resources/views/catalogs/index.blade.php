@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		{!! Breadcrumbs::render() !!}
	</div>
</div>

<form>
	<div class="form-group">
		<select id="catalogs-select" class="form-control">
		<option selected="true" disabled="disabled">Selecciona un catálogo</option>
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