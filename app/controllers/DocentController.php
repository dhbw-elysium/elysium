<?php
class DocentController extends BaseController {

    public function showDocent() {


$importer	= new Elysium\Import\ImportDocents();
    print_r($importer);


        return View::make('docent');
    }
}