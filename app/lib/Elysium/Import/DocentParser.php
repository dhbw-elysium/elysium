<?php

namespace Elysium\Import;

use Elysium\DocentData;

abstract class DocentParser {

	/**
	 * A list of docents to import
	 *
	 * @var	array|null
	 */
	protected $_docents = null;

	/**
	 * A list of course groups of this import
	 *
	 * @var array|null
	 */
	protected $_courseGroups	= null;

	/**
	 * Parse the excel file
	 */
	public abstract function parse();

	/**
	 * Get the docents which were parsed
	 *
	 * @return	array			A list of docents
	 */
	public function docents() {
		if ($this->_docents === null) {
			$this->parse();
		}

		return $this->_docents;
	}

	/**
	 * Get the course groups which were found during parse
	 *
	 * @return	array			A list of course groups
	 */
	public function courseGroups() {
		if ($this->_courseGroups === null) {
			$this->parse();
		}

		return $this->_courseGroups;
	}
}