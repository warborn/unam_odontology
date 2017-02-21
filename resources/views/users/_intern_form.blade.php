<form class="form-horizontal" role="form" method="POST" action="{{ url('interns/' . $intern->user_id) }}">
{{ csrf_field() }}
{{ method_field('PATCH') }}

<div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
    <label for="account_number" class="col-md-4 control-label">Número de cuenta</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="account_number" value="{{ $intern->account_number }}">
        @if ($errors->has('account_number'))
            <span class="help-block">
                <strong>{{ $errors->first('account_number') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('service_start_date') ? ' has-error' : '' }}">
    <label for="service_start_date" class="col-md-4 control-label">Fecha de inicio de servicio</label>
    <div class="col-md-6">
        <div class="col-md-6 input-group date" id="datetimepicker1">
            <input type='text' class="form-control" name="service_start_date" placeholder="Fecha de inicio de servicio" value="{{$intern->service_start_date}}" disabled/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        @if ($errors->has('service_start_date'))
            <span class="help-block">
                <strong>{{ $errors->first('service_start_date') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('service_end_date') ? ' has-error' : '' }}">
    <label for="service_end_date" class="col-md-4 control-label">Fecha de fín de servicio</label>
    <div class="col-md-6">
        <div class="col-md-6 input-group date" id="datetimepicker2">
            <input type='text' class="form-control" name="service_end_date" placeholder="Fecha de fín de servicio" value="{{$intern->service_end_date}}" disabled/>
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </div>
        @if ($errors->has('service_end_date'))
            <span class="help-block">
                <strong>{{ $errors->first('service_end_date') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-user"></i> Actualizar información de pasante
        </button>
    </div>
</div>
</form>