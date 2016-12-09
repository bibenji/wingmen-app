<?php
namespace FormFields\Validators\Library;

class FileValidator extends \Library\Validator
{	
	protected $maxSize;
	
	public function __construct($errorMessage, $maxSize)
	{
		parent::__construct($errorMessage);	
		$this->setMaxSize($maxSize);
	}
	
	public function isValid($value) {
		// les vérifications à faire ici
	}
	
	public function setMaxSize($maxSize)
	{
		$maxSize = (int) $maxSize;
		if ($maxSize > 0) { $this->maxSize = $maxSize;}
		else { throw new \RuntimeException('La taille maximale doit être un nombre supérieur à 0');}
	}
}