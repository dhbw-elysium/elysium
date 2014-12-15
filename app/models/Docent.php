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
		'bank_blz',
		'bank_number',
		'time_mo_am',
		'time_mo_pm',
		'time_tu_am',
		'time_tu_pm',
		'time_we_am',
		'time_we_pm',
		'time_th_am',
		'time_th_pm',
		'time_fr_am',
		'time_fr_pm',
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
        return $this->hasMany('PhoneNumber', 'did', 'did');
    }

	public function courses()
    {
        return $this->belongsToMany('Course', 'docent_course', 'did', 'cid');
    }

	public function status()
    {
        return $this->belongsToMany('Status', 'docent_status', 'did', 'sid');
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

	/**
	 * Return the default private phone number (phone or mobile)
	 *
	 * @return string|boolean		Number or false if there is no stored
	 */
	public function phonePrivateDefault() {
		$relation			= $this->phoneNumbers()->where('is_private', '=', true)->orderBy('type')->get();
		$phoneNumberList	= $relation->toArray();
		if (count($phoneNumberList)) {
			return $phoneNumberList[0]['number'];
		}
		return false;
	}

	/**
	 * Get the latest docent state
	 *
	 * @return stdClass
	 */
	public function statusLatest() {
		$query	= 'SELECT s.sid, s.title, s.glyph, ds.did, ds.created_at, ds.created_by, ds.updated_at, ds.updated_by
					 FROM docent_status ds, status s
					WHERE s.sid = ds.sid
					  AND ds.did =?
				 ORDER BY created_at ASC
				    LIMIT 1';

		$result	= DB::select($query, array($this->did));

		return $result[0];
	}

	/**
	 * Add status change
	 *
	 * @param	integer	$sid			Status id
	 * @param	string	$comment		Status content
	 */
	public function addStatus($sid, $comment) {
		$timestamp	= new \DateTime();

		DB::table('docent_status')->insert(
			array(
				'did'			=> $this->did,
				'sid'			=> $sid,
				'comment'		=> $comment,
				'created_at'	=> $timestamp,
				'created_by'	=> Auth::id(),
				'updated_at'	=> $timestamp,
				'updated_by'	=> Auth::id()
			)
    	);
	}

}
