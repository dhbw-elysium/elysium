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

        $textElements   = array('title', 'salution', 'birth_place', 'website', 'email', 'company_name', 'company_part', 'company_job');
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

        } else {
            switch($targetElement) {
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