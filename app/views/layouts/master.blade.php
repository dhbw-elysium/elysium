<!DOCTYPE html>
<html lang="de">
    <head>
        <title>
            @section('title')
            Elysium
            @show
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- CSS are placed here -->
        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/bootstrap-theme.css') }}

        <style>
        @section('styles')
            body {
                padding-top: 60px;
            }
        @show
        </style>

    </head>

    <body>
        <!-- Navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="#">Elysium</a>
                </div>
                <!-- Everything you want hidden at 940px or less, place within here -->
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        @if ( Auth::guest() )
                            <li>{{ HTML::link('login', 'Login') }}</li>
                        @else
							<li><a href="{{{ URL::to('') }}}">Start</a></li>
							<li><a href="{{{ URL::to('docents') }}}">Dozenten</a></li>
							<li><a href="{{{ URL::to('docent') }}}">Dozent</a></li>
							<li><a href="{{{ URL::to('courses') }}}">Vorlesungen &amp; Themenbereiche</a></li>
							<li><a href="{{{ URL::to('') }}}">Benutzer</a></li>
                            <li>{{ HTML::link('logout', 'Logout') }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>


        <!-- Container -->
        <div class="container">
			<ol class="breadcrumb" style="display: none;">
			  <li><a href="#">Elysium</a></li>
			  <li><a href="#">Dozenten</a></li>
			  <li class="active">Sören Anschütz</li>
			</ol>
            <!-- Success-Messages -->
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Erfolg</h4>
                    {{{ $message }}}
                </div>
            @endif
            @if ($message = Session::get('danger'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Fehler</h4>
                    {{{ $message }}}
                </div>
            @endif

            <!-- Content -->
            @yield('content')

        </div>

		<!-- Scripts are placed here -->
        {{ HTML::script('js/jquery-1.11.1.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/elysium.js') }}
    </body>
</html>