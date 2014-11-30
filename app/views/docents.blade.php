@extends('layouts.master')

@section('title')
@parent
:: Dozenten
@stop

@section('content')
<h1>Dozenten</h1>

<div class="row">
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

</div>

@stop