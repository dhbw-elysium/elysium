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

	/**
	 * Primary key
	 *
	 * @var string
	 */
	protected $primaryKey = 'did';


	/**
	 * Mass assignable columns
	 *
	 * @var array
	 */
	protected $fillable	= array(
		'salution',
		'title',
		'graduation',
		'first_name',
		'last_name',
		'email',
		'website',
		'birth_place',
		'lbv',
		'company_job',
		'company_name',
		'company_aid',
		'bank_name',
		'bank_bic',
		'bank_iban',
		'is_exdhbw',
		'activity_teach',
		'activity_practical',
		'course_extra',
		'extra'
	);

	public function getDates()
    {
        return array('birth_day', 'created_at', 'updated_at');
    }

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

	public function courses()
    {
        return $this->belongsToMany('Course', 'docent_course', 'did', 'cid');
    }

	public static function duplicateCandidates($lastName, $firstName) {
		$query	= DB::table('docent')->select('last_name', 'first_name', 'company_job');

		if (strlen($lastName)) {
			$query->where('last_name', 'LIKE', $lastName);
		}

		if (strlen($firstName)) {
			$query->where('first_name', 'LIKE', $firstName);
		}

		return $query->get();
	}

}
