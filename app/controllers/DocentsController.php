<?php
class DocentsController extends BaseController {

    public function showDocents()
    {
        return View::make('docents.list');
    }
}