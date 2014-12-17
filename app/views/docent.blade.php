@extends('layouts.master')

@section('title')
@parent
:: Dozent
@stop

@section('content')
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
			<li role="presentation" class="active"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">Kontaktdaten</a></li>
			<li role="presentation"><a href="#company" aria-controls="company" role="tab" data-toggle="tab">Arbeitgeber</a></li>
			<li role="presentation"><a href="#qualification" aria-controls="qualification" role="tab" data-toggle="tab">Qualifikationen</a></li>
		  </ul>

		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="contact">
				<div class="container-fluid form">
					<div class="row">
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-6 control-label">Titel:</label>
								<div class="col-md-6">{{$docent->title}}<i style="color:gray;">(leer)</i></div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-6 control-label">Name:</label>
								<div class="col-md-6">{{$docent->first_name}}</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-6 control-label">E-Mail Adresse:</label>
								<div class="col-md-6">{{$docent->email}}</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-6 control-label">Telefon:</label>
								<div class="col-md-6">
								@foreach($docent->phoneNumbers as $phoneNumber)
								@if($phoneNumber->is_private)
									<div>{{$phoneNumber->type}} {{$phoneNumber->number}}</div>
									@endif
								@endforeach
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-lg-6">
							<div class="form-group">
								<label class="col-md-6 control-label">Anschrift:</label>
								<div class="col-md-6">Musterstr. 5<br>70562 Stuttgart</div>
							</div>
						</div>

					</div>
				</div>

			</div>
			<div role="tabpanel" class="tab-pane fade" id="company">

			</div>
			<div role="tabpanel" class="tab-pane fade" id="qualification">

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