<?php
/**
 * User: erik
 * Date: 02.12.14
 * Time: 13:35
 */

namespace Elysium\DocentData;


class BankAccount {

	/**
	 * Name of the bank
	 *
	 * @var	string
	 */
	protected $_name;

	/**
	 * BIC number of the bank account
	 *
	 * @var	string
	 */
	protected $_bic;

	/**
	 * IBAN number of the bank account
	 *
	 * @var	string
	 */
	protected $_iban;

	/**
	 * Set to true if this bank account data was created from blz and bank account number
	 *
	 * Set to true if this bank account data was created from blz and bank account number to warn that this data
	 * may not be correct
	 *
	 * @link	http://www.ecbs.org/iban.htm#warning
	 * @var 	boolean
	 */
	protected $_fromGermanBlzAndNumber	= false;


	/**
	 * Create a new bank account from blz and bank number
	 *
	 * @param	string			$name		Name of a bank
	 * @param	string			$blz		German blz of a bank account
	 * @param	string			$number		German bank account number
	 * @return	BankAccount
	 */
	public static function fromGermanBlzAndNumber($name, $blz, $number) {

		throw new \RuntimeException('Not yet implenented');

		$account	= new self($name, $iban, $bic);
		$account->setFromGermanBlzAndNumber();
		return $account;
	}

	/**
	 * @param	string	$name		Name of a bank
	 * @param	string	$bic		Bic number of the bank
	 * @param	string	$iban
	 */
	public function __construct($name, $bic, $iban) {
		$this->_name	= $name;
		$this->_bic		= $bic;
		$this->_iban	= $iban;
	}


	/**
	 * Validate a iban
	 *
	 * @see		bcmod()
	 * @see		http://stackoverflow.com/questions/20983339/validate-iban-php
	 * @param	string		$iban				The iban to verify
	 * @return	boolean							True if the code is valid, false if not
	 * @throws	\InvalidArgumentException		If an unknown country code was transmitted
	 */
	public static function validateIban($iban) {
		$iban		= strtolower(str_replace(' ','',$iban));
		$countries	= array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
		$chars		= array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

		if (!array_key_exists(substr($iban,0,2), $countries)) {
			throw new \InvalidArgumentException('Unknown country code transmitted');
		}

		if(strlen($iban) == $countries[substr($iban,0,2)]){

			$movedChar = substr($iban, 4).substr($iban,0,4);
			$movedCharArray = str_split($movedChar);
			$newString = '';

			foreach($movedCharArray AS $key => $value){
				if(!is_numeric($movedCharArray[$key])){
					$movedCharArray[$key] = $chars[$movedCharArray[$key]];
				}
				$newString .= $movedCharArray[$key];
			}

			if (function_exists('bcmod')) {
				return bcmod($newString, '97') === 1;
			}

			// http://au2.php.net/manual/en/function.bcmod.php#38474
			$x		= $newString;
			$y		= "97";
			$take	= 5;
			$mod 	= '';

			do {
				$a = (int)$mod . substr($x, 0, $take);
				$x = substr($x, $take);
				$mod = $a % $y;
			} while (strlen($x));

			return (int)$mod == 1;
		} else {
			return true;
		}
	}

	/**
	 * Check if this bank account data was created from blz and bank account number
	 *
	 * @return boolean
	 */
	public function isFromGermanBlzAndNumber() {
		return $this->_fromGermanBlzAndNumber;
	}

	/**
	 * Use to note that this bank account data was created from blz and bank account number
	 */
	public function setFromGermanBlzAndNumber()  {
		$this->_fromGermanBlzAndNumber = true;
	}


}