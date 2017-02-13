<form class="form-horizontal" role="form" method="POST" action="{{ url('teachers/' . $teacher->user_id) }}">
{{ csrf_field() }}
{{ method_field('PATCH') }}

 <div class="form-group{{ $errors->has('rfc') ? ' has-error' : '' }}">
    <label for="rfc" class="col-md-4 control-label">RFC</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="rfc" value="{{ $teacher->RFC }}">

        @if ($errors->has('rfc'))
            <span class="help-block">
                <strong>{{ $errors->first('rfc') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-user"></i> Actualizar información de profesor
        </button>
    </div>
</div>
</form>