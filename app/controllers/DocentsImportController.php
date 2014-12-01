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
				$parser->parse();
			} else {
				return View::make('docents.importprocess')->with('danger', 'Import Fehlgeschlagen');
			}
		}


        return View::make('docents.importprocess');
    }

}