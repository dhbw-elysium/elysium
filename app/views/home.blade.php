@extends('layouts.master')

@section('title')
@parent
:: Start
@stop

@section('content')
<h1>Hallo {{Auth::user()->title.' '.Auth::user()->lastname}}</h1>
<p>This page is created using a master template.</p>
@stop