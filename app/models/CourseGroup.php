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

	/**
	 * Add the event listeners to this model
	 */
	public static function boot()
    {
        parent::boot();

        static::creating(function($entity)
        {
            $entity->created_by = Auth::user()->uid;
            $entity->updated_by = Auth::user()->uid;
        });

        static::updating(function($entity)
        {
            $entity->updated_by = Auth::user()->uid;
        });
    }


	/**
	 * Access a course group by its title
	 *
	 * @param	string			$title					The title of a course group
	 * @param	boolean			$createIfNotExist		Set to true if you want to silently create such an entity
	 * 													if it does not yet exist
	 * @return	CourseGroup								The requested course group entity
	 * @throws	\InvalidArgumentException				If no such course group was found and shouldn't be created
	 */
	public static function byTitle($title, $createIfNotExist = false) {
		$courseGroup	= self::where('title', '=', $title)->get();

		if (count($courseGroup)) {
			return $courseGroup[0];
		} elseif ($createIfNotExist) {
			$courseGroup		= new self;
			$courseGroup->title	= $title;
			$courseGroup->save();

			return $courseGroup;
		}
		throw new \InvalidArgumentException('Could not find this course group');
	}




}
