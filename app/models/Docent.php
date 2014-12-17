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


	/**
	 * Get nested docent data including assigned courses and latest state
	 *
	 * @param	integer	$limit		List limit
	 * @param	integer	$offset		List offset
	 * @param	string	$sort		Sort parameter
	 * @param	string	$order		Sort order
	 * @return	array				A list of docents
	 */
	public static function docentList($limit, $offset, $sort, $order) {

		$query	= 'SELECT d.did,
						  d.last_name,
						  d.first_name,
						  s.title as status_title,
						  s.glyph as status_glyph,
						  c.cid as course_cid,
						  c.title as course_title
					 FROM docent d
			   INNER JOIN docent_status ds ON (ds.did = d.did)
			   INNER JOIN (SELECT ds2.sid, ds2.did, MAX(ds2.created_at) AS latest_created FROM docent_status ds2 GROUP BY ds2.did) x ON (x.did = ds.did AND x.sid = ds.sid)
			   INNER JOIN status s ON ds.sid = s.sid
			   INNER JOIN docent_course dc ON dc.did = d.did
			   INNER JOIN course c ON dc.cid = c.cid


		';
		$docentsFlat	= DB::select(DB::raw($query));

		$docents	= array();
		foreach ($docentsFlat as $docentData) {
			$did	= (int)$docentData->did;

			if (!isset($docents[$did])) {
				$docents[$did]	= array(
					'did'			=> $did,
					'first_name'	=> e($docentData->first_name),
					'last_name'		=> e($docentData->last_name),
					'status_glyph'	=> e($docentData->status_glyph),
					'status'		=> e($docentData->status_title),
					'courses'		=> array()
				);

			}

			$docents[$did]['courses'][$docentData->course_cid]	= e($docentData->course_title);
		}

		return $docents;
	}
}
