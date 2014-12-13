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
{{ Form::hidden('valid', '1') }}


@if (count($docents))
	@foreach ($docents as $id => $docent)

<div class="panel panel-default panel-docent-import-docent import-docent-{{{$id}}}" style="padding: 1em;margin-top:1em;">
	<div class="container-fluid">
	  <div class="form-horizontal" role="form">

		<div class="row">
			<div class="form-group"  style="display:none;">
			  <div class="col-md-12">
			  	{{Form::checkbox('docent['.$id.'][exclude]', 'value', Input::old('docent['.$id.'][exclude]'), array('class' => 'import-docent-exclude', 'data-docent-id' => $id))}}
				<label for="docent[{{$id}}][exclude]" class="control-label"> Diesen Dozenten-Datensatz vom Import ausschließen</label>
		  	  </div>
	  		</div>

		@if ($duplicates = Docent::duplicateCandidates($docent->data('last_name'), $docent->data('first_name')))
		<div class="row">
		  <div class="col-md-12">
			<div class="alert alert-warning" role="alert">
			<strong>Duplikatswarnung</strong> Einer oder mehrere Dozenten mit ähnlichem Namen sind bereits im System erfasst:
			<ul>
			@foreach ($duplicates as $duplicate)
				<li>{{{$duplicate->last_name}}}, {{{$duplicate->first_name}}} ({{{$duplicate->company_job}}})</li>
			@endforeach
			</ul>
			</div>
			</div>
			</div>
		@endif

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
			{{ Form::docentBlock($id, 'company_name', 'Arbeitgeber:') }}

			{{ Form::docentBlock($id, 'company_department', 'Abteilung:') }}

			<div class="col-sm-6 col-lg-6">
				<div class="form-group">
					<label for="docent[{{$id}}][is_exdhbw]" class="col-md-4 control-label">Ehemaliger:</label>
					<div class="col-md-8">
						{{Form::checkbox('docent['.$id.'][is_exdhbw]', 'is_exdhbw', $docent->data('is_exdhbw'))}}
						<label for="docent[{{$id}}][is_exdhbw]" class="control-label" style="min-height: 34px;"> Ehemalige/r BA-/DHBW-Student/in</label>
					</div>
				</div>
			</div>

			{{ Form::docentTimeBlock($id) }}

			{{ Form::docentBlock($id, 'activity_teach', 'Lehraufträge und Lehrtätigkeiten:') }}
			{{ Form::docentBlock($id, 'activity_practical', 'Praktische Tätigkeiten:') }}

			{{ Form::docentBlock($id, 'extra', 'Anmerkungen, Ergänzungen:') }}
			{{ Form::docentBlock($id, 'course_extra', 'Weitere mögliche Vorlesungsbereiche sowie bereits gehaltene Vorlesungen:') }}

			{{ Form::docentBlock($id, 'imported_at', 'Eingangsdatum:', 'Datum des Eingangs der Bewerbung') }}



		</div><!-- /.row this actually does not appear to be needed with the form-horizontal -->
	  </div><!-- form -->
	</div><!-- /.container -->
</div>
</div>

	@endforeach


<div class="panel panel-default">
  <div class="panel-body">
	{{ Form::submit('Importieren', array('class' => 'btn btn-primary', 'name' => 'do-import')) }}
  </div>
</div>
@else
<div class="panel panel-default" style="padding: 1em;">
	<p>In der übertragenen Datei konnten keine Dozenten gefunden werden</p>
</div>
@endif
{{ Form::close() }}

@stop