<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Status extends Eloquent implements RemindableInterface {

	use RemindableTrait;

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



}
