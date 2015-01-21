@extends('...layouts.master')

@section('title')
@parent
:: Dozenten
@stop

@section('content')
<h1>Dozenten</h1>

<div class="row" id="docent-list-page">
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
				<label for="filterDocent">Vorlesungen:</label>
				<select multiple class="docents-filter-dropdown" name="filterCourse">
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
				<label for="filterDocent">Status:</label>
				<select multiple class="docents-filter-dropdown" name="filterCourse">
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
					<th data-field="status" data-sortable="true" data-formatter="docentStatusFormatter">Status</th>
					<th data-field="course" data-sortable="false" class="tag-column">Kurs</th>
				</tr>
			</thead>

		</table>


	<div>
		<div class="btn-group" role="group" style="float:right;">
		  <a href="docents/import/upload" class="btn btn-default"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> Importieren</a>
		  <a href="docents/export" class="btn btn-default"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Exportieren</a>
		</div>
	</div>
</div>

@stop