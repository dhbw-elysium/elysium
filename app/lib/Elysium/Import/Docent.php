<?php

namespace Elysium\Import;


class Docent {

	/**
	 * Data of this entity
	 *
	 * @var array
	 */
	protected $_data	= array(
		'salution'					=> null,
		'title'						=> null,
		'last_name'					=> null,
		'first_name'				=> null,
		'graduation'				=> null,
		'private_address'			=> array(
			'street' 	=> null,
			'plz' 		=> null,
			'city' 		=> null
		),
		'phone_number'				=> array(
			'private_phone'		=> null,
			'private_mobile'	=> null,
			'company_phone'		=> null,
			'company_fax' 		=> null,
			'company_mobile' 	=> null
		),
		'company_job'				=> null,
		'email'						=> null,
		'website'					=> null,
		'birth_day'					=> null,
		'birth_place'				=> null,
		'bank_name'					=> null,
		'bank_blz'					=> null,
		'bank_bic'					=> null,
		'bank_iban'					=> null,
		'bank_number'				=> null,
		'lbv'						=> null,
		'company_name'				=> null,
		'company_department'		=> null,
		'company_address'			=> array(
			'street'	=> null,
			'plz'		=> null,
			'city'		=> null
		),
		'is_exdhbw'					=> null,
		'course_group'				=> null,
		'time'						=> array(
			'time_mo_am' => null,
			'time_mo_pm' => null,
			'time_tu_am' => null,
			'time_tu_pm' => null,
			'time_we_am' => null,
			'time_we_pm' => null,
			'time_th_am' => null,
			'time_th_pm' => null,
			'time_fr_am' => null,
			'time_fr_pm' => null
		),
		'activity_teach'			=> null,
		'activity_practical'		=> null,
		'course_extra'				=> null,
		'extra'						=> null,
		'imported_at'				=> null
	);

	/**
	 * Migration comments
	 *
	 * @var array
	 */
	protected $_comments	= array();

	public function __construct() {

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
	 * Add a migration comment
	 *
	 * @param	string	$comment		Comment message
	 */
	public function addComment($comment) {
		$this->_comments[]	= $comment;
	}
}

