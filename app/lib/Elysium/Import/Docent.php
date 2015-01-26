<?php

namespace Elysium\Import;


class Docent {

	/**
	 * If this is set to true, this docent will not be imported
	 *
	 * @var boolean
	 */
	protected $_excluded	= false;

	/**
	 * Data of this entity
	 *
	 * @var array
	 */
	protected $_data	= array(
		'salution'				=> null,
		'title'					=> null,
		'last_name'				=> null,
		'first_name'			=> null,
		'graduation'			=> null,
		'private_address'		=> array(
			'street' 	=> null,
			'plz' 		=> null,
			'city' 		=> null
		),
		'phone_number_private'	=> array(
			'phone'		=> null,
			'mobile'	=> null,
		),
		'phone_number_company'	=> array(
			'phone'		=> null,
			'fax' 		=> null,
			'mobile' 	=> null
		),
		'company_job'			=> null,
		'email'					=> null,
		'website'				=> null,
		'birth_day'				=> null,
		'birth_place'			=> null,
		'bank_classic'			=> array(
			'name'		=> null,
			'blz'		=> null,
			'number'	=> null
		),
		'bank_modern'			=> array(
			'iban'		=> null,
			'bic'		=> null
		),
		'lbv'					=> null,
		'company_name'			=> null,
		'company_department'	=> null,
		'company_address'		=> array(
			'street'	=> null,
			'plz'		=> null,
			'city'		=> null
		),
		'is_exdhbw'				=> null,
		'course_group_preferred'	=> null,
		'time'					=> null,
		'activity_teach'		=> null,
		'activity_practical'	=> null,
		'course_extra'			=> null,
		'extra'					=> null,
		'imported_at'			=> null
	);

	/**
	 * Course groups and courses
	 *
	 * @var array
	 */
	protected $_courses	= array();

	/**
	 * Migration comments
	 *
	 * @var array
	 */
	protected $_comments	= array();


	/**
	 * Get the data
	 *
	 * @param	null|string		$element		An element to select. Set to null if you want to get the whole data structure
	 * @return	array
	 * @throws	\InvalidArgumentException		If the transmitted property is unknown
	 */
	public function data($element = null) {
		if ($element) {
			if (array_key_exists($element, $this->_data)) {
				return $this->_data[$element];
			}
			throw new \InvalidArgumentException('Given property "'.$element.'" does not exist');
		}

		return $this->_data;
	}

	/**
	 * Add data
	 *
	 * @param	string		$property		Property to set
	 * @param	mixed		$value			Value of the property
	 * @throws	\InvalidArgumentException	If the transmitted property is unknown
	 */
	public function addData($property, $value) {
		if (array_key_exists($property, $this->_data)) {
			$this->_data[$property]	= $value;
		} else {
			throw new \InvalidArgumentException('Given property "'.$property.'" does not exist');
		}
	}

	/**
	 * Add a list of courses
	 *
	 * @param	string	$courseGroup		Name of the course group
	 * @param	array	$courses			A list of courses
	 */
	public function addCourseGroup($courseGroup, array $courses) {
		$this->_courses[$courseGroup]	= $courses;
	}

	/**
	 * Add a migration comment
	 *
	 * @param	string	$comment		Comment message
	 */
	public function addComment($comment) {
		$this->_comments[]	= $comment;
	}

	/**
	 * Get the courses
	 *
	 * @return array
	 */
	public function courses() {
		return $this->_courses;
	}

	/**
	 * Check if this docent data is valid
	 *
	 * @return bool
	 */
	public function valid() {
		if (!$this->_data['last_name']) {
			return false;
		}

		return true;
	}

	/**
	 * Is this docent excluded?
	 *
	 * @return boolean
	 */
	public function isExcluded() {
		return $this->_excluded;
	}

	/**
	 * Set that this docent is excluded and will not be imported to database
	 *
	 * @param boolean $excluded
	 */
	public function setExcluded($excluded = true) {
		$this->_excluded	= $excluded;
	}

	/**
	 * Create entity from this element
	 *
	 * @return	Docent|boolean		Created entitiy or false if this one should not be included
	 */
	public function createEntity() {

		if ($this->isExcluded()) {
			return false;
		}

		//add time data
		$data	= array_merge($this->_data, $this->_data['time']->times());

		//bank data
		$data['bank_name']		= $data['bank_classic']['name'];
		$data['bank_blz']		= $data['bank_classic']['blz'];
		$data['bank_number']	= $data['bank_classic']['number'];
		$data['bank_iban']		= $data['bank_modern']['iban'];
		$data['bank_bic']		= $data['bank_modern']['bic'];

		if (!isset($data['is_exdhbw'])) {
			$data['is_exdhbw']	= false;
		}

		/** @var \Docent $docent */
		$docent	= \Docent::create($data);

		//date
		$birthDay	= $this->_data['birth_day'];
		if ($birthDay && !$birthDay instanceof \DateTime) {
			$birthDay			= new \DateTime($birthDay);
			$docent->birth_day	= $birthDay;
		}

		//addresses
		$addressPrivate	= \Address::create($data['private_address']);
		$docent->private_aid = $addressPrivate->aid;

		$addressCompany	= \Address::create($data['company_address']);
		$docent->company_aid = $addressCompany->aid;

		$docent->save();

		//add courses
		$docentCourseRelation	= array();
		foreach($this->_courses as $courseGroupTitle => $courses) {
			$courseGroup	= \CourseGroup::byTitle($courseGroupTitle, true);
			foreach($courses as $courseTitle) {
				$course					= \Course::byCgidAndTitle($courseGroup->cgid, $courseTitle, true);
				$docentCourseRelation[]	= array('cid' => $course->cid, 'did' => $docent->did);
			}
		}
		if ($docentCourseRelation) {
			\DB::table('docent_course')->insert($docentCourseRelation);
		}

		if(isset($data['phone_number_private'])) {
			foreach($data['phone_number_private'] as $type => $number) {
				if (trim($number)) {
					$phoneNumber				= new \PhoneNumber();
					$phoneNumber->did			= $docent->did;
					$phoneNumber->is_private	= true;
					$phoneNumber->type			= $type;
					$phoneNumber->number		= $number;

					$phoneNumber->save();
				}
			}
		}

		if(isset($data['phone_number_company'])) {
			foreach($data['phone_number_company'] as $type => $number) {
				if (trim($number)) {
					$phoneNumber				= new \PhoneNumber();
					$phoneNumber->did			= $docent->did;
					$phoneNumber->is_private	= false;
					$phoneNumber->type			= $type;
					$phoneNumber->number		= $number;

					$phoneNumber->save();
				}
			}
		}

		$docent->addStatus(\Status::STATUS_IMPORT, 'Importiert aus Excel Datei');


		return $docent;
	}
}

