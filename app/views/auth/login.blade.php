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

{{ Form::open(array('url' => 'login', 'class' => 'form-horizontal')) }}

    <!-- Name -->
    <div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
		{{ Form::label('email', 'E-Mail', array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'E-Mail')) }}
		</div>
	</div>

            {{ $errors->first('email') }}

    <!-- Password -->
    <div class="form-group {{{ $errors->has('password') ? 'error' : '' }}}">
		{{ Form::label('password', 'Passwort', array('class' => 'col-sm-2 control-label')) }}
		<div class="col-sm-10">
			{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Passwort')) }}
		</div>
	</div>


            {{ $errors->first('password') }}

    <!-- Login button -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Anmelden', array('class' => 'btn btn-default')) }}
        </div>
    </div>

{{ Form::close() }}
@stop