@extends('...layouts.master')

@section('title')
@parent
:: Dozenten Importieren (3/3)
@stop

@section('content')
<h1>Dozenten Importieren</h1>




<ul class="nav nav-tabs nav-import-docents">
  <li role="presentation" class="disabled"><a href="#">Hochladen</a></li>
  <li role="presentation" class="disabled"><a href="#">Überprüfen</a></li>
  <li role="presentation" class="active"><a href="#">Zusammenfassung</a></li>
</ul>

<div class="row">
	<div class="alert alert-success" role="alert">
		<strong>Import erfolgreich</strong>
		Es wurden {{$docentCount}} Dozenten importiert.
	</div>

</div>


@stop

