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
        @if(Config::get('app.debug'))
            {{ HTML::style('css/elysium.css') }}
            {{ HTML::style('css/bootstrap.css') }}
            {{ HTML::style('css/bootstrap-theme.css') }}
            {{ HTML::style('css/bootstrap-table.min.css') }}
            {{ HTML::style('css/datepicker.css') }}
            {{ HTML::style('css/datepicker3.css') }}
            {{ HTML::style('css/bootstrap-multiselect.css') }}
        @else
            {{ HTML::style('css/all.css') }}
        @endif

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
        <div class="container" id="header">
            <div class="navbar navbar-default navbar-fixed-top" role="navigation">
                 <div class="container">
                    <div class="navbar-header">
                      <div class="navbar-brand"></div>
                    </div>
                    <!-- Everything you want hidden at 940px or less, place within here -->
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            @if ( !Auth::guest() )
                                <li><a href="{{{ URL::to('') }}}">Startseite</a></li>
                                <li><a href="{{{ URL::to('docents') }}}">Dozentensuche</a></li>
                                @if(Auth::user()->isAdmin())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administration <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{{ URL::to('courses') }}}">Vorlesungen</a></li>
                                        <li><a href="{{{ URL::to('user/list') }}}">Benutzer</a></li>
                                        <li><a href="{{{ URL::to('status/list') }}}">Status</a></li>
                                    </ul>
                                </li>
                                @endif
                            @endif
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            @if ( Auth::guest() )
                                <li>{{ HTML::link('login', 'Login') }}</li>
                            @else
                                <li><a href="{{{ URL::to('user/edit/'.Auth::user()->uid) }}}">Profil</a></li>
                                <li>{{ link_to_asset('files/help.pdf', 'Hilfe')}}</li>
                                <li style="font-weight: bold;">{{ HTML::link('logout', 'Logout') }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <!-- Container -->
        <div class="container">
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
        @if(Config::get('app.debug'))
            {{ HTML::script('js/jquery-1.11.1.min.js') }}
			{{ HTML::script('js/bootstrap.js') }}
			{{ HTML::script('js/bootstrap-table.js') }}
            {{ HTML::script('js/bootstrap-table-de-DE.min.js') }}
            {{ HTML::script('js/bootstrap-multiselect.js') }}
            {{ HTML::script('js/jquery.toaster.js') }}
            {{ HTML::script('js/bootstrap-datepicker.js') }}
            {{ HTML::script('js/bootstrap-datepicker.de.js') }}
            {{ HTML::script('js/elysium.js') }}
        @else
			{{ HTML::script('js/all.js') }}
        @endif
			{{ HTML::script('js/tableExport.js') }}
    </body>
</html>