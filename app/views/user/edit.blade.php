@extends('...layouts.master')

@section('title')
@parent
:: Benutzer
@stop

@section('content')
<h1>Benutzer</h1>

<div class="modal fade" id="modalUserPassword" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Passwort</h4>
      </div>
	  {{ Form::open() }}
	  {{ Form::hidden('userPasswordUid', $uid)}}
      <div class="modal-body">
			<div class="form-group">
				<label for="password" class="control-label">Neues Passwort</label>
				{{Form::password('password', array('class'=>'form-control'))}}

			</div>
			<div class="form-group">
                <label for="passwordConfirm" class="control-label">Neues Passwort bestätigen</label>
                {{Form::password('passwordConfirm', array('class'=>'form-control'))}}
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

<div class="row">
    <div class="col-md-8">
    <?php
    $user   = null;
    if ($uid) {
        $user	= User::find($uid);
    }
    ?>
            @if(!$user==null)
            {{ Form::open(array('url' => 'user/edit/update','class'=> 'form-horizontal', 'autocomplete' => 'off'))}}
            @else
            {{ Form::open(array('url' => 'user/edit/updateNew','class'=> 'form-horizontal', 'autocomplete' => 'off'))}}
            @endif



                {{ Form::hidden('uid',$uid)}}


                <div class="form-group">
                    {{Form::label('firstname', 'Vorname',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::text('firstname', ($user ? $user->firstname : ''), array('class'=>'form-control'))}}
                    </div>
                </div>

                <div class="form-group">
                    {{Form::label('lastname', 'Nachname',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::text('lastname', ($user ? $user->lastname : ''), array('class'=>'form-control'))}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('email', 'E-Mail Addresse',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::email('email', ($user ? $user->email : ''), array('class'=>'form-control'))}}
                    </div>
                </div>
                @if(Auth::user()->isAdmin())
                @if(($user&&!Auth::user()->isCurrentUser($user->uid))||$user==null)
                <div class="form-group">
                    {{Form::label('role', 'Rolle',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::select('role', array(User::ROLE_ADMIN => 'Admin', User::ROLE_USER => 'User'), ($user ? $user->role : 'user'), array('class'=>'form-control'))}}
                    </div>
                </div>
                @endif
                @endif
                                @if($user==null)
                                <div class="form-group">
                                    {{Form::label('password', 'Passwort',array('class'=>'col-sm-3 control-label'))}}

                    <div class="col-sm-9">
                        {{Form::password('password', array('class'=>'form-control'))}}
                    </div>
                                </div>
                                @endif
                <div class="btn-group" style="float:right;" role="group">
                 <a class="btn btn-default" href="{{{ URL::to('user/list/') }}}">Abbrechen</a>
                 @if(!$user==null)
                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUserPassword" data-uid="{{$uid}}">Neues Passwort</button>
		         @endif
		         {{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
                 </div>

         {{ Form::close() }}

    </div>
</div>


@stop