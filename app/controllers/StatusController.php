<?php

use \Illuminate\Validation;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class StatusController extends BaseController {

    public function showStatusList()
    {
        return View::make('status.list');
    }


    public function showStatusEdit($sid)
    {
        return View::make('status.edit')->with('sid',(int)$sid);
    }

	public function postStatusEdit($sid)
	{
		$data = array(
			'sid'			=> Input::get('sid'),
			'title'			=> Input::get('title'),
			'description'	=> Input::get('description'),
			'glyph'			=> Input::get('glyph')
		);

		$rules = array(
			'sid'			=> 'required|numeric',
			'title'			=> 'required|min:2',
			'description'	=> '',
			'glyph'			=> ''

		);


		$validator = Validator::make($data, $rules);

		if ($validator->passes() && in_array($data['glyph'], Status::glyphicons())) {
			$status					= Status::find($data['sid']);
			$status->title			= $data['title'];
			$status->description	= $data['description'];
			$status->glyph			= $data['glyph'];
			$status->save();

            return Redirect::to('status/list')->with('success', 'Die Änderungen an diesem Status wurden gespeichert');
		}

		return View::make('status.edit')->with('sid', $sid);



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
	 * Delete a status
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postStatusDelete()
    {

		$sid	= Input::get('statusSid');

		/** @var \Illuminate\Validation\Validator $validator */
		$validator = Validator::make(
			array('sid' => $sid),
			array('sid' => 'required|numeric')
		);

        if ($validator->passes()) {
			$status	= Status::find($sid);

			$status->deleted_by	= Auth::id();
			$status->save();

			$status->delete();

			return Response::make('', 200);
		}

		return Response::make('', 405);
    }


}