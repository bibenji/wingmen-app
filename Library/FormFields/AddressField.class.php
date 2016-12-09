<?php
namespace Library\FormFields;

class AddressField extends \Library\Field
{
	protected $maxLength, $placeHolder;

	public function buildWidget()
	{
		if (!empty($this->errorMessage)) $class = ' has-error';
		else $class = '';
		
		$widget = '<div class="form-group'.$class.'" id="'.$this->name.'" /><label>'.$this->label.'</label> ';
				
		if (!empty($this->errorMessage)) {
			$widget .= $this->errorMessage.'<br />';
		}
		
		$widget .='<input type="text" id="entered_adr" class="form-control" placeholder="'.$this->placeHolder.'"';
		
		if (!empty($this->value)) {		
			$widget .= ' value="'.htmlspecialchars($this->value).'"';
		}

		$widget .= ' /></div>';
		
		$widget .= '<div class="" id="'.$this->name.'" /><input type="text" id="true_adr" class="form-control" name="'.$this->name.'"';
		
		if (!empty($this->value)) {			
			$widget .= ' value="'.htmlspecialchars($this->value).'"';
		}
		
		if (!empty($this->maxLength)) {
			$widget .= ' maxlength="'.$this->maxLength.'"';
		}
		
		$widget .= ' readonly /></div>';
		// $widget .= '<div class=""><input type="text" id="true_coordos" class="form-control" name="mb_coordos" readonly /></div>';
		
		return $widget;
	}
	
	public function setMaxLength($maxLength)
	{
		$maxLength = (int) $maxLength;
		if ($maxLength > 0) {
			$this->maxLength = $maxLength;
		}
		else {
			throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
		}
	}
	
	public function setPlaceHolder($placeHolder)
	{
		if (is_string($placeHolder)) $this->placeHolder = $placeHolder;
		else throw new \RuntimeException('Le placeholder doit être une chaîne de caractètres');
	}	
}