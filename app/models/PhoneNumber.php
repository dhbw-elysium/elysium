<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class PhoneNumber extends Eloquent implements RemindableInterface {

	use RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'phone_number';

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'pid';


	public function docent()
    {
        return $this->belongsTo('Docent');
    }


}
