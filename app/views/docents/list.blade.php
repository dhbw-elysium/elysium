@extends('...layouts.master')

@section('title')
@parent
:: Dozenten
@stop

@section('content')
<h1>Dozenten</h1>

<div class="row">
	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">
		  </a>
		</div>
	  </div>
	</nav>
	<div class="">
		<table class="table table-striped table-grid">
		  <thead>
			<tr>
				<th class="row-id">#</th>
				<th>Name</th>
				<th>Status</th>
				<th>Kurse</th>
			</tr>
		  </thead>
		  <tbody>
			@if (count($docents	= Docent::paginate(2)))
				@foreach ($docents as $docent)
				<tr>
					<td class="row-id">{{{$docent->did}}}</td>
					<td>{{{$docent->first_name.' '.$docent->last_name}}}</td>
					<td>{{{$docent->title}}}</td>
					<td>
					@if (count($courses	= $docent->courses))
						@foreach ($courses as $course)
						<span class="label label-primary label-course-tag">{{{$course->title}}}</span>
						@endforeach
					@endif
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