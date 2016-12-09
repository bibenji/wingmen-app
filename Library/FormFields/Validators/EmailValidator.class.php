<?php
namespace Library\FormFields\Validators;

class EmailValidator extends \Library\Validator
{
	public function __construct($errorMessage)
	{
		parent::__construct($errorMessage);	
	}
	
	public function isValid($value)
	{
		return preg_match("/\S+\@\S+\.\w{2,}/", $value);
	}	
}