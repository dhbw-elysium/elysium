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
		if ($this->private_aid) {
			return Address::findOrFail($this->private_aid);
		}
    }

	public function companyAddress()
    {
		if ($this->company_aid) {
			return Address::findOrFail($this->company_aid);
		}
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
	 * Get a list of possible duplicates to the given name
	 *
	 * @param	string	$lastName		Last name
	 * @param	string	$firstName		First name
	 * @return	mixed
	 */
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
	 * @param	integer	$count		List limit
	 * @param	integer	$offset		List offset
	 * @return	array				A list of docents
	 */
	public static function docentList($count = null, $offset = null) {

		$query	= 'SELECT d.did,
						  s.sid,
						  d.last_name,
						  d.first_name,
						  s.title as status_title,
						  s.glyph as status_glyph,
						  c.cid as course_cid,
						  c.title as course_title
					 FROM docent d
			   INNER JOIN docent_status ds ON (ds.did = d.did)
			   INNER JOIN (SELECT ds2.did, MAX(ds2.dsid) AS latest_dsid FROM docent_status ds2 GROUP BY ds2.did) x ON (x.did = ds.did AND x.latest_dsid = ds.dsid)
			   INNER JOIN status s ON ds.sid = s.sid
			   INNER JOIN docent_course dc ON dc.did = d.did
			   INNER JOIN course c ON dc.cid = c.cid
		';

		$query	.= ' ORDER BY last_name ASC, first_name ASC';

		if ($count && $offset) {
			$query	.= sprintf(' LIMIT %d, %d', $offset, $count);

		} elseif($count) {
			$query	.= ' LIMIT '.(int)$count;
		}

		$docentsFlat	= DB::select(DB::raw($query));

		$docents	= array();
		foreach ($docentsFlat as $docentData) {
			$did	= (int)$docentData->did;

			if (!isset($docents[$did])) {
				$docents[$did]	= array(
					'did'			=> $did,
					'sid'			=> (int)$docentData->sid,
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

	/**
	 * Get a list of docent ids
	 *
	 * @param	integer	$sid		A special status id
	 * @return	array				A list of docents
	 */
	public static function docentListWithLatestStatus($sid) {

		$query	= 'SELECT DISTINCT(d.did)
					 FROM docent d
			   INNER JOIN docent_status ds ON (ds.did = d.did)
			   INNER JOIN (SELECT ds2.did, MAX(ds2.dsid) AS latest_dsid FROM docent_status ds2 GROUP BY ds2.did) x ON (x.did = ds.did AND x.latest_dsid = ds.dsid)
			   INNER JOIN status s ON ds.sid = s.sid
			   INNER JOIN docent_course dc ON dc.did = d.did
			   INNER JOIN course c ON dc.cid = c.cid
			   		WHERE s.sid = ?
				 ORDER BY last_name ASC, first_name ASC
		';

		return DB::select($query, array($sid));
	}

	/**
	 * Get value of a property prepared for html display
	 *
	 * @param	string	$property	The property to access
	 * @return	string				Html escaped content
	 */
	public function displayData($property) {
		$data	= $this->$property;

		switch($property) {
			case 'is_exdhbw':
				return ($data ? 'ja' : 'nein');
		}

		if ($data) {
			if ($data instanceof \DateTime) {

				switch($property) {
					case 'birth_day':
						$format	= 'd.m.Y';
						break;
					default:
						$format	= 'd.m.Y H:i';
						break;
				}

				return $data->format($format);
			}
			return e($data);
		} else {
			return '<i class="empty" title="keine Angabe">(leer)</i>';
		}
	}

	/**
	 * Display the lastname, firstname of the docent
	 *
	 * @return string
	 */
	public function displayName() {
		$firstName	= e($this->first_name);
		$lastName	= e($this->last_name);

		if ($firstName && $lastName) {
			return sprintf('%s, %s', $lastName, $firstName);
		} elseif ($lastName) {
			return sprintf('%s', $lastName);
		} elseif ($firstName) {
			return sprintf('%s', $firstName);
		} else {
			return $this->displayData('first_name');
		}
	}

	/**
	 * Display well formatted address
	 *
	 * @param	integer	$type		The address to display
	 * @return	string				Escaped address
	 */
	public function displayAddress($type = null) {
		switch ($type) {
			case Address::TYPE_COMPANY:
				$address = $this->companyAddress();
				break;
			case null:
			case Address::TYPE_PRIVATE:
				$address = $this->privateAddress();
				break;
			default:
				throw new InvalidArgumentException('Unknown address type transmitted');
		}

		if (!$address) {
			return '';
		}

		return sprintf('%s<br>%s %s', e($address->street), e($address->plz), e($address->city));
	}

	/**
	 * Display phone numbers
	 *
	 * @param	boolean		$private		True to display private numbers, false to display company numbers
	 * @return	string						Html formatted phone number list
	 */
	public function displayPhoneNumberList($private = true) {
		$format			= '<div class="phone-number" title="%s"><span class="glyphicon glyphicon-%s"></span> %s</div>';
		$numberBlock	= '';

		foreach($this->phoneNumbers as $phoneNumber) {
			if ($phoneNumber->is_private == $private && $phoneNumber->number) {
				switch($phoneNumber->type) {
					case PhoneNumber::TYPE_PHONE:
						$glyph	= 'phone-alt';
						$title	= 'Festnetznummer';
						break;
					case PhoneNumber::TYPE_MOBILE:
						$glyph	= 'phone';
						$title	= 'Mobiltelefonnummer';
						break;
					case PhoneNumber::TYPE_FAX:
						$glyph	= 'inbox';
						$title	= 'Faxnummer';
						break;
					default:
						$glyph	= 'earphone';
						$title	= 'Telefonnummer';
						break;
				}
				$numberBlock	.= sprintf($format, $title, $glyph, e($phoneNumber->number));
			}
		}

		if (!$numberBlock) {
			$numberBlock	= '<i class="empty" title="keine Telefonnummern gespeichert">(leer)</i>';
		}

		return $numberBlock;

	}


	public function statusHistory() {
		$query	= 'SELECT ds.dsid, s.sid, s.title, s.glyph, s.description, ds.did, ds.comment, ds.created_at, ds.created_by, u.lastname, u.firstname
					 FROM docent_status ds,
						  status s,
						  user u
					WHERE s.sid = ds.sid
					  AND ds.created_by = u.uid
					  AND ds.did =?
				 ORDER BY ds.created_at DESC';

		$result	= DB::select($query, array($this->did));

		return $result;

	}

    /**
     * Get the number of new Docents
     *
     * @return string
     */
    public static function getNumberOfNewDocents($date) {
    return DB::table('docent')->where('created_at','>=', $date)->count();
    }

}
