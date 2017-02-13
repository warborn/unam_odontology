<form class="form-horizontal" role="form" method="POST" action="{{ url('students/' . $student->user_id) }}">
{{ csrf_field() }}
{{ method_field('PATCH') }}

 <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
    <label for="account_number" class="col-md-4 control-label">Número de cuenta</label>

    <div class="col-md-6">
        <input type="text" class="form-control" name="account_number" value="{{ $student->account_number }}">

        @if ($errors->has('account_number'))
            <span class="help-block">
                <strong>{{ $errors->first('account_number') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-user"></i> Actualizar información de estudiante
        </button>
    </div>
</div>
</form>