<?php

use \Elysium\Import\DocentParser;

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
				$parser	= DocentParser::fromFile($file->getRealPath());
				$docents	= $parser->docents();

				$posted	= (bool)(Input::old('posted') == 1);

				Form::macro('docentLabel', function($id, $property, $title) {
					return '<label for="docent['.$id.']['.$property.']" class="col-md-4 control-label">'.$title.'</label>';
				});


				$inputTemplate	= '<input class="form-control" placeholder="(leer)" name="%s" type="%s" value="%s">';
				$groupTemplate	= '
					<div class="col-sm-6 col-lg-6">
						<div class="form-group">
							<label for="%s" class="col-md-4 control-label">%s</label>
							<div class="col-md-8">
								%s
							</div>
						</div>
					</div>';
				Form::macro('docentBlock', function($id, $property, $title) use ($docents, $posted, $inputTemplate, $groupTemplate) {
					$data			= $docents[$id]->data($property);
					$elementKey		= sprintf('docent[%d][%s]', $id, $property);
					$element		= '';

					if (is_array($data)) {
						switch($property) {
							case 'bank_classic':
								$element	= '
									<label for="'.$elementKey.'[name]" class="control-label">Kreditinstitut:</label>
									<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[name]" type="text" value="'.(($posted) ? Input::old($elementKey.'[name]') : $data['name']).'">

									<label for="'.$elementKey.'[blz]" class="control-label" title="Bankleitzahl">BLZ:</label>
									<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[blz]" type="text" value="'.(($posted) ? Input::old($elementKey.'[blz]') : $data['blz']).'">

									<label for="'.$elementKey.'[number]" class="control-label">Kontonummer:</label>
									<input class="form-control" numberholder="(leer)" name="'.$elementKey.'[number]" type="text" value="'.(($posted) ? Input::old($elementKey.'[number]') : $data['number']).'">
									';
								break;
							case 'bank_modern':
								$element	= '
									<label for="'.$elementKey.'[iban]" class="control-label" title="International Bank Account Number">IBAN:</label>
									<input class="form-control" placeholder="(leer)" iban="'.$elementKey.'[iban]" type="text" value="'.(($posted) ? Input::old($elementKey.'[iban]') : $data['iban']).'">

									<label for="'.$elementKey.'[bic]" class="control-label" title="Bank Identifier Code">BIC:</label>
									<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[bic]" type="text" value="'.(($posted) ? Input::old($elementKey.'[bic]') : $data['bic']).'">
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
										(($posted) ? Input::old($elementSubKey) : $number)
								);

								}
								break;
							case 'private_address':
							case 'company_address':
								$element	= '
									<label for="'.$elementKey.'[street]" class="control-label">Straße, Hausnummer:</label>
									<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[street]" type="text" value="'.(($posted) ? Input::old($elementKey.'[street]') : $data['street']).'">

									<label for="'.$elementKey.'[plz]" class="control-label">PLZ:</label>
									<input class="form-control" placeholder="(leer)" name="'.$elementKey.'[plz]" type="text" value="'.(($posted) ? Input::old($elementKey.'[plz]') : $data['plz']).'">

									<label for="'.$elementKey.'[city]" class="control-label">Ort:</label>
									<input class="form-control" cityholder="(leer)" name="'.$elementKey.'[city]" type="text" value="'.(($posted) ? Input::old($elementKey.'[city]') : $data['city']).'">
									';

								break;
							case 'birth_day':
							default:
								foreach($data as $subKey => $value) {
									$elementSubKey	= $elementKey.'['.$subKey.']';
									$element		.= sprintf($inputTemplate, $elementSubKey, 'text', (($posted) ? Input::old($elementSubKey) : $value));
								}
								break;
						}

					} else {
						$type			= 'text';
						$elementValue	= ($posted) ? Input::old($elementKey) : $data;

						switch($property) {
							case 'email':
								$type	= 'email';
								break;
							case 'birth_day':
								$elementValue	= new DateTime($elementValue);
								$elementValue	= $elementValue->format('d.m.Y');
								break;
						}

						$element		= sprintf($inputTemplate, $elementKey, $type, $elementValue);
					}
						return sprintf($groupTemplate, $elementKey, $title, $element);
				});


				return View::make('docents.importprocess')->with('docents', $docents)->with('posted', $posted);

			} else {
				return View::make('docents.importprocess')->with('docents', array())->with('danger', 'Import Fehlgeschlagen');
			}
		}


        return View::make('docents.importprocess');
    }

}