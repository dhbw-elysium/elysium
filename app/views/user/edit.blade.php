@extends('...layouts.master')

@section('title')
@parent
:: Benutzer
@stop

@section('content')
<h1>Benutzer</h1>

<div class="row">
    <div class="col-md-8">
    @if ($user	= User::find($uid))
            {{ Form::open(array('url' => 'user/edit/update','class'=> 'form-horizontal'))}}



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
                    {{Form::label('role', 'Rolle',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::select('role', array($user::ROLE_ADMIN => 'Admin', $user::ROLE_USER => 'User'), $user->role, array('class'=>'form-control'))}}
                    </div>
                </div>

                <a class="btn btn-default" href="{{{ URL::to('user/list/') }}}">Abbrechen</a>

		            {{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
		             <a type="button" class="btn btn-primary" data-toggle="modal" href="#modalPassword">New Password
                                    </a>


         {{ Form::close() }}

    </div>
</div>

<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Passwort</h4>
      </div>
	  {{ Form::open(array('url' => 'user/edit/update/password')) }}
	  {{ Form::hidden('uid',$uid)}}
      <div class="modal-body">
			<div class="form-group">
				<label for="userPassword" class="control-label">Neues Passwort</label>
				{{Form::password('userPassword',array('class'=>'form-control'))}}

			</div>
			<div class="form-group">
            				<label for="userPasswordConfirmation" class="control-label">Neues Passwort bestätigen</label>
                        	{{Form::password('userPasswordConfirmation',array('class'=>'form-control'))}}

            			</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 @endif
@stop