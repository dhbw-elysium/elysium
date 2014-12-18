<?php

use \Illuminate\Validation;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class StatusController extends BaseController {

    public function showStatusList()
    {
        return View::make('status.list');
    }

	/**
	 * Create or update a course
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStatusUpdate()
    {
        $data = array(
            'sid'	=> Input::get('sid'),
            'title'	=> Input::get('title')
        );

        $rules = array(
            'sid'	=> 'required|numeric',
            'title'	=> 'required'
        );

		/** @var \Illuminate\Validation\Validator $validator */
		$validator = Validator::make($data, $rules);

        if ($validator->passes()) {
			if ($data['cid']) {
				$course = Course::find($data['cid']);
			} else {
				$course	= new Course;
			}
			$course->cgid	= $data['cgid'];
			$course->title	= $data['title'];

			$course->save();

			return Response::make('', 200);
		}

		return Response::make('', 405);
    }

	/**
	 * Delete a course
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStatusDelete()
    {

		$sid	= Input::get('sid');

		/** @var \Illuminate\Validation\Validator $validator */
		$validator = Validator::make(
			array('sid' => $sid),
			array('sid' => 'required|numeric')
		);


        if ($validator->passes()) {
			$status	= Status::find($sid);
			$status->deleted_by	=

			Status::destroy($sid);

			return Response::make('', 200);
		}

		return Response::make('', 405);
    }


}