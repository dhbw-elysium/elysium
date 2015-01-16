<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class PhoneNumber extends Eloquent implements RemindableInterface {

	use RemindableTrait;

	/**
	 * The value of the enum field for the phone number type phone
	 */
	const TYPE_PHONE	= 'phone';

	/**
	 * The value of the enum field for the phone number type mobile
	 */
	const TYPE_MOBILE	= 'mobile';

	/**
	 * The value of the enum field for the phone number type fax
	 */
	const TYPE_FAX	= 'fax';


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

}
