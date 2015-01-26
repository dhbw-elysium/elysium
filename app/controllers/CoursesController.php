<?php

use \Illuminate\Validation;
use \Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Response;

class CoursesController extends BaseController {

    public function showCourses()
    {
        if(Auth::user()->isAdmin()) {

            return View::make('courses');
        }
    else
        {
            return Redirect::to('home');   // no
        }
    }

	/**
	 * Create or update a course
	 *
	 * @return \Illuminate\Http\Response
	 */
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

	/**
	 * Delete a course
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postCourseDelete()
    {

		$cid	= Input::get('courseCid');

		/** @var \Illuminate\Validation\Validator $validator */
		$validator = Validator::make(
			array('cid' => $cid),
			array('cid' => 'required|numeric')
		);


        if ($validator->passes()) {
			Course::destroy($cid);

			return Response::make('', 200);
		}

		return Response::make('', 405);
    }

	/**
	 * Update or create a course group
	 *
	 * @return \Illuminate\Http\Response
	 */
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
				if (count(DB::table('course_group')->where('title', '=', $data['title'])->get())) {
					return Response::make('', 406);
				}

				$course	= new CourseGroup;
			}
			$course->title	= $data['title'];

			$course->save();

			return Response::make('', 200);
		}

		return Response::make('', 405);
    }

	/**
	 * Delete a course group
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postCourseGroupDelete()
    {

		$cgid	= Input::get('courseGroupCgid');

		/** @var \Illuminate\Validation\Validator $validator */
		$validator = Validator::make(
			array('cgid' => $cgid),
			array('cgid' => 'required|numeric')
		);


        if ($validator->passes() && CourseGroup::destroy($cgid)) {
			return Response::make('', 200);
		}

		return Response::make('', 405);
    }


	/**
	 * Get a list of courses prepared for bootstrap table
	 */
	public function courseListForTable() {
		$limit	= (int)Input::get('limit');
		$offset	= (int)Input::get('offset');

		$sort	= Input::get('sort');
		if (!in_array($sort, array('cid', 'cgid', 'course_title', 'group_title', 'created_at', 'updated_at', 'created_by_name', 'updated_by_name'))) {
			$sort	= false;
		}
		$order	= Input::get('order');
		if (!in_array(strtoupper($sort), array('ASC', 'DESC'))) {
			$sort	= 'ASC';
		}

		$query	= 'SELECT c.cid, c.cgid, c.title AS course_title, g.title AS group_title, c.created_at, c.updated_at,
						  uc.firstname || \' \' || uc.lastname AS created_by_name,
						  uu.firstname || \' \' || uu.lastname AS updated_by_name
					 FROM course c, course_group g, user uc, user uu
					WHERE c.cgid = g.cgid
					  AND c.created_by = uc.uid
					  AND c.updated_by = uu.uid';

		if ($sort) {
			$query	.= ' ORDER BY group_title, course_title';
		} else {
			$query	.= ' ORDER BY '.$sort;
		}

		$query	.= ' '.$order;

		$result	= DB::select($query);

		$course	= null;
		foreach($result as &$course) {
			$courseCreatedDate	= new DateTime($course->created_at);
			$courseUpdatedDate	= new DateTime($course->updated_at);

			$course->created_at	= $courseCreatedDate->format('d.m.Y H:i');
			$course->updated_at	= $courseUpdatedDate->format('d.m.Y H:i');
		}
		unset($course);


		return Response::json($result);
	}

}