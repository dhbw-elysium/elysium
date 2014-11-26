<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class CourseGroup extends Eloquent implements RemindableInterface {

	use RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'course_group';


    public function course()
    {
        return $this->belongsTo('Course', 'cgid', 'cgid');
    }




}
