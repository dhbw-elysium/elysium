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
				<th>Gruppe</th>
				<th>Titel</th>
				<th style="width:70px;">Aktion</th>
			</tr>
		  </thead>
		  <tbody>
			@if (count($docents	= Docent::paginate(2)))
				@foreach ($docents as $docent)
				<tr>
					<td>{{{$docent->did}}}</td>

					<td>{{{$docent->title}}}</td>
					<td>
						<button type="button" class="btn btn-default btn-xs">
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-xs">
						  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
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