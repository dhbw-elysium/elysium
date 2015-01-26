@extends('...layouts.master')

@section('title')
@parent
:: Status Verwaltung
@stop

@section('content')
<h1>Statusverwaltung</h1>

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
		  <p>Bei Dozenten, denen ein solcher Status zugewiesen ist, wird er weiterhin angezeigt. Sie können ihn aber nicht erneut einem Dozenten zuweisen.</p>
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


	<div role="tabpanel">

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#statusActive" aria-controls="statusActive" role="tab">Status aktiv</a></li>
        <li role="presentation"><a href="list-trash" aria-controls="statusInactive" role="tab">Status inaktiv</a></li>

      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="statusActive">
            <table class="table table-striped table-grid table-hover">
        		  <thead>
        			<tr>
        				<th class="row-id">#</th>
        				<th style="max-width:60px;">Symbol</th>
        				<th>Titel</th>
        				<th>Beschreibung</th>
        				<th class="row-action">
        					<a class="btn btn-default btn-add btn-xs" href="new" data-toggle="tooltip" data-placement="left" title="Neuen Status hinzufügen">
        					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        					</a>
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
        						<a class="btn btn-default btn-xs" href="edit/{{{$status->sid}}}" data-toggle="tooltip" data-placement="left" title="Status bearbeiten">
        						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        						</a>
        						<button type="button" class="btn btn-default btn-remove btn-xs" data-toggle="modal" data-target="#modalStatusDelete" data-sid="{{{$status->sid}}}" data-title="{{{$status->title}}}" {{($status->sid == Status::STATUS_IMPORT || $status->sid == Status::STATUS_RECEIVED) ? 'disabled' : ''}}>
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
        <div role="tabpanel" class="tab-pane" id="statusInactive">

        </div>
      </div>

    </div>




</div>
</div>
@stop