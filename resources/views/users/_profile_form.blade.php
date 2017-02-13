<form class="form-horizontal" role="form" method="POST" action="{{ url('/users/' . $user->user_id) }}">
{{ csrf_field() }}
{{ method_field('PATCH') }}

 <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Nombre(s)</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="{{ $user->personal_information->name }}">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
    <label for="last_name" class="col-md-4 control-label">Apellido Paterno</label>

    <div class="col-md-6">
        <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->personal_information->last_name }}">

        @if ($errors->has('last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('mother_last_name') ? ' has-error' : '' }}">
    <label for="mother_last_name" class="col-md-4 control-label">Apellido Materno</label>

    <div class="col-md-6">
        <input id="mother_last_name" type="text" class="form-control" name="mother_last_name" value="{{ $user->personal_information->mother_last_name }}">

        @if ($errors->has('mother_last_name'))
            <span class="help-block">
                <strong>{{ $errors->first('mother_last_name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
    <label for="phone" class="col-md-4 control-label">Teléfono</label>

    <div class="col-md-6">
        <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->personal_information->phone }}">

        @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
    <label for="street" class="col-md-4 control-label">Calle</label>

    <div class="col-md-6">
        <input id="street" type="text" class="form-control" name="street" value="{{ $user->personal_information->street }}">

        @if ($errors->has('street'))
            <span class="help-block">
                <strong>{{ $errors->first('street') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
    <label for="gender" class="col-md-4 control-label">Sexo</label>
    <div class="radio">
      <label>
        <input type="radio" name="gender" value="H" {{$user->personal_information->gender == 'H'? 'checked' : ''}}>
        Hombre
      </label>
      <label>
        <input type="radio" name="gender" value="M" {{$user->personal_information->gender == 'M'? 'checked' : ''}}>
        Mujer
      </label>
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-user"></i> Actualizar informacion personal
        </button>
    </div>
</div>
</form>