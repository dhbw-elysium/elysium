<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Docent extends Eloquent implements RemindableInterface {

	use RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'docent';


	public function privateAddress()
    {
        return $this->hasOne('Address', 'aid', 'private_aid');
    }


	public function companyAddress()
    {
        return $this->hasOne('Address', 'aid', 'company_aid');
    }

	public function phoneNumbers()
    {
        return $this->hasMany('PhoneNumber');
    }


}
