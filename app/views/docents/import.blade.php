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

{{ Form::open(array('url' => 'docents/import/process','files'=>true)) }}
<div class="row docent-import-begin">
	<div class="col-sm-offset-1 col-sm-4">
		<div class="panel panel-primary" >
			<div class="panel-body">
				<div class="form-group">
					<label>Schritt 1:</label>
					{{ Form::file('file', '',array('id'=>'','class'=>'')) }}
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-offset-1 col-sm-4">
		<div class="panel panel-primary" >
			<div class="panel-body">
				<div class="form-group">
					<label>Schritt 2:</label>
					{{ Form::submit('Import beginnen', array('class' => 'btn btn-primary btn-sm btn-block')) }}
				</div>
			</div>
			</div>
		</div>
	</div>
</div>



@stop