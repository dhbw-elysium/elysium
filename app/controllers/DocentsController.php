<?php
class DocentsController extends BaseController {

    public function showDocents()
    {
        return View::make('docents.list');
    }



	/**
	 * Get a docent list
	 */
	public function docentListForTable() {
		//$limit	= (int)Input::get('limit');
		//$offset	= (int)Input::get('offset');
		$sort	= Input::get('sort');
		$order	= Input::get('order');
		//$hash	= Input::get('_');


		$docentsWithIdentifier	= Docent::docentList();

		$docents	= array();
		foreach($docentsWithIdentifier as $docent) {
			$docent['name']	= $docent['first_name'].' '.$docent['last_name'];

			$courses	= '<span class="label label-primary label-course-tag">'.implode($docent['courses'], '</span> <span class="label label-primary label-course-tag">').'</span>';
			$docent['course']	= $courses;


			$docents[]	= $docent;
		}

		return Response::json($docents);
	}

}