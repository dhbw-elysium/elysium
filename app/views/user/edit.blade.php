@extends('...layouts.master')

@section('title')
@parent
:: Benutzer
@stop

@section('content')
<h1>Benutzer</h1>

<div class="row">
    <div class="col-md-8">
            {{ Form::open(array('url' => 'user/edit/update','class'=> 'form-horizontal'))}}

@if ($user	= User::find($uid))

                {{ Form::hidden('uid',$uid)}}


                <div class="form-group">
                    {{Form::label('firstname', 'Vorname',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::text('firstname', $user->firstname, array('class'=>'form-control'))}}
                    </div>
                </div>

                <div class="form-group">
                    {{Form::label('lastname', 'Nachname',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::text('lastname', $user->lastname, array('class'=>'form-control'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('email', 'E-Mail Addresse',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::email('email', $user->email, array('class'=>'form-control'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('password', 'New Password',array('class'=>'col-sm-3 control-label'))}}
                    {{--Passwortfeld in Modales Fenster auslagern--}}
                    <div class="col-sm-9">
                        {{Form::password('password', array('class'=>'form-control'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('role', 'Rolle',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::select('role', array($user::ROLE_ADMIN => 'Admin', $user::ROLE_USER => 'User'), $user->role, array('class'=>'form-control'))}}
                    </div>
                </div>

                <button type="button" class="btn btn-default" >Abbrechen</button>
		            {{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}

         @endif
         {{ Form::close() }}

    </div>
</div>
@stop