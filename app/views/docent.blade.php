@extends('layouts.master')

@section('title')
@parent
:: Dozent ({{$docent->displayName()}})
@stop

@section('content')

<!-- Modal	course -->
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
		  <div class="row">
			  <div class="col-sm-12">
				  <div class="form-inline">
					<div class="form-group">
						<select class="form-control">
						  <option>Mobil</option>
						  <option>Festnetz</option>
						  <option>Fax</option>
						</select>
					</div>

					 <div class="form-group">
						<input type="text" class="form-control" id="phoneNumberNumber" placeholder="Telefonnummer">
					</div>

					 <div class="form-group button-remove-number">
						<button type="button" class="btn btn-danger">
						  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
						</button>
					</div>
				  </div>
			  </div>
		  </div>
		  <div class="row">
			  <div class="col-sm-12">
				  <div class="button-add-number">
					<button type="button" class="btn btn-success">
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
			<li role="presentation"><a href="#course" aria-controls="course" role="tab" data-toggle="tab">Vorlesungsinformationen</a></li>
		  </ul>

		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="personaldata">
				<div class="container-fluid form">
					<div class="row">
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-5 control-label">Titel:</label>
								<div class="col-md-7">{{$docent->displayData('title')}}</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-5 control-label">Anrede:</label>
								<div class="col-md-7">{{$docent->displayData('salution')}}</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-5 control-label">Name:</label>
								<div class="col-md-7">
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalPhoneNumber" data-private="true">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
									{{$docent->displayName()}}
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-5 control-label">E-Mail Adresse:</label>
								<div class="col-md-7">{{$docent->displayData('email')}}</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-5 control-label">Telefon:</label>
								<div class="col-md-7">
									<button type="button" class="btn btn-default btn-xs btn-edit-inline" data-toggle="modal" data-target="#modalPhoneNumber" data-private="true">
									  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
									{{$docent->displayPhoneNumberList()}}

								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-5 control-label">Anschrift:</label>
								<div class="col-md-7">{{$docent->displayAddress(Address::TYPE_PRIVATE)}}</div>
							</div>
						</div>

					</div>
				</div>

			</div>
			<div role="tabpanel" class="tab-pane fade" id="company">

			</div>
			<div role="tabpanel" class="tab-pane fade" id="qualification">

			</div>
			<div role="tabpanel" class="tab-pane fade" id="course">

			</div>
		  </div>

		</div>

	</div>
	<div class="col-md-4">
		<h3>Vorlesungen</h3>
			<div>
				@if($courses = $docent->courses->toArray())
				@foreach($courses as $course)
					<span class="label label-primary">{{$course['title']}}</span>
				@endforeach
				@endif
			</div>
		<h3>Verlauf</h3>

		<button type="button" class="btn btn-default btn-sm">
		  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Aktion eintragen
		</button>

		<div class="panel-group" aria-multiselectable="true">
		  <div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingOne">
			  <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
				  Collapsible Group Item #1
				</a>
			  </h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			  <div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
			  </div>
			</div>
		  </div>
		  <div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingTwo">
			  <h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				  Collapsible Group Item #2
				</a>
			  </h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			  <div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
			  </div>
			</div>
		  </div>
		  <div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingThree">
			  <h4 class="panel-title">
				<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				  Collapsible Group Item #3
				</a>
			  </h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
			  <div class="panel-body">
				Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
			  </div>
			</div>
		  </div>
		</div>

	</div>
</div>
@stop