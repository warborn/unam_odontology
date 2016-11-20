@if(session()->has('success'))
		<div class="alert alert-success">
			{{ session()->get('success')}}
		</div>
	@elseif(session()->has('danger'))
		<div class="alert alert-danger">
			{{ session()->get('danger')}}
		</div>
	@elseif(session()->has('info'))
		<div class="alert alert-info">
			{{ session()->get('info')}}
		</div>
	@elseif(session()->has('warning'))
		<div class="alert alert-warning">
			{{ session()->get('warning')}}
		</div>
@endif