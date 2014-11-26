@extends('layouts.master')

@section('title')
@parent
:: Secret
@stop

@section('content')
<h1>Kurse und Kursgruppen</h1>

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
					@if (count($courses	= Course::paginate(2)))
						@foreach ($courses as $course)
						<tr>
							<td>{{{$course->cid}}}</td>

							<td>{{{$course->courseGroup->title}}}</td>
							<td>{{{$course->title}}}</td>
							<td>
								<button type="button" class="btn btn-default btn-xs">
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
					@if (count($groups	= CourseGroup::all()))
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