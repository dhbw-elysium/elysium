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

	/**
	 * Add the event listeners to this model
	 */
	public static function boot()
    {
        parent::boot();

        static::creating(function($entity)
        {
            $entity->created_by = Auth::user()->uid;
        });

        static::updating(function($entity)
        {
            $entity->updated_by = Auth::user()->uid;
        });
    }


	/**
	 * Access a course group by its title
	 *
	 * @param	integer			$cgid					Course group id
	 * @param	string			$title					The title of a course
	 * @param	boolean			$createIfNotExist		Set to true if you want to silently create such an entity
	 * 													if it does not yet exist
	 * @return	CourseGroup								The requested course entity
	 * @throws	\InvalidArgumentException				If no such course was found and shouldn't be created
	 */
	public static function byCgidAndTitle($cgid, $title, $createIfNotExist = false) {
		$course	= self::where('title', '=', $title)->where('cgid', '=', $cgid)->get();


		if (count($course)) {
			return $course[0];
		} elseif ($createIfNotExist) {
			$course		= new self;
			$course->cgid	= $cgid;
			$course->title	= $title;
			$course->save();

			return $course;
		}
		throw new \InvalidArgumentException('Could not find this course');
	}


}
