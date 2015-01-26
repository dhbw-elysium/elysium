@extends('layouts.master')

@section('title')
@parent
:: Dozent ({{$docent->displayName()}})
@stop

@section('content')
<!-- Modal	edit assigned courses of docent -->
<div class="modal fade" id="modalDocentCourseList" tabindex="-1" nbrole="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Zugewiesene Vorlesungen verwalten</h4>
      </div>
	  {{ Form::open() }}
	  {{ Form::hidden('did', $docent->did)}}
      <div class="modal-body">
			<div class="form-group">
				<?php
				$courseIdList	= $docent->assignedCourseList();
				?>
				<label for="assignedCourse">Vorlesungen</label>
				<div>
					<select multiple class="docents-filter-dropdown filter-course" name="assignedCourse[]" id="assignedCourse">
						@if (count($groups	= CourseGroup::orderBy('title')->get()))
							@foreach ($groups as $group)
								@if (count($courses	= Course::where('cgid', '=', $group->cgid)->orderBy('title')->get()))
							  <optgroup label="{{{$group->title}}}">
									@foreach ($courses as $course)
									  <option value="{{$course->cid}}" {{(in_array($course->cid, $courseIdList) ? 'selected="selected"' : '')}}>{{{$course->title}}}</option>
									@endforeach
							  </optgroup>
								@endif
							@endforeach
						@endif
					</select>
				</div>
			</div>

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal	docent times -->
<div class="modal fade" id="modalDocentTime" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Bevorzugte Vorlesungszeiten</h4>
      </div>
	  {{ Form::open() }}
	  {{ Form::hidden('did', $docent->did)}}
      <div class="modal-body form-horizontal">
		<table class="table table-condensed table-bordered table-docent-time">
		<thead>
			<tr>
				<th></th>
				<th>Mo</th>
				<th>Di</th>
				<th>Mi</th>
				<th>Do</th>
				<th>Fr</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>Vormittags</th>
				<td>{{Form::checkbox('time_mo_am', 'true', (int)$docent->time_mo_am)}}</td>
				<td>{{Form::checkbox('time_tu_am', 'true', (int)$docent->time_tu_am)}}</td>
				<td>{{Form::checkbox('time_we_am', 'true', (int)$docent->time_we_am)}}</td>
				<td>{{Form::checkbox('time_th_am', 'true', (int)$docent->time_th_am)}}</td>
				<td>{{Form::checkbox('time_fr_am', 'true', (int)$docent->time_fr_am)}}</td>
			</tr>
			<tr>
				<th>Nachmittags</th>
				<td>{{Form::checkbox('time_mo_pm', 'true', (int)$docent->time_mo_pm)}}</td>
				<td>{{Form::checkbox('time_tu_pm', 'true', (int)$docent->time_tu_pm)}}</td>
				<td>{{Form::checkbox('time_we_pm', 'true', (int)$docent->time_we_pm)}}</td>
				<td>{{Form::checkbox('time_th_pm', 'true', (int)$docent->time_th_pm)}}</td>
				<td>{{Form::checkbox('time_fr_pm', 'true', (int)$docent->time_fr_pm)}}</td>
			</tr>
		</tbody>
		</table>

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal	docent property -->
<div class="modal fade" id="modalDocentData" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Eigenschaft bearbeiten</h4>
      </div>
	  {{ Form::open() }}
	  {{ Form::hidden('did', $docent->did)}}
      <div class="modal-body form-horizontal">

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal	docent phone number -->
<div class="modal fade" id="modalPhoneNumber" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Telefonnummern</h4>
      </div>
	  {{ Form::open() }}
	  {{ Form::hidden('did', $docent->did)}}
	  {{ Form::hidden('is_private', 0)}}
      <div class="modal-body">
		  <div class="form-number-elements">
			  <div class="row">
				  <div class="col-sm-12">
					  <div class="form-inline">
						<div class="form-group">
							<select class="form-control" name="type[]">
							  <option>Mobil</option>
							  <option>Festnetz</option>
							  <option>Fax</option>
							</select>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" name="number[]" placeholder="Telefonnummer">
						</div>

						 <div class="form-group button-remove-number">
							<button type="button" class="btn btn-remove">
							  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>
					  </div>
				  </div>
			  </div>
		  </div>
		  <div class="row">
			  <div class="col-sm-12">
				  <div class="button-add-number">
					<button type="button" class="btn btn btn-default btn-add">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</button>
				  </div>
			  </div>
		  </div>

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal	status entry delete -->
<div class="modal fade" id="modalDocentStatusDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Statuseintrag entfernen</h4>
      </div>
	  {{ Form::open() }}
	  {{ Form::hidden('did', $docent->did)}}
	  {{ Form::hidden('dsid', 0, array('id' => 'docentStatusDeleteDsid')); }}
      <div class="modal-body">
		Möchten Sie den gewählten Statuseintrag wirklich löschen?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Statuseintrag löschen', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal	docent status entry -->
<div class="modal fade" id="modalDocentStatus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Schließen</span></button>
        <h4 class="modal-title">Statusänderung eintragen</h4>
      </div>
	  {{ Form::open() }}
	  {{ Form::hidden('did', $docent->did)}}
	  {{ Form::hidden('dsid', 0, array('id' => 'docentUpdateDsid')); }}
      <div class="modal-body">
			<div class="form-group">
            	<label for="statusSid" class="control-label">Typ</label>
            	<select class="form-control" id="statusSid">
            		@if (count($statusList = Status::orderBy('title')->get()))
						@foreach ($statusList as $status)
							<option value="{{{$status->sid}}}" title="{{{$status->description}}}">{{{$status->title}}} - {{{$status->description}}}</option>
						@endforeach
					@endif
				</select>
          	</div>
			<div class="form-group">
				<label for="statusComment" class="control-label">Kommentar</label>
				<textarea class="form-control" id="statusComment" name="statusComment"></textarea>
			</div>

	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
		{{ Form::submit('Speichern', array('class' => 'btn btn-primary')) }}
      </div>
	  {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="row docent-detail">
	<div class="col-md-8">
		<h2>
			@if($docent->title)
			<small>{{{$docent->title}}}</small>
			@endif
			{{{$docent->first_name}}} {{{$docent->last_name}}}
		</h2>
		@if($docent->email)
			<p><a href="mailto:{{{$docent->email}}}">{{{$docent->email}}}</a></p>
		@endif
		@if($phoneNumberDefault = $docent->phonePrivateDefault())
		<p>{{{$phoneNumberDefault}}}</p>
		@endif
		<div role="tabpanel">
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#personaldata" aria-controls="personaldata" role="tab" data-toggle="tab">Personendaten</a></li>
			<li role="presentation"><a href="#company" aria-controls="company" role="tab" data-toggle="tab">Beruf</a></li>
			<li role="presentation"><a href="#qualification" aria-controls="qualification" role="tab" data-toggle="tab">Qualifikation</a></li>
			<li role="presentation"><a href="#extra" aria-controls="course" role="tab" data-toggle="tab">Weitere Informationen</a></li>
		  </ul>

		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="personaldata">
				<div class="container-fluid form">
					<div class="row">
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Titel</label>
								<div class="col-md-8">
									{{$docent->displayData('title')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="title">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Anrede</label>
								<div class="col-md-8">
									{{$docent->displayData('salution')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="salution">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Name</label>
								<div class="col-md-8">
									{{$docent->displayName()}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="name">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">E-Mail</label>
								<div class="col-md-8">
									{{$docent->displayData('email')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="email">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Telefon</label>
								<div class="col-md-8">
									<div>{{$docent->displayPhoneNumberList(true)}}</div>
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalPhoneNumber" data-did="{{{$docent->did}}}" data-private="1" data-toggle="tooltip" title="Telefonnummern bearbeiten">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Anschrift</label>
								<div class="col-md-8">
									<div>{{$docent->displayAddress(Address::TYPE_PRIVATE)}}</div>
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="address_private">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Webseite</label>
								<div class="col-md-8">
									{{$docent->displayData('website')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="website">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Geburtstag</label>
								<div class="col-md-8">
									{{$docent->displayData('birth_day')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="birth_day">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Geburtsort</label>
								<div class="col-md-8">
									{{$docent->displayData('birth_place')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="birth_place">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="company">
				<div class="container-fluid form">
					<div class="row">
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label" title="Firmen-Name">Firma</label>
								<div class="col-md-8">
									{{$docent->displayData('company_name')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="company_name">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Abteilung</label>
								<div class="col-md-8">
									{{$docent->displayData('company_department')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="company_department">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Beruf</label>
								<div class="col-md-8">
									{{$docent->displayData('company_job')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="company_job">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Anschrift</label>
								<div class="col-md-8">
									<div>{{$docent->displayAddress(Address::TYPE_COMPANY)}}</div>
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="address_company">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Telefon</label>
								<div class="col-md-8">
									<div>{{$docent->displayPhoneNumberList(false)}}</div>
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalPhoneNumber" data-did="{{{$docent->did}}}" data-private="0" data-toggle="tooltip" title="Telefonnummern bearbeiten">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="qualification">

				<div class="container-fluid form">
					<div class="row">
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Abschluss</label>
								<div class="col-md-8">
									{{$docent->displayData('graduation')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="graduation">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label" title="Ehemaliger DHBW Absolvent">Ehemalige(r)</label>
								<div class="col-md-8">
									{{$docent->displayData('is_exdhbw')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="is_exdhbw">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Lehraufträge und Lehrtätigkeiten</label>
								<div class="col-md-8">
									{{$docent->displayData('activity_teach')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="activity_teach">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Praktische Tätigkeiten</label>
								<div class="col-md-8">
									{{$docent->displayData('activity_practical')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="activity_practical">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label" title="Weitere mögliche Vorlesungsbereiche sowie bereits gehaltene Vorlesungen">Weitere mögl. Vorlesungsbereiche</label>
								<div class="col-md-8">
									{{$docent->displayData('course_extra')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="course_extra">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Anmerkungen, Ergänzungen</label>
								<div class="col-md-8">
									{{$docent->displayData('extra')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="extra">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>



					</div>
				</div>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="extra">
				<div class="container-fluid form">
					<div class="row">
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Bevorzugtes Studienfach</label>
								<div class="col-md-8">
									{{$docent->displayData('course_group_preferred')}}
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="course_group_preferred">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Bevorzugte Vorlesungszeiten</label>
								<div class="col-md-8">
									<div>
										<table class="table table-condensed table-bordered table-docent-time">
										<thead>
											<tr>
												<th></th>
												<th>Mo</th>
												<th>Di</th>
												<th>Mi</th>
												<th>Do</th>
												<th>Fr</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>Vormittags</th>
												<td>{{($docent->time_mo_am) ? 'x' : ''}}</td>
												<td>{{($docent->time_tu_am) ? 'x' : ''}}</td>
												<td>{{($docent->time_we_am) ? 'x' : ''}}</td>
												<td>{{($docent->time_th_am) ? 'x' : ''}}</td>
												<td>{{($docent->time_fr_am) ? 'x' : ''}}</td>
											</tr>
											<tr>
												<th>Nachmittags</th>
												<td>{{($docent->time_mo_pm) ? 'x' : ''}}</td>
												<td>{{($docent->time_tu_pm) ? 'x' : ''}}</td>
												<td>{{($docent->time_we_pm) ? 'x' : ''}}</td>
												<td>{{($docent->time_th_pm) ? 'x' : ''}}</td>
												<td>{{($docent->time_fr_pm) ? 'x' : ''}}</td>
											</tr>
										</tbody>
										</table>
									</div>
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentTime">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>

						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Kontodaten (klassisch)</label>
								<div class="col-md-8">
									<div>
										{{$docent->displayData('bank_name')}}<br>
										{{$docent->displayData('bank_blz')}} (BLZ)<br>
										{{$docent->displayData('bank_number')}} (Kontonummer)<br>
									</div>
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="bank_classic">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-12">
							<div class="form-group">
								<label class="col-md-4 control-label">Kontodaten (modern)</label>
								<div class="col-md-8">
									<div>
										{{$docent->displayData('bank_name')}}<br>
										{{$docent->displayData('bank_iban')}} (IBAN)<br>
										{{$docent->displayData('bank_bic')}} (BIC)<br>
									</div>
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentData" data-did="{{{$docent->did}}}" data-property="bank_modern">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
								</div>
							</div>
						</div>


					</div>
				</div>
			</div>
		  </div>

		</div>

	</div>
	<div class="col-md-4">
		<div id="docent-course-list">
			<h3>
				Vorlesungen
				<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalDocentCourseList">
				  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
				</button>
			</h3>
			<div>
				@if($courses = $docent->courses->toArray())
				@foreach($courses as $course)
					<span class="label label-primary">{{$course['title']}}</span>
				@endforeach
				@endif
			</div>
		</div>
		<h3>Verlauf</h3>

		<div class="docent-status-list">
			<div class="toolbar">
				<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalDocentStatus" data-dsid="0" data-sid="0" data-comment="">
				  <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Statusänderung eintragen
				</button>
			</div>

		@if($statusList = $docent->statusHistory())
			<div class="panel-group" aria-multiselectable="true">
			@foreach($statusList as $status)
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse{{{$status->dsid}}}" aria-expanded="true" aria-controls="collapse{{{$status->dsid}}}">
							<div class="status-title" title="{{{$status->description}}}">
								@if($status->glyph)
									<span class="glyphicon {{{$status->glyph}}}" aria-hidden="true"></span>
								@endif
								{{{$status->title}}}
							</div>
						  <div class="status-responsible" title="{{{$status->firstname}}} {{{$status->lastname}}}">{{{$status->lastname}}}</div>
						  @if ($created	= new \DateTime($status->created_at))
							<div class="status-date">{{{$created->format('d.m.Y H:i')}}}</div>
						  @endif
						  <div style="clear:both;float:none;"></div>
						</a>
					  </h4>
					</div>
					<div id="collapse{{{$status->dsid}}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
							{{{$status->comment}}}
							<div style="float:right;">
								<div class="btn-group btn-group-xs" role="group">
								<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalDocentStatus" data-dsid="{{$status->dsid}}" data-sid="{{$status->sid}}" data-comment="{{{$status->comment}}}">
								  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalDocentStatusDelete" data-dsid="{{$status->dsid}}">
								  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</div>
						  </div>
					  </div>
					</div>
				</div>
			@endforeach
 			</div>
		@endif
		</div>


</div>
@stop