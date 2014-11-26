@extends('layouts.master')

@section('title')
@parent
:: Secret
@stop

@section('content')
<h1>Kurse und Kursgruppen</h1>

<div class="modal fade" id="modalCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Kurs</h4>
      </div>
      <div class="modal-body">
		{{ Form::open(array('url' => 'course/update', 'class' => '')) }}
		{{ Form::hidden('cid', '0'); }}

			<div class="form-group">
            	<label for="recipient-name" class="control-label">Gruppe</label>
            	<select class="form-control" id="course-cgid">
            		@if (count($groups = CourseGroup::orderBy('title')->get()))
						@foreach ($groups as $group)
							<option value="{{{$group->cgid}}}">{{{$group->title}}}</option>
						@endforeach
					@endif
				</select>
          	</div>
			<div class="form-group">
				<label for="message-text" class="control-label">Titel</label>
            	<input type="text" class="form-control" id="course-title">
			</div>
		{{ Form::close() }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
        <button type="button" class="btn btn-primary">Speichern</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Kurse</h2>
			</div>
		 	<div class="panel-body">
				<table class="table table-striped">
				  <thead>
					<tr>
						<th>#</th>
						<th>Gruppe</th>
						<th>Titel</th>
						<th style="width:70px;">Aktion</th>
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
							<td colspan="4"><i>Keine Kurse eingetragen</i></td>
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
				<h2 class="panel-title">Kursgruppen</h2>
			</div>
		 	<div class="panel-body">
				<table class="table table-striped">
				  <thead>
					<tr>
						<th>#</th>
						<th>Titel</th>
						<th style="width:70px;">Aktion</th>
					</tr>
				  </thead>
				  <tbody>
					@if (count($groups	= CourseGroup::orderBy('title')->get()))
						@foreach ($groups as $group)
						<tr>
							<td>{{{$group->cgid}}}</td>
							<td>{{{$group->title}}}</td>
							<td>
								<button type="button" class="btn btn-default btn-xs" value="">
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
							<td colspan="3"><i>Keine Kursgruppen eingetragen</i></td>
						</tr>
					@endif
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop