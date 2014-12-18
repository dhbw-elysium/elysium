<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Status extends Eloquent implements RemindableInterface {

	use RemindableTrait, SoftDeletingTrait;

	/**
	 * Contains the sid of the imported status
	 */
	const STATUS_IMPORT	= 1;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'status';

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'sid';

	/**
	 * Contains the fields of the model which are dates
	 *
	 * @return array
	 */
	public function getDates()
    {
        return array('deleted_at', 'created_at', 'updated_at');
    }

}
