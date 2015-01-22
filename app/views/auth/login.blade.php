@extends('layouts.master')

@section('title')
@parent
:: Login
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
    <h2>Anmeldung</h2>
</div>
<div class="row">
<div class="col-sm-offset-4 col-sm-4">
<div class="panel panel-primary" >
<div class="panel-heading">Login</div>
                                    <div class="panel-body">
{{ Form::open(array('url' => 'login', 'class' => 'form-horizontal')) }}




    <!-- Name -->
    <div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
        <div class="col-sm-12">
            <div class="input-group">
			    <span class="input-group-addon">
				    <i class="glyphicon glyphicon-user"></i>
				</span>
    			{{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'E-Mail')) }}
			</div>
		</div>
	</div>

    {{ $errors->first('email') }}

    <!-- Password -->
    <div class="form-group {{{ $errors->has('password') ? 'error' : '' }}}">

		<div class="col-sm-12">
		            <div class="input-group">
        			    <span class="input-group-addon">
        				    <i class="glyphicon glyphicon-lock"></i>
        				 </span>
			            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Passwort')) }}
			         </div>
		</div>
	</div>


            {{ $errors->first('password') }}

    <!-- Login button -->
    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-10">
            {{ Form::submit('Anmelden', array('class' => 'btn btn-default btn-primary btn-block')) }}
        </div>
    </div>

{{ Form::close() }}
</div>
</div>
                                    </div>
                                    </div>
@stop