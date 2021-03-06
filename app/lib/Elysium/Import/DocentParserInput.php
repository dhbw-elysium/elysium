<?php

namespace Elysium\Import;

use Elysium\DocentData;

class DocentParserInput extends DocentParser {


	/**
	 * Create a new docent parser from form input
	 *
	 * @param	array	$docents		A list of docents from input fields
	 */
	public function __construct(array $docents) {
		foreach($docents as $docentData) {
			if (isset($docentData['exclude'])) {
				continue;
			}

			$docent	= new Docent();
			$docent->addData('time', DocentData\TeachTimeSet::fromTimeCodeList(array()));

			foreach($docentData as $property => $data) {
				try {
					switch($property) {
						case 'exclude':
							$docent->setExcluded();
							continue 2;
							break;
						case 'time':
							$data	= DocentData\TeachTimeSet::fromTimeCodeList($data);
							break;
						case 'course':
							foreach($data as $courseGroup => $courses) {
								$docent->addCourseGroup($courseGroup, $courses);
							}
							break 2;
					}

					$docent->addData($property, $data);

				} catch(\InvalidArgumentException $e) {
					dd($e);
				}
			}


			$this->_docents[]	= $docent;
		}
	}

	/**
	 * @return void
	 */
	public function parse() {
	}


}