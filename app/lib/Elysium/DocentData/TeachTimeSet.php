<?php
/**
 * User: erik
 * Date: 02.12.14
 * Time: 13:35
 */

namespace Elysium\DocentData;


class TeachTimeSet {

	/**
	 * Contains the valid teach times
	 *
	 * @var array
	 */
	protected static $_availableTimes	= array(
		'time_mo_am' => 'Montag Vormittag',
		'time_mo_pm' => 'Montag Nachmittag',
		'time_tu_am' => 'Dienstag Vormittag',
		'time_tu_pm' => 'Dienstag Nachmittag',
		'time_we_am' => 'Mittwoch Vormittag',
		'time_we_pm' => 'Mittwoch Nachmittag',
		'time_th_am' => 'Donnerstag Vormittag',
		'time_th_pm' => 'Donnerstag Nachmittag',
		'time_fr_am' => 'Freitag Vormittag',
		'time_fr_pm' => 'Freitag Nachmittag'
	);

	/**
	 * Contains the activated times of this time set
	 *
	 * @var array
	 */
	protected $_enabledTimes	= array(
		'time_mo_am' => false,
		'time_mo_pm' => false,
		'time_tu_am' => false,
		'time_tu_pm' => false,
		'time_we_am' => false,
		'time_we_pm' => false,
		'time_th_am' => false,
		'time_th_pm' => false,
		'time_fr_am' => false,
		'time_fr_pm' => false
	);

	/**
	 * Stores a list of time titles which
	 *
	 * @var array
	 */
	protected $_unknownTimes	= array();

	/**
	 * Create a new time from a list of time titles
	 *
	 * @param	array			$timeTitles			A list of time titles
	 * @return	TeachTimeSet						A new teach time set
	 */
	public static function fromTimeTitleList(array $timeTitles) {
		$set	= new self();

		foreach ($timeTitles as $title) {
			$set->enableTimeByTitle($title);
		}

		return $set;
	}

	/**
	 * Get the valid teach times
	 *
	 * @param	boolean	$keysOnly		Set to true to get an numeric array only contianing the time keys
	 * @return	array
	 */
	public static function availableTimes($keysOnly = false) {
		return ($keysOnly) ? array_keys(self::$_availableTimes) : self::$_availableTimes;
	}

	/**
	 * Check if a time code is valid (available)
	 *
	 * @param	string	$timeCode		The time to check
	 * @return	boolean					True if the code is available, false if not
	 */
	public static function isTimeCodeAvailable($timeCode) {
		$timeAvailable	= self::availableTimes(true);
		return isset($timeAvailable[$timeCode]);
	}

	/**
	 * Check if a time title is valid (available)
	 *
	 * @param	string	$timeTitle		The time title to check
	 * @return	boolean					True if the time is available, false if not
	 */
	public function isTimeTitleAvailable($timeTitle) {
		$timeTitlesAvailable	= array_flip(self::availableTimes());
		return isset($timeTitlesAvailable[$timeTitle]);
	}

	/**
	 * Get the title of a time by its code
	 *
	 * @param	string		$timeCode		A time code
	 * @return	string						A time title
	 */
	public static function timeTitleByCode($timeCode) {
		if (isset(self::$_availableTimes[$timeCode])) {
			return self::$_availableTimes[$timeCode];
		}
		throw new \InvalidArgumentException('Given time code "'.$timeCode.'" is not available');
	}

	/**
	 * Enable a time of this set
	 *
	 * @param	boolean	$state			Set to true to enable, set to false to disbale the selected time
	 * @param	string	$timeCode		The time to enable
	 */
	public function setTime($timeCode, $state) {
		if (self::isTimeCodeAvailable($timeCode)) {
			$this->_enabledTimes[$timeCode]	= (bool)$state;
		} else {
			throw new \InvalidArgumentException('Given time code "'.$timeCode.'" is not available');
		}
	}

	/**
	 * Enable times by title and add unknown titles to the unknown title list
	 *
	 * @param	string		$title		The time to enable
	 */
	public function enableTimeByTitle($title) {
		if (self::isTimeTitleAvailable($title)) {
			$timeCodes	= array_flip(self::availableTimes());
			$this->_enabledTimes[ $timeCodes[$title] ]	= true;
		} else {
			$this->_unknownTimes[]	= $title;
		}
	}

	/**
	 * Enable a time of this set
	 *
	 * @param	string	$timeCode		The time to enable
	 */
	public function enableTime($timeCode) {
		$this->setTime($timeCode, true);
	}

	/**
	 * Disable a time of this set
	 *
	 * @param	string	$timeCode		The time to disable
	 */
	public function disableTime($timeCode) {
		$this->setTime($timeCode, false);
	}

	/**
	 * Get a list of unknown times
	 *
	 * @return	array
	 */
	public function unknownTimeTitles() {
		return $this->_unknownTimes;
	}

	/**
	 * Get the list of times
	 *
	 * @return array
	 */
	public function times() {
		return $this->_enabledTimes;
	}
}