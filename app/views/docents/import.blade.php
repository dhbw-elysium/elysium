@extends('...layouts.master')

@section('title')
@parent
:: Dozenten Importieren (1/3)
@stop

@section('content')
<h1>Dozenten Importieren</h1>



<ul class="nav nav-tabs">
  <li role="presentation" class="active"><a href="#">Hochladen</a></li>
  <li role="presentation" class="disabled"><a href="#">Überprüfen</a></li>
  <li role="presentation" class="disabled"><a href="#">Zusammenfassung</a></li>
</ul>


<div class="bs-callout bs-callout-info" style="width:400px;margin:20px auto;padding:20px;border:1px solid #eee; border-radius: 5px;">
	{{ Form::open(array('url' => 'docents/import/process','files'=>true)) }}

	<div class="form-group">
		<label for="exampleInputFile">Excel Datei</label>
		{{ Form::file('file', '',array('id'=>'','class'=>'')) }}
	</div>
	{{ Form::submit('Import beginnen', array('class' => 'btn btn-primary btn-lg btn-block')) }}
</div>



@stop