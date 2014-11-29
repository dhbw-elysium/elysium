<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Course extends Eloquent implements RemindableInterface {

	use RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'course';

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'cid';


	public function courseGroup()
    {
        return $this->hasOne('CourseGroup', 'cgid', 'cgid');
    }



}
