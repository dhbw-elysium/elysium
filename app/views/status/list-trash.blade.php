@extends('...layouts.master')

@section('title')
@parent
:: Status Verwaltung
@stop

@section('content')
<h1>Statusverwaltung</h1>

<!-- Modal	status -->
<div class="modal fade" id="modalStatusRestore" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Status wiederherstellen</h4>
      </div>
	  {{ Form::open(array('url' => 'restore')) }}
	  {{ Form::hidden('sid', '0', array('id' => 'statusRestoreSid')); }}
      <div class="modal-body">
		  <p>Möchten Sie den Status &raquo;<span id="statusRestoreTitle" style="color:#454545;"></span>&laquo; wirklich wiederherstellen?</p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Status wiederherstellen', array('class' => 'btn btn-primary')) }}
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
        <li role="presentation"><a href="list" aria-controls="statusActive" role="tab">Status aktiv</a></li>
        <li role="presentation"  class="active"><a href="#statusInactive" aria-controls="statusInactive" role="tab">Status inaktiv</a></li>

      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="statusActive">
         </div>
                <div role="tabpanel" class="tab-pane active" id="statusInactive">

                <table class="table table-striped table-grid table-hover">
                		  <thead>
                			<tr>
                				<th class="row-id">#</th>
                				<th style="max-width:60px;">Symbol</th>
                				<th>Titel</th>
                				<th>Beschreibung</th>
                				<th class="row-action">
                				</th>
                			</tr>
                		  </thead>
                		  <tbody>
                			@if (count($statusList	= Status::onlyTrashed()->orderBy('title')->paginate(15)))
                				@foreach ($statusList as $status)
                				<tr>
                					<td class="row-id">{{{$status->sid}}}</td>
                					<td>
                						@if($status->glyph)
                							<i class="{{{$status->glyph}}}"></i>
                						@else
                							<i class="text-label-empty">(keines)</i>
                						@endif
                					</td>
                					<td>{{{$status->title}}}</td>
                					<td>{{{$status->description}}}</td>
                					<td class="row-action">

                						<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalStatusRestore" data-sid="{{{$status->sid}}}" data-title="{{$status->title}}">
                						  <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                						</button>
                					</td>
                				</tr>
                				@endforeach
                			@else
                				<tr>
                					<td colspan="4"><i>Kein Status im Papierkorb vorhanden</i></td>
                				</tr>
                			@endif
                		  </tbody>
                		</table>
                		<div>
                			{{ $statusList->links() }}
                		</div>

                </div>
              </div>

            </div>






    </div>
    </div>
@stop