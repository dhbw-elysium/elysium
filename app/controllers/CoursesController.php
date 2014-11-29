<?php

use \Illuminate\Validation;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class CoursesController extends BaseController {

    public function showCourses()
    {
        return View::make('courses');
    }

	public function postCourseUpdate()
    {
        $data = array(
            'cid'	=> Input::get('courseCid'),
			'cgid'	=> Input::get('courseCgid'),
            'title'	=> Input::get('courseTitle')
        );

        $rules = array(
            'cid'	=> 'required|numeric',
			'cgid'	=> 'required|numeric',
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


	public function postCourseGroupUpdate()
    {
        $data = array(
			'cgid'	=> Input::get('courseGroupCgid'),
            'title'	=> Input::get('courseGroupTitle')
        );

        $rules = array(
			'cgid'	=> 'required|numeric',
            'title'	=> 'required'
        );

		/** @var \Illuminate\Validation\Validator $validator */
		$validator = Validator::make($data, $rules);

        if ($validator->passes()) {
			if ($data['cgid']) {
				$course = CourseGroup::find($data['cgid']);
			} else {
				$course	= new CourseGroup;
			}
			$course->title	= $data['title'];

			$course->save();

			return Response::make('', 200);
		}

		return Response::make('', 405);
    }


}