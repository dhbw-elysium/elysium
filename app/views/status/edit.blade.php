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

@if($status	= Status::find($sid))
{{ Form::open()}}
{{ Form::hidden('sid', $sid, array('id' => 'sid')); }}

<div class="row">
	<div class="col-md-4">
		<h1>Status bearbeiten</h1>
	</div>
	<div class="col-md-8">
		<div style="float: right;margin-top: 20px;margin-bottom: 10px;">
			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalStatusDelete" data-sid="{{{$status->sid}}}" data-title="{{$status->title}}">
			  <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span> in Papierkorb verschieben
			</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		  <div class="form-group">
			{{Form::label('title', 'Titel')}}
			{{Form::text('title', (Input::has('title') ? Input::get('title') : $status->title), array('class'=>'form-control', 'placeholder' => 'Titel'))}}
		  </div>
	</div>
	<div class="col-md-8">
		  <div class="form-group">
			{{Form::label('description', 'Beschreibung')}}
			{{Form::text('description', (Input::has('description') ? Input::get('description') : $status->description), array('class'=>'form-control', 'placeholder' => 'Beschreibung', 'rows' => 4))}}
		  </div>
	</div>
</div>

<div class="row glyph-list">
	<div class="form-group">
		<label>Symbol</label>
  	</div>
	<ul>
	@foreach(Status::glyphicons() as $glyph)
		<?php
			$selected	= ($status->glyph == $glyph);

			if($status->glyph == $glyph) {
				$glyphClass	= 'glyhicon-selected ';
			} else {
				$glyphClass	= '';
			}
		?>
		<li class="{{$glyphClass}}">
			<label>
				<div class="glyph-list-box">
					{{Form::radio('glyph', $glyph, $glyph == (Input::has('glyph') ? Input::get('glyph') : $status->glyph))}}
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