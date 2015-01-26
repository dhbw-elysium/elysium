@extends('layouts.master')

@section('title')
@parent
:: Dozent (nicht gefunden)
@stop

@section('content')

<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Fehler</h4>
	Der gesuchte Dozent konnte nicht gefunden werden
</div>

@stop