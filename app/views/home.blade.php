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
  <a class="list-group-item">unbearbeitete Dozenten</a>
  <li class="list-group-item">Morbi leo risus</li>
  <li class="list-group-item">Porta ac consectetur ac</li>
  <li class="list-group-item">Vestibulum at eros</li>
</ul>
</div>


@stop