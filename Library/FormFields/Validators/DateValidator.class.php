<?php
namespace Library\FormFields\Validators;

class DateValidator extends \Library\Validator
{
	public function __construct($errorMessage)
	{
		parent::__construct($errorMessage);	
	}
	
	public function isValid($value)
	{
		if (!preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $value)) return false;
		else {
			list($dd,$mm,$yyyy) = explode('/',$value);
			return checkdate($mm,$dd,$yyyy);
		}
	}	
}