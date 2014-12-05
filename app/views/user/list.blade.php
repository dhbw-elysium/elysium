@extends('...layouts.master')

@section('title')
@parent
:: Benutzer
@stop

@section('content')
<h1>Benutzer</h1>

				<table class="table table-striped table-grid">
				  <thead>
					<tr>
						<th class="row-id">#</th>
						<th>Nachname</th>
						<th>Vorname</th>
						<th>Rolle</th>
						<th class="row-action">
							<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalCourse" data-cid="0" data-cgid="" data-title="" title="Neue Vorlesung hinzufügen">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
							</button>
						</th>
					</tr>
				  </thead>
				  <tbody>
					@if (count($users	= User::orderBy('lastname')->orderBy('firstname')->paginate(15)))
						@foreach ($users as $user)
						<tr>
							<td class="row-id">{{{$user->uid}}}</td>
							<td>{{{$user->lastname}}}</td>
							<td>{{{$user->firstname}}}</td>
							<td>{{{$user->role}}}</td>
							<td class="row-action">
								<a class="btn btn-default btn-xs" href="{{{ URL::to('user/edit') }}}">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</a>
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
					{{ $users->links() }}
				</div>

@stop