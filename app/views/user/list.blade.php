@extends('...layouts.master')

@section('title')
@parent
:: Benutzer
@stop

@section('content')

<!-- Modal	course -->
<div class="modal fade" id="modalUserDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Benutzer löschen</h4>
      </div>
	  {{ Form::open(array('url' => 'user/delete')) }}
	  {{ Form::hidden('uid', '0', array('id' => 'userDeleteUid')); }}
      <div class="modal-body">
		Möchten Sie den Benutzer &raquo;<span id="userDeleteName" style="color:#454545;"></span>&laquo; wirklich löschen?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Benutzer löschen', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<h1>Benutzer</h1>
<div class="row">
	<div class="panel-body">

				<table class="table table-striped table-grid">
				  <thead>
					<tr>
						<th class="row-id">#</th>
						<th>Nachname</th>
						<th>Vorname</th>
						<th>Rolle</th>
						<th class="row-action">
							<a class="btn btn-default btn-add btn-xs" href="{{{ URL::to('user/new') }}}">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
							</a>
						</th>
					</tr>
				  </thead>
				  <tbody>
					@if (count($users	= User::orderBy('lastname')->orderBy('firstname')->paginate(15)))
						@foreach ($users as $user)
						<tr>
							<td class="row-id">{{{$user->uid}}}</td>
							<td>{{{$user->lastname}}}</td>
							<td>{{{$user->firstname}}}</td>
							<td>{{{$user->role}}}</td>
							<td class="row-action">
								<a class="btn btn-default btn-xs" href="{{{ URL::to('user/edit/'.$user->uid) }}}">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>

								<button type="button" class="btn btn-default btn-remove btn-xs {{(($user->isCurrentUser(Auth::user()->uid)) ? 'disabled' : '')}}" data-toggle="modal" data-target="#modalUserDelete" data-uid="{{{$user->uid}}}" data-name="{{{$user->lastname.', '.$user->firstname}}}"  >
								  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>

							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4"><i>Kein Benutzern eingetragen</i></td>
						</tr>
					@endif
				  </tbody>
				</table>
				<div>
					{{ $users->links() }}
				</div>

	</div>
</div>
@stop