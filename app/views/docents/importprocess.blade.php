@extends('...layouts.master')

@section('title')
@parent
:: Dozenten Importieren (2/3)
@stop

@section('content')
<h1>Dozenten Importieren</h1>




<ul class="nav nav-tabs">
  <li role="presentation" class="disabled"><a href="#">Hochladen</a></li>
  <li role="presentation" class="active"><a href="#">Überprüfen</a></li>
  <li role="presentation" class="disabled"><a href="#">Zusammenfassung</a></li>
</ul>


{{ Form::open(array('url' => 'docents/import/process')) }}
{{ Form::hidden('posted', '1') }}


@if (count($docents))
	@foreach ($docents as $id => $docent)

<div class="panel panel-default" style="padding: 1em;">
	<div class="container-fluid">
	  <div class="form-horizontal" role="form">

		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<input type="checkbox" id="docent[{{$id}}][include]" checked="checked"> <label for="docent[{{$id}}][include]" class="control-label"> Diesen Dozenten-Datensatz beim Import mit aufnehmen</label>

		  	</div>
	  	</div>

		<div class="row">
			{{ Form::docentBlock($id, 'salution', 'Anrede:') }}
			{{ Form::docentBlock($id, 'title', 'Titel:') }}

			{{ Form::docentBlock($id, 'first_name', 'Vorname:') }}
			{{ Form::docentBlock($id, 'last_name', 'Nachname:') }}

			{{ Form::docentBlock($id, 'graduation', 'Abschluss:') }}
			{{ Form::docentBlock($id, 'lbv', 'LBV-Nummer:') }}


			{{ Form::docentBlock($id, 'email', 'E-Mail:') }}
			{{ Form::docentBlock($id, 'website', 'Webseite:') }}

			{{ Form::docentBlock($id, 'birth_day', 'Geburstdatum:') }}
			{{ Form::docentBlock($id, 'birth_place', 'Geburtsort:') }}

			{{ Form::docentBlock($id, 'bank_classic', 'Bankverbindung (Klassisch):') }}
			{{ Form::docentBlock($id, 'bank_modern', 'Bankverbindung (modern):') }}


			{{ Form::docentBlock($id, 'phone_number_private', 'Telefon (Privat)') }}
			{{ Form::docentBlock($id, 'phone_number_company', 'Telefon (Geschäftl.)') }}

			{{ Form::docentBlock($id, 'private_address', 'Privat-Adresse') }}
			{{ Form::docentBlock($id, 'company_address', 'Firmen-Adresse') }}


			{{ Form::docentBlock($id, 'company_job', 'Beruf:') }}

		</div><!-- /.row this actually does not appear to be needed with the form-horizontal -->
	  </div><!-- form -->
	  <p>Note: label text will occupy as much space as the text takes regardless of the
		  column size, so be sure to validate your spacing.
	  </p>
	</div><!-- /.container -->
</div>
</div>

	@endforeach


<div class="panel panel-default">
  <div class="panel-body">
		{{ Form::submit('Importieren', array('class' => 'btn btn-primary')) }}
  </div>
</div>
@else
<div class="panel panel-default" style="padding: 1em;">
	<p>In der übertragenen Datei konnten keine Dozenten gefunden werden</p>
</div>
@endif
{{ Form::close() }}

@stop