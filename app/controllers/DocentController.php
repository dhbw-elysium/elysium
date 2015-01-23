<?php
class DocentController extends BaseController {

    public function showDocent($did) {

		$docent	= Docent::find($did);

        return View::make('docent')->with('docent', $docent);
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
        $textElements       = array('title', 'salution', 'birth_place', 'website', 'email', 'company_name', 'company_part', 'company_job');

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
                case 'company_part':
                    $label      = 'Abteilung';
                    $tooltip    = 'Firmen-Abteilung';
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

                    $formElement    = array(
                        'name'      => 'address_street',
                        'label'     => 'Straße',
                        'tooltip'   => 'Straße und Hausnummer',
                        'type'      => 'text',
                        'value'     => e($address->street)
                    );
                    $form['elements'][] = $formElement;

                    $formElement    = array(
                        'name'      => 'address_city',
                        'label'     => 'Ort',
                        'tooltip'   => '',
                        'type'      => 'text',
                        'value'     => e($address->city)
                    );
                    $form['elements'][] = $formElement;


                    $formElement    = array(
                        'name'      => 'address_plz',
                        'label'     => 'PLZ',
                        'tooltip'   => 'Postleitzahl',
                        'type'      => 'text',
                        'value'     => e($address->plz)
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
            'title', 'salution', 'birth_place', 'website', 'email', 'company_name', 'company_part', 'company_job',
            'activity_teach', 'activity_practical', 'course_extra', 'extra',
        );

        if (in_array($targetElement, $textElements )) {
            $property   = $targetElement;
            $tooltip    = '';
            $type       = 'text';

            switch($targetElement) {
                case 'title':
                case 'salution':
                case 'birth_place':
                case 'website':
                case 'email':
                case 'company_name':
                case 'company_part':
                case 'company_job':
                case 'activity_teach':
                case 'activity_practical':
                case 'course_extra':
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
    public function addStatusEntry() {
        $status = new DocentStatus;

        $status->did        = (int)Input::get('did');
        $status->sid        = (int)Input::get('sid');
        $status->comment    = Input::get('comment');

        try {
            $status->save();
        } catch(Illuminate\Database\QueryException $e) {
            return Response::make('', 504);
        }
        return Response::make('', 200);
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