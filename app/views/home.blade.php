@extends('layouts.master')

@section('title')
@parent
:: Start
@stop

@section('content')

<h1>Hallo {{{Auth::user()->title.' '.Auth::user()->lastname}}}</h1>
<p>Seit ihrem letzten Login am {{Session::get('last_login', null);}} gibt es:</p>
<?php
$nrNewDocents=Docent::getNumberOfNewDocents(Session::get('last_login', 0));
?>
<div class="col-sm-6">
<ul class="list-group">
  <a href="{{{ URL::to('docents') }}}" class="list-group-item {{$nrNewDocents!=0 ? 'active' : ''}}">neue Dozenten <span class="badge">{{$nrNewDocents}}</span> </a>
 </ul>
 <ul class="list-group">
  @if (count($statuses	= Status::orderBy('sid')->paginate(15)))
  @foreach ($statuses as $status)
  <a href="{{{ URL::to('docents') }}}" class="list-group-item">{{{$status->title}}}<span class="badge">{{count(Docent::docentListWithLatestStatus($status->sid))}}</span></a>
  @endforeach
  @else
  <a class="list-group-item">keine Stati eingetragen</a>
  @endif

</ul>
</div>


@stop