@extends('layouts.master')

@section('title')
@parent
:: Start
@stop

@section('content')

<h1>Hallo {{{Auth::user()->title.' '.Auth::user()->lastname}}}</h1>
<?php

$lastLogin = new DateTime(Session::get('last_login', null));

$nrNewDocents=Docent::getNumberOfNewDocents(Session::get('last_login', 0));
?>
<div class="row">
<div class="col-sm-7">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Neue Dozenten (seit Ihrem letzten Login am {{$lastLogin->format('d.m.Y');}})</h2>
			</div>

<table class="table table-striped table-grid table-hover">
 				  <thead>
 					<tr>
 						<th class="row-id">#</th>
 						<th>Nachname</th>
 						<th>Vorname</th>
 						<th>Importiert am</th>
 						<th class="row-action">

 						</th>
 					</tr>
 				  </thead>
 				  <tbody>

            		@if (count($docentList = Docent::where('created_at','>=', $lastLogin)->orderBy('last_name')->paginate(15)))
						@foreach ($docentList as $docent)

                            <tr>
                            <td class="row-id">{{{$docent->did}}}</td>
                            <td>{{{$docent->last_name}}}</td>
                            <td>{{{$docent->first_name}}}</td>
                            <td>{{{$docent->created_at->format('d.m.Y')}}}</td>
                            <td class="row-action">
                            <a class="btn btn-default btn-xs" href="{{{ URL::to('docent/'.$docent->did) }}}">
                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </a>
                            </td>
                            </tr>


						@endforeach

						     @else
                               <tr>
                                <td colspan="4"><i>Keine neuen Dozenten vorhanden</i></td>
                                </tr>
                             @endif


                    </tbody>
                    </table>
                    <div>
                    {{ $docentList->links() }}
                    </div>
</div>
</div>
<div class="col-sm-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2 class="panel-title">Dozenten mit folgendem Status im System</h2>
			</div>
 <ul class="list-group">
  @if (count($statuses	= Status::orderBy('sid')->paginate(15)))
  @foreach ($statuses as $status)
  <a href="{{{ URL::to('docents?sid='.$status->sid) }}}" class="list-group-item">{{{$status->title}}}<span class="badge">{{count(Docent::docentListWithLatestStatus($status->sid))}}</span></a>
  @endforeach
  @else
  <a class="list-group-item">keine Status eingetragen</a>
  @endif
<div>
	{{ $statuses->links() }}
</div>
</ul>
</div>
</div>
</div>


@stop