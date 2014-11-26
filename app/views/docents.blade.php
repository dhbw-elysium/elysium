@extends('layouts.master')

@section('title')
@parent
:: Secret
@stop

@section('content')
<h1>Dozenten</h1>

<div class="row">
	<div class="">
		<table class="table table-striped">
		  <thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Status</th>
				<th>Kurse</th>
			</tr>
		  </thead>
		  <tbody>
			@if (count($docents	= Docent::paginate(2)))
				@foreach ($docents as $docent)
				<tr>
					<td>{{{$docent->did}}}</td>
					<td>{{{$docent->first_name.' '.$docent->last_name}}}</td>
					<td>{{{$docent->title}}}</td>
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