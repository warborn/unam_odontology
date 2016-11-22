@extends('layouts.app')

@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
@if (session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                        <label for="user_id" class="col-md-4 control-label">Usuario</label>

                        <div class="col-md-6">
                            <input id="user_id" type="text" class="form-control" name="user_id" value="{{ old('user_id') }}">

                            @if ($errors->has('user_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Contraseña</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('clinic_id') ? ' has-error' : '' }}">
                        <label for="clinic_id" class="col-md-4 control-label">Clínica</label>

                        <div class="col-md-6">
                            {{ Form::select('clinic_id', $clinics, null, ['class' => 'form-control'] )}}

                            @if ($errors->has('clinic_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('clinic_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Recordarme
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> Iniciar Sesión
                            </button>

                            <a class="btn btn-link" href="{{ url('/password/reset') }}">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
