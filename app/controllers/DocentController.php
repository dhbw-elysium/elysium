<?php
class DocentController extends BaseController {

    public function showDocent($did) {

        try {
    		$docent	= Docent::findOrFail($did);
        } catch(Exception $e) {
            return View::make('docent-error')->with('danger', 'Dozent nicht gefunden');
        }

        return View::make('docent')->with('docent', $docent);
    }

    public function docentExport($did) {
        $docent     = Docent::findOrFail($did);
        $phpWord    = new \PhpOffice\PhpWord\PhpWord();

        $formatHeader   = array('name' => 'Tahoma', 'size' => 16, 'bold' => true);
        $formatLabel    = array('name' => 'Tahoma', 'size' => 10, 'bold' => true);
        $formatValue    = array('name' => 'Tahoma', 'size' => 10, 'bold' => false);
        $paragraph      = array('pageBreakBefore' => false, 'keepNext' => true, 'space' => array('after' => 125));

        $phpWord->addParagraphStyle('pStyle', $paragraph);
        $phpWord->addFontStyle('formatLabel', $formatLabel);
        $phpWord->addFontStyle('formatValue', $formatValue);

        $section    = $phpWord->addSection();
        $subsequent = $section->addHeader();
        $subsequent->addText(
            htmlspecialchars(
                'Elysium - Dozentenverwaltung - Dozent: '.$docent->displayData('first_name', true).' '.$docent->displayData('last_name', true)
            ),
            array('name' => 'Tahoma', 'size' => 10)
        );

        $footer = $section->addFooter();
        $footer->addPreserveText(htmlspecialchars('Seite {PAGE} von {NUMPAGES}'), array('align' => 'center'));

        $section->addText(htmlspecialchars($docent->salution.' '.$docent->title.' '.$docent->first_name.' '.$docent->last_name), $formatHeader);
        $section->addText("\n", $formatValue);

        $section = $phpWord->addSection(
            array(
                'colsNum'   => 2,
                'colsSpace' => 600,
                'breakType' => 'continuous',
            )
        );

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Titel:\n", $formatLabel);
        $textrun->addText($docent->displayData('title', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Anrede:\n", $formatLabel);
        $textrun->addText($docent->displayData('salution', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Titel:\n", $formatLabel);
        $textrun->addText($docent->displayData('title', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Anrede:\n", $formatLabel);
        $textrun->addText($docent->displayData('salution', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Vorname:\n", $formatLabel);
        $textrun->addText($docent->displayData('first_name', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Nachname:\n", $formatLabel);
        $textrun->addText($docent->displayData('last_name', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("E-Mail:\n", $formatLabel);
        $textrun->addText($docent->displayData('email', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Website:\n", $formatLabel);
        $textrun->addText($docent->displayData('website', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Anschrift:\n", $formatLabel);
        $textrun->addText($docent->displayData('xxx', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Telefon:\n", $formatLabel);
        $textrun->addText($docent->displayData('xxx', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Geburstag (Geburtsort):\n", $formatLabel);
        $textrun->addText($docent->displayData('birth_day', true).' ('.$docent->displayData('birth_place', true).')', $formatValue);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Firma:\n", $formatLabel);
        $textrun->addText($docent->displayData('company_name', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Abteilung:\n", $formatLabel);
        $textrun->addText($docent->displayData('company_department', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Beruf:\n", $formatLabel);
        $textrun->addText($docent->displayData('company_job', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Anschrift:\n", $formatLabel);
        $textrun->addText($docent->displayData('xxx', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Telefon:\n", $formatLabel);
        $textrun->addText($docent->displayData('xxx', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Abschluss:\n", $formatLabel);
        $textrun->addText($docent->displayData('graduation', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Ehemaliger DHBW Student:\n", $formatLabel);
        $textrun->addText($docent->displayData('is_exdhbw', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Lehraufträge und Lehrtätigkeiten:\n", $formatLabel);
        $textrun->addText($docent->displayData('activity_teach', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Praktische Tätigkeiten:\n", $formatLabel);
        $textrun->addText($docent->displayData('activity_practical', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Weitere mögliche Vorlesungsbereiche sowie bereits gehaltene Vorlesungen:\n", $formatLabel);
        $textrun->addText($docent->displayData('course_extra', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Anmerkungen, Ergänzungen:\n", $formatLabel);
        $textrun->addText($docent->displayData('extra', true), $formatValue, $paragraph);


        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Bevorzugtes Studienfach:\n", $formatLabel);
        $textrun->addText($docent->displayData('course_group_preferred', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Bevorzugte Vorlesungszeiten:\n", $formatLabel);
        $textrun->addText($docent->displayData('xxx', true), $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Kontodaten (klassisch):\n", $formatLabel);
        $textrun->addText('Name des Kreditinstituts: '.$docent->displayData('bank_name', true)."\n", $formatValue, $paragraph);
        $textrun->addText('BLZ: '.$docent->displayData('bank_blz', true)."\n", $formatValue, $paragraph);
        $textrun->addText('Kontonummer: '.$docent->displayData('bank_number', true)."\n", $formatValue, $paragraph);

        $textrun = $section->addTextRun('pStyle');
        $textrun->addText("Kontodaten (modern):\n", $formatLabel);
        $textrun->addText('Name des Kreditinstituts: '.$docent->displayData('bank_name', true)."\n", $formatValue, $paragraph);
        $textrun->addText('IBAN: '.$docent->displayData('bank_iban', true)."\n", $formatValue, $paragraph);
        $textrun->addText('BIC: '.$docent->displayData('bank_bic', true)."\n", $formatValue, $paragraph);





        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('/tmp/doc3.docx');

    }

    /**
     * Get json data which describes a form to edit a docents property
     *
     * @param   integer     $did        Docent id
     * @param   string      $targetElement    Form property
     * @return mixed
     */
    public function docentDataForm($did, $targetElement) {
        $form   = array('elements' => array());

        $docent = Docent::find($did);

        $textareaElements   = array('activity_teach', 'activity_practical', 'course_extra', 'extra');
        $textElements       = array('title', 'salution', 'birth_place', 'website', 'email', 'company_name',
            'company_department', 'company_job', 'graduation', 'course_group_preferred');

        if (in_array($targetElement, $textElements )) {
            $property   = $targetElement;
            $tooltip    = '';
            $type       = 'text';

            switch($targetElement) {
                case 'title':
                    $label      = 'Titel';
                    $tooltip    = 'Akademischer Titel';
                    break;
                case 'salution':
                    $label      = 'Anrede';
                    break;
                case 'graduation':
                    $label      = 'Abschluss';
                    $tooltip    = 'Akademischer Abschluss';
                    break;
                case 'birth_place':
                    $label      = 'Geburtsort';
                    break;
                case 'website':
                    $label      = 'Website';
                    break;
                case 'email':
                    $label      = 'E-Mail';
                    $tooltip    = 'E-Mail Adresse';
                    break;
                case 'company_name':
                    $label      = 'Firmen-Name';
                    break;
                case 'company_department':
                    $label      = 'Abteilung';
                    $tooltip    = 'Firmen-Abteilung';
                    break;
                case 'course_group_preferred':
                    $label      = 'Themenbereich';
                    $tooltip    = 'Bevorzugtes Studienfach (Themenbereich)';
                    break;
                case 'company_job':
                    $label      = 'Beruf';
                    break;
            }

            $formElement    = array(
                'name'      => $targetElement,
                'label'     => $label,
                'tooltip'   => $tooltip,
                'type'      => $type,
                'value'     => e($docent->$property)
            );

            $form['elements'][] = $formElement;
        } elseif (in_array($targetElement, $textareaElements )) {
            $property   = $targetElement;
            $tooltip    = '';
            $type       = 'textarea';

            switch($targetElement) {
                case 'activity_teach':
                    $label      = 'Lehrtätigkeiten';
                    $tooltip    = 'Lehraufträge und Lehrtätigkeiten';
                    break;
                case 'activity_practical':
                    $label      = 'Praktisches';
                    $tooltip    = 'Praktische Tätigkeiten';
                    break;
                case 'course_extra':
                    $label      = 'Weitere Vorlesungsbereiche';
                    $tooltip    = 'Weitere mögliche Vorlesungsbereiche sowie bereits gehaltene Vorlesungen';
                    break;
                case 'extra':
                    $label      = 'Anmerkungen';
                    $tooltip    = 'Anmerkungen, Ergänzungen';
                    break;
            }

            $formElement    = array(
                'name'      => $targetElement,
                'label'     => $label,
                'tooltip'   => $tooltip,
                'type'      => $type,
                'value'     => e($docent->$property)
            );

            $form['elements'][] = $formElement;

        } else {
            switch($targetElement) {
                case 'is_exdhbw':
                    $formElement    = array(
                        'name'      => 'is_exdhbw',
                        'label'     => 'Ehemalige(r)',
                        'tooltip'   => 'Ehemaliger DHBW Absolvent',
                        'type'      => 'boolean',
                        'value'     => (int)$docent->is_exdhbw
                    );
                    $form['elements'][] = $formElement;
                    break;
                case 'bank_classic':
                    $formElement    = array(
                        'name'      => 'bank_name',
                        'label'     => 'Kreditinstitut',
                        'tooltip'   => 'Name des Kreditinstituts',
                        'type'      => 'text',
                        'value'     => e($docent->bank_name)
                    );
                    $form['elements'][] = $formElement;

                    $formElement    = array(
                        'name'      => 'bank_blz',
                        'label'     => 'BLZ',
                        'tooltip'   => 'Bankleitzahl',
                        'type'      => 'text',
                        'value'     => e($docent->bank_blz)
                    );
                    $form['elements'][] = $formElement;

                    $formElement    = array(
                        'name'      => 'bank_number',
                        'label'     => 'Kontonummer',
                        'tooltip'   => 'Kontonummer',
                        'type'      => 'text',
                        'value'     => e($docent->bank_number)
                    );
                    $form['elements'][] = $formElement;
                    break;
                case 'bank_modern':
                    $formElement    = array(
                        'name'      => 'bank_name',
                        'label'     => 'Kreditinstitut',
                        'tooltip'   => 'Name des Kreditinstituts',
                        'type'      => 'text',
                        'value'     => e($docent->bank_name)
                    );
                    $form['elements'][] = $formElement;

                    $formElement    = array(
                        'name'      => 'bank_iban',
                        'label'     => 'IBAN',
                        'tooltip'   => 'Internationale Bankkontonummer',
                        'type'      => 'text',
                        'value'     => e($docent->bank_iban)
                    );
                    $form['elements'][] = $formElement;

                    $formElement    = array(
                        'name'      => 'bank_bic',
                        'label'     => 'BIC',
                        'tooltip'   => 'Geschäftskennzeichen',
                        'type'      => 'text',
                        'value'     => e($docent->bank_bic)
                    );
                    $form['elements'][] = $formElement;
                    break;
                case 'birth_day':
                    $birthDate  = new \DateTime($docent->birth_day);

                    $formElement    = array(
                        'name'      => 'birth_day',
                        'label'     => 'Geburstdatum',
                        'tooltip'   => '',
                        'type'      => 'date',
                        'value'     => $birthDate->format('d.m.Y')
                    );
                    $form['elements'][] = $formElement;
                    break;
                case 'address_private':
                case 'address_company':
                    if ($targetElement == 'address_private') {
                        $address = $docent->privateAddress();
                    } else {
                        $address = $docent->companyAddress();
                    }

                    $addressData    = array(
                        'street' => '',
                        'city' => '',
                        'plz' => ''
                    );
                    if ($address) {
                        $addressData    = array(
                            'street'    => e($address->street),
                            'city'      => e($address->city),
                            'plz'       => e($address->plz),
                        );
                    }

                    $formElement    = array(
                        'name'      => 'address_street',
                        'label'     => 'Straße',
                        'tooltip'   => 'Straße und Hausnummer',
                        'type'      => 'text',
                        'value'     => $addressData['street']
                    );
                    $form['elements'][] = $formElement;

                    $formElement    = array(
                        'name'      => 'address_city',
                        'label'     => 'Ort',
                        'tooltip'   => '',
                        'type'      => 'text',
                        'value'     => $addressData['city']
                    );
                    $form['elements'][] = $formElement;


                    $formElement    = array(
                        'name'      => 'address_plz',
                        'label'     => 'PLZ',
                        'tooltip'   => 'Postleitzahl',
                        'type'      => 'text',
                        'value'     => $addressData['plz']
                    );
                    $form['elements'][] = $formElement;
                    break;
                case 'name':
                    $formElement    = array(
                        'name'      => 'first_name',
                        'label'     => 'Vorname',
                        'tooltip'   => '',
                        'type'      => 'text',
                        'value'     => e($docent->first_name)
                    );
                    $form['elements'][] = $formElement;

                    $formElement    = array(
                        'name'      => 'last_name',
                        'label'     => 'Nachname',
                        'tooltip'   => '',
                        'type'      => 'text',
                        'value'     => e($docent->last_name)
                    );
                    $form['elements'][] = $formElement;

                    break;
            }
        }






        return Response::json($form);
    }

    /**
     * Delete a docent
     */
    public function docentDelete() {
        $did    = Input::get('did');
        $docent = Docent::find($did);

        $docent->delete();

        return Response::make('', 200);
    }

    /**
     * Updated assigned courses of a docent
     */
    public function docentDataUpdateCourseList() {
        $docent = Docent::findOrFail(Input::get('did'));

        $currentList    = $docent->assignedCourseList();
        $targetList     = Input::get('assignedCourse', array());
        sort($currentList);
        sort($targetList);

        $courseRemove   = array_diff($currentList, $targetList);
        $courseAdd      = array_diff($targetList, $currentList);

        foreach($courseRemove as $cid) {
            $docent->removeCourseAssignment($cid);
        }

        foreach($courseAdd as $cid) {
            $docent->addCourseAssignment($cid);
        }

        return Response::make('', 200);
    }

    /**
     * Update a docents property
     *
     * @param   integer     $did                Docent id
     * @param   string      $targetElement      Form property
     * @return mixed                            A http code
     */
    public function docentDataUpdate($did, $targetElement) {
        $form   = array('elements' => array());

        $docent = Docent::find($did);

        $textElements   = array(
            'title', 'salution', 'birth_place', 'website', 'email', 'company_name', 'company_department', 'company_job',
            'activity_teach', 'activity_practical', 'course_extra', 'extra', 'graduation', 'course_group_preferred'
        );

        if (in_array($targetElement, $textElements )) {
            $property   = $targetElement;
            $tooltip    = '';
            $type       = 'text';

            switch($targetElement) {
                case 'title':
                case 'salution':
                case 'graduation':
                case 'birth_place':
                case 'website':
                case 'email':
                case 'company_name':
                case 'company_department':
                case 'company_job':
                case 'activity_teach':
                case 'activity_practical':
                case 'course_extra':
                case 'course_group_preferred':
                case 'extra':
                case 'bank_blz':
                case 'bank_number':
                case 'bank_iban':
                case 'bank_bic':
                    $docent->$targetElement = Input::get($targetElement);
            }

            $docent->save();

        } else {
            switch($targetElement) {
                case 'is_exdhbw':
                    $docent->is_exdhbw  = Input::get('is_exdhbw');
                    $docent->save();
                    break;
                case 'bank_classic':
                    $docent->bank_name      = Input::get('bank_name');
                    $docent->bank_blz       = Input::get('bank_blz');
                    $docent->bank_number    = Input::get('bank_number');
                    $docent->save();
                    break;
                case 'bank_modern':
                    $docent->bank_name      = Input::get('bank_name');
                    $docent->bank_iban      = Input::get('bank_iban');
                    $docent->bank_bic       = Input::get('bank_bic');
                    $docent->save();
                    break;
                case 'birth_day':
                    if (preg_match('/(\d{2}).(\d{2}).(\d{4})/', Input::get('birth_day'), $birthDay)) {
                        $docent->birth_day  = new \DateTime(sprintf('%d-%d-%d', $birthDay[3], $birthDay[2], $birthDay[1]));
                        $docent->save();
                    } else {
    		            return Response::make('', 405);
                    }
                    break;
                case 'address_private':
                case 'address_company':
                    if ($targetElement == 'address_private') {
                        $address = $docent->privateAddress();
                    } else {
                        $address = $docent->companyAddress();
                    }

                    if (!$address) {
                        $address    = new Address();
                        $address->save();

                        if ($targetElement == 'address_private') {
                            $docent->private_aid    = $address->aid;
                        } else {
                            $docent->company_aid    = $address->aid;
                        }
                        $docent->save();
                    }

                    $address->street    = Input::get('address_street');
                    $address->city      = Input::get('address_city');
                    $address->plz       = Input::get('address_plz');
                    $address->save();
                    break;
                case 'name':
                    $docent->first_name = Input::get('first_name');
                    $docent->last_name  = Input::get('last_name');
                    $docent->save();
                    break;
            }
        }

        return Response::make('', 200);
    }


    /**
     * Update teach time data of docent
     *
     * @return Response
     */
    public function docentDataUpdateTeachTime($did) {
        if ($did = (int)Input::get('did')) {

            $docent = Docent::find($did);

            $docent->time_mo_am = Input::has('time_mo_am');
            $docent->time_tu_am = Input::has('time_tu_am');
            $docent->time_we_am = Input::has('time_we_am');
            $docent->time_th_am = Input::has('time_th_am');
            $docent->time_fr_am = Input::has('time_fr_am');

            $docent->time_mo_pm = Input::has('time_mo_pm');
            $docent->time_tu_pm = Input::has('time_tu_pm');
            $docent->time_we_pm = Input::has('time_we_pm');
            $docent->time_th_pm = Input::has('time_th_pm');
            $docent->time_fr_pm = Input::has('time_fr_pm');

            $docent->save();

            return Response::make('', 200);
        }

        return Response::make('', 405);
    }


    /**
     * Track a status change of a docent
     */
    public function updateStatusEntry() {
        if (Input::has('dsid') && Input::get('dsid') != 0) {
            $status = DocentStatus::find(Input::get('dsid'));

            if (!$status) {
                return Response::make('', 406);
            }
        } else {
            $status = new DocentStatus;
        }

        $status->did        = (int)Input::get('did');
        $status->sid        = (int)Input::get('sid');
        $status->comment    = Input::get('comment');

        try {
            $status->save();
        } catch(Illuminate\Database\QueryException $e) {
            return Response::make('', 405);
        }
        return Response::make('', 200);
    }


    /**
     * Delete a docents status entry
     *
     * @param   int     $did        Affected docent
     */
    public function docentDataDeleteStatus($did) {
        $docent = Docent::find($did);

        if ($docent) {
            $dsid   = (int)Input::get('dsid');

            $status = DocentStatus::find($dsid);

            if ($status) {
                $status->delete();

                return Response::make('', 200);
            }
        }

        return Response::make('', 403);
    }

    /**
     * Get a json list of docents phone numbers
     *
     * @param   integer     $did        Docent id
     * @param   string      $group      filter "all" phone numbers, "private" or "company" numbers only
     * @return  mixed
     */
    public function docentPhoneList($did, $group = 'all') {
		$docent	= Docent::find($did);

        switch($group) {
            case 'all':
                $private    = null;
                break;
            case 'private':
                $private    = true;
                break;
            case 'company':
                $private    = false;
                break;
            default:
                throw new \InvalidArgumentException('Transmitted group type is unknown');
                break;
        }

        $phoneNumberListDetailed    = $docent->phoneNumbers;
        $phoneNumberList            = array();

        foreach ($phoneNumberListDetailed as $phoneNumber) {

            if ($private !== null && $private != $phoneNumber['is_private']) {
                continue;
            }

            $phoneNumberList[]  = array(
                'pid'       => $phoneNumber['pid'],
                'type'      => $phoneNumber['type'],
                'number'    => $phoneNumber['number']
            );
        }


        return Response::json($phoneNumberList);
    }

    /**
     * Update the phone numbers of a docent
     *
     * @return  mixed
     */
    public function postDocentPhoneUpdate() {
        $data   = Input::all();

        $isPrivate          = (bool)Input::get('is_private');
        $did                = (int)Input::get('did');
        $docent             = Docent::findOrFail($did); //check validity of did
        $numberListUpdate   = array();
        $numberListDelete   = array();

        foreach($data as $property => $value) {
            switch($property) {
                case 'delete':
                    foreach($value as $index => $pid) {
                        $numberListDelete[] = $pid;
                    }
                    break;
                case 'pid':
                    foreach($value as $index => $pid) {
                        $numberListUpdate[$index]['pid'] = $pid;
                    }
                    break;
                case 'type':
                    foreach($value as $index => $type) {
                        $numberListUpdate[$index]['type'] = $type;
                    }
                    break;
                case 'number':
                    foreach($value as $index => $number) {
                        $numberListUpdate[$index]['number'] = trim($number);
                    }
                    break;
            } //switch
        } //foreach

        if (count($numberListDelete)) {
            PhoneNumber::destroy($numberListDelete);
        }

        foreach($numberListUpdate as $numberData) {
            if (!$numberData['number']) {
                continue;
            }

            if ($numberData['pid']) {
                $number = PhoneNumber::findOrFail($numberData['pid']);

                if ($number->did && $number->did != $did) {
            		return Response::make('Given number is not part of current docent', 500);
                }
            } else {


                $number             = new PhoneNumber;
                $number->did        = $did;
                $number->is_private = $isPrivate;
            }
            $number->number     = $numberData['number'];
            $number->type       = $numberData['type'];

            $number->save();
        }

        if ($isPrivate === null && $did === null) {
    		return Response::make('', 405);
		}

        return Response::make('', 200);
    }
}