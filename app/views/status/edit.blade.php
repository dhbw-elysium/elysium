@extends('...layouts.master')

@section('title')
@parent
:: Status bearbeiten
@stop

@section('content')

<!-- Modal	status -->
<div class="modal fade" id="modalStatusDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Status in den Papierkorb verschieben</h4>
      </div>
	  {{ Form::open(array('url' => 'delete')) }}
	  {{ Form::hidden('sid', '0', array('id' => 'statusDeleteSid')); }}
      <div class="modal-body">
		  <p>Möchten Sie den Status &raquo;<span id="statusDeleteTitle" style="color:#454545;"></span>&laquo; wirklich in den Papierkorb verschieben?</p>
		  <p>Bei Dozenten denen ein solcher Status zugewiesen ist wird er weiterhin angezeigt. Sie können ihn aber nicht erneut einem Dozenten zuweisen.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Status in Papierkorb verschieben', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@if($sid === null || $status = Status::find($sid))
{{ Form::open()}}
{{ Form::hidden('sid', ($sid === null ? 0 : $sid), array('id' => 'sid')); }}

<div class="row">
	<div class="col-md-4">
		@if($sid)
		<h1>Status bearbeiten</h1>
		@else
		<h1>Status erstellen</h1>
		@endif
	</div>
	<div class="col-md-8">
		@if($sid)
		<div style="float: right;margin-top: 20px;margin-bottom: 10px;">
			<button type="button" class="btn btn-default btn-remove" data-toggle="modal" data-target="#modalStatusDelete" data-sid="{{{$status->sid}}}" data-title="{{$status->title}}" {{($status->sid == Status::STATUS_IMPORT) ? 'disabled' : ''}}>
			  <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span> in Papierkorb verschieben
			</button>
		</div>
		@endif
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		  <div class="form-group">
			{{Form::label('title', 'Titel')}}
			{{Form::text('title', ((Input::has('title') || $sid === null) ? Input::get('title') : $status->title), array('class'=>'form-control', 'placeholder' => 'Titel', 'required'))}}
		  </div>
	</div>
	<div class="col-md-8">
		  <div class="form-group">
			{{Form::label('description', 'Beschreibung')}}
			{{Form::text('description', ((Input::has('description') || $sid === null) ? Input::get('description') : $status->description), array('class'=>'form-control', 'placeholder' => 'Beschreibung', 'rows' => 4, 'required'))}}
		  </div>
	</div>
</div>

<div class="row glyph-list">
	<div class="form-group">
		<label>Symbol</label>
  	</div>
	<ul>
	@foreach(Status::glyphicons(true) as $glyph)
		<?php
			$glyphClass	= '';

			if ($sid !== null) {
				$selected	= ($status->glyph == $glyph);

				if($status->glyph == $glyph) {
					$glyphClass	= 'glyhicon-selected ';
				}
			}
		?>
		<li class="{{$glyphClass}}">
			<label>
				<div class="glyph-list-box">
					{{Form::radio('glyph', $glyph, $glyph == ((Input::has('glyph') || $sid === null) ? Input::get('glyph', 'glyphicon glyphicon-ok') : $status->glyph))}}
				</div>
				<div class="glyph-list-preview">
					<div>
						<span class="glyphicon {{{$glyph}}}" aria-hidden="true"></span>
					</div>
					<div class="glyphicon-class">{{{str_replace('glyphicon-', '', $glyph)}}}</div>
				</div>
			</label>
        </li>
	@endforeach
	</ul>
</div>
<div class="row">
	<div class="col-xs-1" style="margin-top: 10px;margin-bottom: 40px;">
	@if($sid === null)
	    <a class="btn btn-default" href="list">Abbrechen</a>
	 @else
		<a class="btn btn-default" href="../../status/list">Abbrechen</a>
		@endif
	</div>
	<div class="col-xs-1" style="margin-top: 10px;margin-bottom: 40px;">
		{{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
	</div>
</div>

{{ Form::close() }}

@else
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Fehler</h4>
	<p>Der gewählte Status konnte nicht gefunden werden!</p>
</div>

@endif

@stop