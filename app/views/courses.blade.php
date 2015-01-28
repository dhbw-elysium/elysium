@extends('layouts.master')

@section('title')
@parent
:: Vorlesungen
@stop

@section('content')
<h1>Vorlesungen und Themenbereiche</h1>

<!-- Modal	course -->
<div class="modal fade" id="modalCourse" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Vorlesung</h4>
      </div>
	  {{ Form::open(array('url' => 'course/update')) }}
	  {{ Form::hidden('cid', '0', array('id' => 'courseCid')); }}
      <div class="modal-body">
			<div class="form-group">
            	<label for="courseCgid" class="control-label">Themenbereich</label>
            	<select class="form-control" id="courseCgid">
            		@if (count($groups = CourseGroup::orderBy('title')->get()))
						@foreach ($groups as $group)
							<option value="{{{$group->cgid}}}">{{{$group->title}}}</option>
						@endforeach
					@endif
				</select>
          	</div>
			<div class="form-group">
				<label for="courseTitle" class="control-label">Titel</label>
            	<input type="text" class="form-control" id="courseTitle">
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

<!-- Modal	course -->
<div class="modal fade" id="modalCourseDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Vorlesung löschen</h4>
      </div>
	  {{ Form::open(array('url' => 'course/delete')) }}
	  {{ Form::hidden('cid', '0', array('id' => 'courseDeleteCid')); }}
      <div class="modal-body">
		Möchten Sie die Vorlesung &raquo;<span id="courseDeleteTitle" style="color:#454545;"></span>&laquo; wirklich löschen?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Vorlesung löschen', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal	courseGroup -->
<div class="modal fade" id="modalCourseGroup" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Vorlesung</h4>
      </div>
	  {{ Form::open(array('url' => 'courseGroup/update')) }}
	  {{ Form::hidden('cgid', '0', array('id' => 'courseGroupCgid')); }}
      <div class="modal-body">
			<div class="form-group">
				<label for="courseGroupTitle" class="control-label">Titel</label>
            	<input type="text" class="form-control" id="courseGroupTitle">
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

<!-- Modal	course group -->
<div class="modal fade" id="modalCourseGroupDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Themenbereich löschen</h4>
      </div>
	  {{ Form::open(array('url' => 'courseGroup/delete')) }}
	  {{ Form::hidden('cgid', '0', array('id' => 'courseGroupDeleteCgid')); }}
      <div class="modal-body">
		Möchten Sie den Themenbereich &raquo;<span id="courseGroupDeleteTitle" style="color:#454545;"></span>&laquo; wirklich löschen?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Themenbereich löschen', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="row" id="course-page">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Vorlesungen</h2>
			</div>
		 	<div class="panel-body">
				<table id="course-list" class="table table-grid table-docent-list table-hover" data-id-field="cid"
					   data-toggle="table" data-url="courses/list.json" data-cache="false" data-pagination="true"
					   data-side-pagination="client" data-show-refresh="true" data-show-columns="true" data-search="true"
					   data-search-align="right" data-toolbar="#docent-list-toolbar" data-striped="true"
					   data-show-filter="true" data-show-export="true">
					<thead>
						<tr>
							<th data-field="cid" data-sortable="true" data-visible="false">#</th>
							<th data-field="course_title" data-sortable="true">Vorlesung</th>
							<th data-field="group_title" data-sortable="true" data-order="asc">Themen&shy;bereich</th>
							<th data-field="created_at" data-sortable="true" data-visible="false">Erstellt am</th>
							<th data-field="created_by_name" data-sortable="true" data-visible="false">Erstellt von</th>
							<th data-field="updated_at" data-sortable="true" data-visible="false">Bearbeitet am</th>
							<th data-field="updated_by_name" data-sortable="true" data-visible="false">Bearbeitet von</th>
							<th data-sortable="false" data-formatter="courseButtonsFormatter" data-visible="true" data-align="right" data-width="60">
								<span class="title">Aktion</span>
								<span class="action">
									<button type="button" class="btn btn-default btn-add btn-xs" data-toggle="modal" data-target="#modalCourse" data-cid="0" data-cgid="" data-title="" title="Neue Vorlesung hinzufügen">
										<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
									</button>
								</span>
							</th>
						</tr>
					</thead>
				</table>

			</div>
		</div>

	</div>

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Themenbereiche</h2>
			</div>
		 	<div class="panel-body" style="padding-top: 31px;">
				<table class="table table-striped table-grid">
				  <thead>
					<tr>
						<th class="row-id">#</th>
						<th>Titel</th>
						<th class="row-action">
							<button type="button" class="btn btn-default btn-add btn-xs" data-toggle="modal" data-target="#modalCourseGroup" data-cgid="0" data-title="" title="Neuen Themenbereich hinzufügen">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
							</button>
						</th>
					</tr>
				  </thead>
				  <tbody>
					@if (count($groups	= CourseGroup::orderBy('title')->get()))
						@foreach ($groups as $group)
						<tr>
							<td class="row-id">{{{$group->cgid}}}</td>
							<td>{{{$group->title}}}</td>
							<td class="row-action">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalCourseGroup" data-cgid="{{{$group->cgid}}}" data-title="{{$group->title}}">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
									<button type="button" class="btn btn-default btn-remove btn-xs" data-toggle="modal" data-target="#modalCourseGroupDelete" data-cgid="{{{$group->cgid}}}" data-title="{{$group->title}}">
									  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
									</button>
								</div>
							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="3"><i>Keine Themenbereiche eingetragen</i></td>
						</tr>
					@endif
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop