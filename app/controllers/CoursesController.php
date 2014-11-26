<?php
class CoursesController extends BaseController {

    public function showCourses()
    {
        return View::make('courses');
    }
}