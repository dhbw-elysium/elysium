@extends('...layouts.master')

@section('title')
@parent
:: Status
@stop

@section('content')
<h1>Status Verwaltung</h1>

<!-- Modal	status -->
<div class="modal fade" id="modalStatusDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Status in den Papierkorb verschieben</h4>
      </div>
	  {{ Form::open(array('url' => 'status/delete')) }}
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

<div class="row">
	<div class="panel-body">
		<table class="table table-striped table-grid table-hover">
		  <thead>
			<tr>
				<th class="row-id">#</th>
				<th>Symbol</th>
				<th>Titel</th>
				<th>Themenbereich</th>
				<th class="row-action">
					<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalStatus" data-cid="0" data-cgid="" data-title="" title="Neue Vorlesung hinzufügen">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</button>
				</th>
			</tr>
		  </thead>
		  <tbody>
			@if (count($statusList	= Status::orderBy('title')->paginate(15)))
				@foreach ($statusList as $status)
				<tr>
					<td class="row-id">{{{$status->sid}}}</td>
					<td>
						@if($status->glyph)
							<i class="glyphicon {{{$status->glyph}}}"></i>
						@else
							<i class="text-label-empty">(keines)</i>
						@endif
					</td>
					<td>{{{$status->title}}}</td>
					<td>{{{$status->description}}}</td>
					<td class="row-action">
						<button type="button" class="btn btn-default btn-xs">
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalStatusDelete" data-cid="{{{$status->sid}}}" data-title="{{$status->title}}">
						  <span class="glyphicon glyphicon glyphicon-trash" aria-hidden="true"></span>
						</button>
					</td>
				</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4"><i>Keine Status vorhanden</i></td>
				</tr>
			@endif
		  </tbody>
		</table>
		<div>
			{{ $statusList->links() }}
		</div>

</div>
@stop