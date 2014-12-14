<?php

namespace Elysium\Import;


class Docent {

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
		'course_group'			=> null,
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
}

