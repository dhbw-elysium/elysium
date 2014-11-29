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

<!-- Modal	courseGroup -->
<div class="modal fade" id="modalCourseGroup" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Vorlesung</h4>
      </div>
	  {{ Form::open(array('url' => 'course_group/update')) }}
	  {{ Form::hidden('cgid', '0', array('id' => 'courseGroupCgid')); }}
      <div class="modal-body">
			<div class="form-group">
				<label for="courseGroupTitle" class="control-label">Titel</label>
            	<input type="text" class="form-control" id="courseGroupTitle">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn-primary">Speichern</button>
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="row">
	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Vorlesungen</h2>
			</div>
		 	<div class="panel-body">
				<table class="table table-striped">
				  <thead>
					<tr>
						<th>#</th>
						<th>Themenbereich</th>
						<th>Titel</th>
						<th style="width:70px;">
							<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalCourse" data-cid="0" data-cgid="" data-title="" title="Neue Vorlesung hinzufügen">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
							</button>
						</th>
					</tr>
				  </thead>
				  <tbody>
					@if (count($courses	= Course::orderBy('title')->paginate(2)))
						@foreach ($courses as $course)
						<tr>
							<td>{{{$course->cid}}}</td>
							<td>{{{$course->courseGroup->title}}}</td>
							<td>{{{$course->title}}}</td>
							<td>
								<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalCourse" data-cid="{{{$course->cid}}}" data-cgid="{{{$course->cgid}}}" data-title="{{$course->title}}">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-danger btn-xs">
								  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4"><i>Keine Vorlesungen eingetragen</i></td>
						</tr>
					@endif
				  </tbody>
				</table>
				<div>
					{{ $courses->links() }}
				</div>
			</div>
		</div>

	</div>

	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Themenbereiche</h2>
			</div>
		 	<div class="panel-body">
				<table class="table table-striped">
				  <thead>
					<tr>
						<th>#</th>
						<th>Titel</th>
						<th style="width:70px;">
							<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalCourseGroup" data-cgid="0" data-title="" title="Neuen Themenbereich hinzufügen">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
							</button>
						</th>
					</tr>
				  </thead>
				  <tbody>
					@if (count($groups	= CourseGroup::orderBy('title')->get()))
						@foreach ($groups as $group)
						<tr>
							<td>{{{$group->cgid}}}</td>
							<td>{{{$group->title}}}</td>
							<td>
								<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalCourseGroup" data-cgid="{{{$group->cgid}}}" data-title="{{$group->title}}">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-danger btn-xs">
								  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
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