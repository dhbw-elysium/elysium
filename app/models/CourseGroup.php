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

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'cgid';


    public function course()
    {
        return $this->hasMany('Course', 'cgid', 'cgid');
    }




}
