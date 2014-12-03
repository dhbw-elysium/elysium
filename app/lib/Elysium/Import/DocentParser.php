<?php

namespace Elysium\Import;

use Elysium\DocentData;

class DocentParser {

	/**
	 * The excel workbook to parse
	 *
	 * @var	\PHPExcel
	 */
	protected $_workbook;

	/**
	 * The sheet which contains data
	 *
	 * @var	\PHPExcel_Worksheet
	 */
	protected $_sheet;

	/**
	 * A list of docents to import
	 *
	 * @var	array|null
	 */
	protected $_docents = null;

	/**
	 * Stores the general definition which data is placed under which excel header
	 *
	 * @var array
	 */
	public static $columnDefinition	= array(
		'salution'					=> 'Anrede',
		'title'						=> 'Titel',
		'last_name'					=> 'Name',
		'first_name'				=> 'Vorname',
		'graduation'				=> 'Abschluss',
		'private_address_street'	=> 'Straße Nr.',
		'private_address_plz'		=> 'PLZ',
		'private_address_city'		=> 'Ort',
		'company_job'				=> 'Beruf',
		'phone_private_phone'		=> 'Telefon',
		'phone_private_mobile'		=> 'Mobil',
		'email'						=> 'E-Mail',
		'website'					=> 'Webseite',
		'birth_day'					=> 'Geburtsdatum',
		'birth_place'				=> 'Geburtsort',
		'bank_name'					=> 'Bank',
		'bank_blz'					=> 'BLZ',
		'bank_bic'					=> 'BIC',
		'bank_iban'					=> 'IBAN',
		'bank_number'				=> 'Kontonummer',
		'lbv'						=> 'LBV-Nr.',
		'company_name'				=> 'Arbeitgeber Firma',
		'company_department'		=> 'Abteilung',
		'company_address_street'	=> 'Straße Nr.',
		'company_address_plz'		=> 'PLZ',
		'company_address_city'		=> 'Ort',
		'phone_company_phone'		=> 'Telefon',
		'phone_company_fax'			=> 'Fax',
		'phone_company_mobile'		=> 'Mobil',
		'is_exdhbw'					=> 'Ehemalige/r BA-/DHBW-Student/in',
		'course_group'				=> 'Bevorzugtes Studienfach',
		'time'						=> 'Bevorzugte Vorlesungszeiten',
		'activity_teach'			=> 'Lehraufträge und Lehrtätigkeiten',
		'activity_practical'		=> 'Praktische Tätigkeiten',
		'course_extra'				=> 'Weitere mögliche Vorlesungsbereiche sowie bereits gehaltene Vorlesungen',
		'extra'						=> 'Anmerkungen, Ergänzungen',
		'imported_at'				=> 'eingegangen am'
	);

	/**
	 * Stores which course group title resides on which column
	 *
	 * @var array
	 */
	protected $_courseGroupDefinition = array();

	/**
	 * Set to true if the column index definition is stored
	 *
	 * @var boolean
	 */
	protected $_columnIndexDefinitionParsed = false;

	/**
	 * Stores which information resides on which column index of the actual import
	 *
	 * @var array
	 */
	protected $_columnIndexDefinition	= array(
		'salution'					=> null,
		'title'						=> null,
		'last_name'					=> null,
		'first_name'				=> null,
		'graduation'				=> null,
		'private_address_street'	=> null,
		'private_address_plz'		=> null,
		'private_address_city'		=> null,
		'company_job'				=> null,
		'phone_private_phone'		=> null,
		'phone_private_mobile'		=> null,
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
		'company_address_street'	=> null,
		'company_address_plz'		=> null,
		'company_address_city'		=> null,
		'phone_company_phone'		=> null,
		'phone_company_fax'			=> null,
		'phone_company_mobile'		=> null,
		'is_exdhbw'					=> null,
		'course_group'				=> null,
		'time'						=> null,
		'activity_teach'			=> null,
		'activity_practical'		=> null,
		'course_extra'				=> null,
		'extra'						=> null,
		'imported_at'				=> null
	);

	/**
	 * Create a new docent parser instance by a path to an excel file
	 *
	 * @param	string			$path
	 * @return	DocentParser
	 */
	public static function fromFile($path) {

		$workbook	= \PHPExcel_IOFactory::load($path);

		return new self($workbook);
	}

	/**
	 * Create a new docent parser
	 *
	 * @param	\PHPExcel	$workbook		The workbook to parse
	 */
	public function __construct(\PHPExcel $workbook) {
		$this->_workbook	= $workbook;
		$this->_sheet		= $workbook->getSheet(0);
	}

	/**
	 * Get the general column definition
	 *
	 * @param	boolean	$reverse		Set to true to get definition in reverse order
	 * @return 	array
	 */
	public static function columnDefinition($reverse = false) {
		if ($reverse) {
			$columnDefinitionReverse	= array();

			foreach(self::$columnDefinition as $data => $column) {
				$columnDefinitionReverse[$column][]	= $data;
			}

			return $columnDefinitionReverse;
		} else {
			return self::$columnDefinition;
		}
	}

	/**
	 * Get the current column index definition (which data has which column index)
	 *
	 * @return array
	 */
	public function columnIndexDefinition() {
		if (!$this->_columnIndexDefinitionParsed) {
			$columnDefinitionReverse	= self::columnDefinition(true);

			for ($i = 0; $i <= 200; $i++) {
				$columnTitle	= $this->_sheet->getCellByColumnAndRow($i, 1)->getValue();
				$columnTitle	= $string = trim(preg_replace('/\s\s+/', ' ', $columnTitle));

				if (!$columnTitle) {
					continue;
				}

				if (isset($columnDefinitionReverse[$columnTitle])) {
					//this is a general key like firstname, lastname...
					$columnName	= reset($columnDefinitionReverse[$columnTitle]);
					$columnKey	= key($columnDefinitionReverse[$columnTitle]);

					$this->_columnIndexDefinition[$columnName]	= $i;

					unset($columnDefinitionReverse[$columnTitle][$columnKey]);
				} else {
					//this is a course group

					if (isset($this->_courseGroupDefinition[$columnTitle])) {
						throw new \InvalidArgumentException('The same course group title "'.$columnTitle.'" appeared twice');
					}
					$this->_courseGroupDefinition[$columnTitle]	= $i;
				}
			}

			$this->_columnIndexDefinitionParsed	= true;
		}

		return $this->_columnIndexDefinition;
	}

	/**
	 * Get the course group definition
	 *
	 * @see		columnIndexDefinition()
	 * @return	array
	 */
	public function columnCourseGroupIndexDefinition() {
		if (!$this->_columnIndexDefinitionParsed) {
			$this->columnIndexDefinition();
		}
		return $this->_courseGroupDefinition;
	}


	/**
	 * Parse the excel file
	 */
	public function parse() {
		$columnIndexDefinition	= $this->columnIndexDefinition();
		$courseGroupDefinition	= $this->columnCourseGroupIndexDefinition();
		$lastRow				= $this->_sheet->getHighestDataRow();
		$this->_docents			= array();

		for($r = 2; $r <= $lastRow; $r++) {
			$lastName	= $this->_sheet->getCellByColumnAndRow($columnIndexDefinition['last_name'], $r)->getValue();

			if (!$lastName) {
				//skip rows which have no last name entered
				continue;
			}

			$sheet				= $this->_sheet;
			$docent				= new Docent();
			$docentProperties	= $docent->data();

			/**
			 * Get a cell by passing the wanted property
			 *
			 * @param	string				$property		Property name
			 * @return	\PHPExcel_Cell						The respective cell
			 */
			$cellByProperty	= function($property) use ($columnIndexDefinition, $r, $sheet) {
				return $sheet->getCellByColumnAndRow($columnIndexDefinition[$property], $r);
			};

			foreach($docentProperties as $property => $subProperties) {
				switch($property) {
					case 'birth_day':
						$cell 	= $cellByProperty($property);
						if (\PHPExcel_Shared_Date::isDateTime($cell)) {
							$docent->addData($property, \PHPExcel_Style_NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD'));
						} else {
							$docent->addComment('Das Geburtstdatum konnte nicht gelesen werden');
						}
						break;
					case 'time':
						$docent->addData($property, DocentData\TeachTimeSet::fromTimeTitleList(preg_split( '/\r\n|\r|\n/', $cellByProperty($property)->getFormattedValue())));
						break;
					case 'is_exdhbw':
						$value	= $cellByProperty($property)->getFormattedValue();
						$docent->addData($property, ($value == 'ja'));
						break;
					case 'imported_at':
						$cell	= $cellByProperty($property);
						if(\PHPExcel_Shared_Date::isDateTime($cell)) {
							$importDate	= \DateTime::createFromFormat('U', \PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
							$docent->addData($property, $importDate->format('Y-m-d')); //format it directly to fixed date to prevent timezone switching issues
						} else {
							$docent->addComment('Eingangsdatum der Bewerbung konnte nicht gelesen werden');
						}
						break;
					case 'private_address':
					case 'company_address':
						$address	= array(
							'street'	=> $cellByProperty($property.'_street')->getFormattedValue(),
							'plz' 		=> $cellByProperty($property.'_plz')->getFormattedValue(),
							'city' 		=> $cellByProperty($property.'_city')->getFormattedValue()
						);
						if ($address == 'company_address') {
						dd($address, $property);

						}
						$docent->addData($property, $address);
						break;
					case 'phone_number':
						$phoneNumbers	= array_keys($subProperties);
						$phoneData		= array();
						foreach($phoneNumbers as $phoneNumber) {
							$phoneData[$phoneNumber]	= $cellByProperty('phone_'.$phoneNumber)->getFormattedValue();
						}
						$docent->addData($property, $phoneData);

						break;
					default:
						$docent->addData($property, $cellByProperty($property)->getFormattedValue());
						break;
				}

			}

			foreach($courseGroupDefinition as $group => $c) {
				$cellValue	= trim($this->_sheet->getCellByColumnAndRow($c, $r)->getFormattedValue());
				if ($cellValue) {
					$courses	= array();
					foreach(preg_split( '/\r\n|\r|\n/', $cellValue) as $course) {
						$courses[]	= trim($course);
					}

					if (count($courses)) {
						$docent->addCourseGroup($group, $courses);
					}
				}
			}

			$this->_docents[]	= $docent;
		}
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
}