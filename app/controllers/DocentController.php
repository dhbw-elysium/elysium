<?php
class DocentController extends BaseController {

    public function showDocent($did) {

		$docent	= Docent::find($did);

        return View::make('docent')->with('docent', $docent);
    }
}