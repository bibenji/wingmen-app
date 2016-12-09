<?php
namespace Library\FormFields;

class HiddenField extends \Library\Field
{
	protected $maxLength;

	public function buildWidget()
	{
		$widget = '';
		
		if (!empty($this->errorMessage)) { $widget .= $this->errorMessage.'<br />';}
		
		$widget .= '<label>'.$this->label.'</label><input type="hidden" name="'.$this->name.'"';
		
		if (!empty($this->value)) { $widget .= ' value="'.htmlspecialchars($this->value).'"';}
		
		if (!empty($this->maxLength)) { $widget .= ' maxlength="'.$this->maxLength.'"';}
		
		return $widget .= ' />';
	}
	
	/* function à supprimer */
	public function setMaxLength($maxLength)
	{
		$maxLength = (int) $maxLength;
		if ($maxLength > 0)
		{
			$this->maxLength = $maxLength;
		}
		else
		{
			throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
		}
	}
}