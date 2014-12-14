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
	 * Create a new docent parser instance by a path to an excel file
	 *
	 * @param	string			$path
	 * @return	DocentParser
	 */
	public static function fromExcel($path) {

		$workbook	= \PHPExcel_IOFactory::load($path);

		return new DocentParserExcel($workbook);
	}

	/**
	 * Create a new docent parser instance from received form input
	 *
	 * @param	array			$docents		Docent form data
	 * @return	DocentParser
	 */
	public static function fromInput(array $docents) {
		return new DocentParserInput($docents);
	}

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

	/**
	 * Check if the parsed docents are valid
	 *
	 * @return bool
	 */
	public function valid() {
		foreach ($this->_docents as $docent) {
			if (!$docent->valid()) {
				return false;
			}
		}

		return true;
	}
}