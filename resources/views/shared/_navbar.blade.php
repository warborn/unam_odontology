<nav class="navbar navbar-default navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<!-- Collapsed Hamburger -->
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
			<span class="sr-only">Toggle Navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<!-- Branding Image -->
			<a class="navbar-brand" href="{{ url('/') }}">
				Odontología
			</a>
		</div>
		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			<!-- Left Side Of Navbar -->
			{{-- <ul class="nav navbar-nav">
				<li><a href="{{ url('/home') }}">Home</a></li>
			</ul> --}}
			<!-- Right Side Of Navbar -->
			<ul class="nav navbar-nav navbar-right">
				<!-- Authentication Links -->
				@if (Auth::guest())
				<li><a href="{{ url('/login') }}">Inicia Sesión</a></li>
				<li><a href="{{ url('/register') }}">Registrate</a></li>
				@else
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						{{ Auth::user()->personal_information->fullname() }} | {{ session()->get('clinic_id')}}<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Mi perfil</a></li>
						<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
						@if(account()->allow_action('catalogs.index'))
						<li><a href="{{ url('/catalogs') }}"><i class="fa fa-btn glyphicon glyphicon-th-list"></i>Catalogos</a></li>
						@endif
						@if(account()->allow_action('accounts.index'))
						<li><a href="{{ url('/accounts') }}"><i class="fa fa-btn glyphicon glyphicon-list"></i>Cuentas</a></li>
						@endif
						@if(account()->allow_action('courses.index'))
						<li><a href="{{ url('/courses') }}"><i class="fa fa-btn glyphicon glyphicon-book"></i>Cursos</a></li>
						@endif
						@if(account()->allow_action('movements.index'))
						<li><a href="{{ url('/movements') }}"><i class="fa fa-btn fa-sign-out glyphicon glyphicon-list-alt"></i>Movimientos</a></li>
						@endif
						@if(account()->allow_action('formats.index'))
						<li><a href="{{ url('/formats') }}"><i class="fa fa-btn glyphicon glyphicon-file"></i>Formatos</a></li>
						@endif
						@if(account()->has_profile('teacher') && account()->allow_action('teachers.index_courses'))
						<li><a href="{{ url('/teacher/courses')}}"><i class="fa fa-btn glyphicon glyphicon-check"></i>Cursos asignados</a></li>
						@endif
						@if(account()->has_profile('student') && account()->allow_action('students.index_courses'))
						<li><a href="{{ url('/student/courses') }}"><i class="fa fa-btn glyphicon glyphicon-edit"></i>Lista de cursos</a></li>
						@endif
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
</nav>