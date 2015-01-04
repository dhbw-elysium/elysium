<?php
class DocentController extends BaseController {

    public function showDocent($did) {

		$docent	= Docent::find($did);

        return View::make('docent')->with('docent', $docent);
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