@extends('...layouts.master')

@section('title')
@parent
:: Dozenten
@stop

@section('content')
<div class="row">
	<div class="col-md-4">
		<h1>Dozenten</h1>
	</div>
	<div class="col-md-8">
		<div style="float: right;margin-top: 20px;margin-bottom: 10px;">
			<a href="docents/import/upload" class="btn btn-default"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> Importieren</a>
		</div>
	</div>
</div>

<div class="row" id="docent-list-page">
	<div class="col-md-12">
	<!--
	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">
		  </a>
		</div>
	  </div>
	</nav>
	-->
	<div class="">
		<div id="docent-list-toolbar" class="form-inline">

			<div class="form-group">
				<label for="filterCourse">Vorlesungen:</label>
				<select multiple class="docents-filter-dropdown filter-course" name="filterCourse">
					@if (count($groups	= CourseGroup::orderBy('title')->get()))
						@foreach ($groups as $group)
							@if (count($courses	= Course::where('cgid', '=', $group->cgid)->orderBy('title')->get()))
						  <optgroup label="{{{$group->title}}}">
								@foreach ($courses as $course)
								  <option value="{{$course->cid}}">{{{$course->title}}}</option>
								@endforeach
						  </optgroup>
							@endif
						@endforeach
					@endif
				</select>
			</div>

			<div class="form-group">
				<label for="filterStatus">Status:</label>
				<select multiple class="docents-filter-dropdown filter-status" name="filterStatus">
				@if (count($stautsList	= Status::orderBy('title')->get()))
					@foreach ($stautsList as $status)
					  <option value="{{$status->sid}}" title="{{{$status->description}}}">{{{$status->title}}}</option>
					@endforeach
				@endif
				</select>
			</div>

 		</div>
	<div class="">
 		<table id="docent-list" class="table table-grid table-docent-list table-hover table-clickable" data-id-field="did" data-toggle="table" data-url="docents/list.json" data-cache="false" data-pagination="true" data-side-pagination="client" data-show-refresh="true" data-show-columns="true" data-search="true" data-toolbar="#docent-list-toolbar" data-striped="true" data-show-filter="true">
			<thead>
				<tr>
					<th data-field="did" data-sortable="true" data-visible="false">#</th>
					<th data-field="first_name" data-sortable="true">Vorname</th>
					<th data-field="last_name" data-sortable="true" data-order="asc">Nachname</th>
					<th data-field="status" data-sortable="true" data-formatter="docentStatusFormatter" data-width="270">Status</th>
					<th data-field="course" data-sortable="false" class="tag-column">Kurs</th>
				</tr>
			</thead>

		</table>
	</div>
</div>
@stop