<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Address extends Eloquent implements RemindableInterface {

	use RemindableTrait;

	/**
	 * Defines an address as a private one
	 */
	const TYPE_PRIVATE	= 1;

	/**
	 * Defines an address as a company one
	 */
	const TYPE_COMPANY	= 2;


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'address';

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'aid';

	/**
	 * Mass assignable columns
	 *
	 * @var array
	 */
	protected $fillable	= array(
		'street',
		'plz',
		'city'
	);

}
