<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SGAP | Sistema de Gestión de Alta de Pacientes</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,400,700" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,700" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/custom_bootstrap.min.css"> --}}
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/css/app.css">
    <!-- sweetalert -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/vendor/sweetalert/dist/sweetalert.css">
    <!-- bootstrap datetimepicker -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('/') }}/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">

    <style>
        body {
            /*font-family: 'Comfortaa', cursive, sans-serif;*/
            /*font-family: 'Lato', sans-serif;*/
            font-family: 'Raleway', sans-serif;
        }

        .fa-btn {
            margin-right: 6px;
        }

        .btn.bottom {
            margin-top: 24px;
        }

        .main {
            min-height: 700px;
        }

        footer {
            margin-top: 100px;
        }

        .alert-dismissible button {
            margin-top: -3px;
            font-size: 30px;
        }
    </style>
</head>
<body id="app-layout">
    @include('shared._navbar')

    <div class="container main">
        @yield('content')
    </div>

    @include('shared._footer')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{ URL::to('/') }}/vendor/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::to('/') }}/vendor/momentjs/moment.js"></script>
    <script src="{{ URL::to('/') }}/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    @stack('js')
</body>
</html>
