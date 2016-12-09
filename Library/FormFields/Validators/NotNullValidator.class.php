<?php
namespace Library\FormFields\Validators;

class NotNullValidator extends \Library\Validator
{	
	public function __construct($errorMessage)
	{
		parent::__construct($errorMessage);		
	}
	
	public function isValid($value)
	{
		return $value != '';
	}
}