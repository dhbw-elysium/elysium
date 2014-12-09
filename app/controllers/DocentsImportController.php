<?php

use \Elysium\Import\DocentParser;
use \Elysium\DocentData\TeachTimeSet;

class DocentsImportController extends BaseController {

    public function docentsImportUpload()
    {
        return View::make('docents.import');
    }

    public function docentsImportProcess()
    {

		if (Input::hasFile('file')) {
			/** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
			$file = Input::file('file');

			if ($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
				$parser = DocentParser::fromExcel($file->getRealPath());
				$docents = $parser->docents();
			}

			Form::macro('docentLabel', function ($id, $property, $title) {
				return '<label for="docent[' . $id . '][' . $property . ']" class="col-md-4 control-label">' . $title . '</label>';
			});
		} else {
			$parser		= DocentParser::fromInput(Input::get('docent'));
			$docents	= $parser->docents();
		}

		if (isset($docents) && is_array($docents)) {
			$inputTemplate	= '<input class="form-control" placeholder="(leer)" name="%s" type="%s" value="%s">';
			$groupTemplate	= '
				<div class="%s">
					<div class="form-group">
						<label for="%s" class="col-md-4 control-label"%s>%s</label>
						<div class="col-md-8">
							%s
						</div>
					</div>
				</div>';
			Form::macro('docentBlock', function($id, $property, $title, $tooltip = null) use ($docents, $inputTemplate, $groupTemplate) {

				$data			= $docents[$id]->data($property);
				$elementKey		= sprintf('docent[%d][%s]', $id, $property);
				$element		= '';
				$groupClass		= array('col-sm-6', 'col-lg-6');

				if (is_array($data)) {
					switch($property) {
						case 'bank_classic':
							$groupClass[]	= 'form-group-elements-3';
							$element		= '
								<label for="'.$elementKey.'[name]" class="control-label">Kreditinstitut:</label>
								<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[name]" type="text" value="'.$data['name'].'">

								<label for="'.$elementKey.'[blz]" class="control-label" title="Bankleitzahl">BLZ:</label>
								<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[blz]" type="text" value="'.$data['blz'].'">

								<label for="'.$elementKey.'[number]" class="control-label">Kontonummer:</label>
								<input class="form-control" numberholder="(leer)" name="'.$elementKey.'[number]" type="text" value="'.$data['number'].'">
								';
							break;
						case 'bank_modern':
							$groupClass[]	= 'form-group-elements-3';
								$element	= '
								<label for="'.$elementKey.'[iban]" class="control-label" title="International Bank Account Number">IBAN:</label>
								<input class="form-control" placeholder="(leer)" iban="'.$elementKey.'[iban]" type="text" value="'.((isset($data['iban'])) ? $data['iban'] : '').'">

								<label for="'.$elementKey.'[bic]" class="control-label" title="Bank Identifier Code">BIC:</label>
								<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[bic]" type="text" value="'.((isset($data['bic'])) ? $data['bic'] : '').'">
								';
							break;

						case 'phone_number_company':
						case 'phone_number_private':
							$element	= '';

							$elementTemplate	= '<label for="%s" class="control-label">%s:</label>
									<input class="form-control" placeholder="(leer)" name="%s" type="text" value="%s">';

							foreach($data as $type => $number) {
								$elementSubKey	= $elementKey.'['.$type.']';

								switch($type) {
									case 'phone':
										$typeTitle	= 'Festnetz';
										break;
									case 'mobile':
										$typeTitle	= 'Mobil';
										break;
									case 'fax':
										$typeTitle	= 'Fax';
										break;
									default:
										throw new InvalidArgumentException('Unknown phone number type "'.$type.'" transmitted');
								}

								$element	.= sprintf(
									$elementTemplate,
									$elementSubKey,
									$typeTitle,
									$elementSubKey,
									$number
							);

							}
							break;
						case 'private_address':
						case 'company_address':
							$element	= '
								<label for="'.$elementKey.'[street]" class="control-label">Straße, Hausnummer:</label>
								<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[street]" type="text" value="'.$data['street'].'">

								<label for="'.$elementKey.'[plz]" class="control-label">PLZ:</label>
								<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[plz]" type="text" value="'.$data['plz'].'">

								<label for="'.$elementKey.'[city]" class="control-label">Ort:</label>
								<input class="form-control" cityholder="(leer)" name="'.$elementKey.'[city]" type="text" value="'.$data['city'].'">
								';

							break;
						default:
							foreach($data as $subKey => $value) {
								$elementSubKey	= $elementKey.'['.$subKey.']';
								$element		.= sprintf($inputTemplate, $elementSubKey, 'text', $value);
							}
							break;
					}

				} else {
					$type			= 'text';
					$elementValue	= $data;

					switch($property) {
						case 'activity_practical':
						case 'activity_teach':
						case 'extra':
						case 'course_extra':
							$type	= 'textarea';
							break;
						case 'email':
							$type	= 'email';
							break;
						case 'imported_at':
						case 'birth_day':
							$elementValue	= new DateTime($elementValue);
							$elementValue	= $elementValue->format('d.m.Y');
							break;
					}

					switch ($type) {
						case 'textarea':
							$element	= sprintf(
								'<textarea class="form-control" placeholder="(leer)" name="%s">%s</textarea>',
								$elementKey,
								$elementValue
							);
							break;
						default:
							$element	= sprintf($inputTemplate, $elementKey, $type, $elementValue);
							break;
					}
				}
				$labelAttribute	= '';
				if ($tooltip) {
					$labelAttribute	= ' title="'.$tooltip.'"';
				}

				return sprintf($groupTemplate, implode(' ', $groupClass), $elementKey, $labelAttribute, $title, $element);
			});

			Form::macro('docentTimeBlock', function($id) use ($docents, $groupTemplate) {
				/** @var TeachTimeSet $times */
				$timeSet 	= $docents[$id]->data('time');
				$elementKey = sprintf('docent[%d][time]', $id);

				$timeCells	= array();
				foreach($timeSet->times() as $timeCode => $state) {
					$timeTitle		= TeachTimeSet::timeTitleByCode($timeCode);
					$elementSubKey	= $elementKey.'['.$timeCode.']';

					$timeCells[$timeCode]	= Form::checkbox($elementSubKey, $timeCode, $state, array('title' => $timeTitle)).' <label for="'.$elementSubKey.'" class="sr-only">'.$timeTitle.'</label>';
				}

				$elementTemplate	= '
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
								<td>%s</td>
								<td>%s</td>
								<td>%s</td>
								<td>%s</td>
								<td>%s</td>
							</tr>
							<tr>
								<th>Nachmittags</th>
								<td>%s</td>
								<td>%s</td>
								<td>%s</td>
								<td>%s</td>
								<td>%s</td>
							</tr>

						</tbody>
					</table>';

				$element	= sprintf(
					$elementTemplate,
					$timeCells['time_mo_am'],
					$timeCells['time_tu_am'],
					$timeCells['time_we_am'],
					$timeCells['time_th_am'],
					$timeCells['time_fr_am'],
					$timeCells['time_mo_pm'],
					$timeCells['time_tu_pm'],
					$timeCells['time_we_pm'],
					$timeCells['time_th_pm'],
					$timeCells['time_fr_pm']
				);

				return sprintf(
					$groupTemplate,
					implode(' ', array('col-sm-6', 'col-lg-6')),
					$elementKey,
					'',
					'Vorlesungszeiten:',
					$element
				);
			});


			return View::make('docents.importprocess')->with('docents', $docents);

		} else {
			return View::make('docents.importprocess')->with('docents', array())->with('danger', 'Import Fehlgeschlagen');
		}



        return View::make('docents.importprocess');
    }

}