@extends('...layouts.master')

@section('title')
@parent
:: Dozenten
@stop

@section('content')
<h1>Dozenten</h1>

<div class="row" id="docent-list-page">
	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">
		  </a>
		</div>
	  </div>
	</nav>
	<div class="">
		<table class="table table-striped table-grid table-docent-list table-hover table-clickable" id="table-docent-list">
		  <thead>
			<tr>
				<th class="row-id" data-field="did">#</th>
				<th data-field="name">Name</th>
				<th data-field="status">Status</th>
				<th data-field="courses">Kurse</th>
			</tr>
		  </thead>
		  <tbody>
			@if (count($docents	= Docent::paginate(15)))
				@foreach ($docents as $docent)
				<tr data-did="{{{$docent->did}}}">
					<td class="row-id">{{{$docent->did}}}</td>
					<td><a href="docent/{{{$docent->did}}}">{{{$docent->first_name.' '.$docent->last_name}}}</a></td>
					<td>
						@if ($status = $docent->statusLatest())
							@if ($status->glyph)
							<span class="{{$status->glyph}}"></span>
							@endif
							{{{$status->title}}}
						@else
							<i>(leer)</i>
						@endif
					</td>
					<td class="tag-column">
					<div>
					@if (count($courses	= $docent->courses))
						@foreach ($courses as $course)
						<span class="label label-primary label-course-tag">{{{$course->title}}}</span>
						@endforeach
					@endif
					</div>
					</td>

				</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4"><i>Keine Dozenten eingetragen</i></td>
				</tr>
			@endif
		  </tbody>
		</table>
		<div>
			{{ $docents->links() }}
		</div>
	</div>
	<div>
		<div class="btn-group" role="group" style="float:right;">
		  <a href="docents/import/upload" class="btn btn-default"><span class="glyphicon glyphicon-import" aria-hidden="true"></span> Importieren</a>
		  <a href="docents/export" class="btn btn-default"><span class="glyphicon glyphicon-export" aria-hidden="true"></span> Exportieren</a>
		</div>
	</div>



</div>

@stop