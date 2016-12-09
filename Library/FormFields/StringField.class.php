<?php
namespace Library\FormFields;

class StringField extends \Library\Field
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
				
		$widget .= '<input type="text" class="form-control" name="'.$this->name.'" placeholder="'.$this->placeHolder.'"';
		
		if (!empty($this->value)) {
			$widget .= ' value="'.htmlspecialchars($this->value).'"';
		}
		
		if (!empty($this->maxLength)) {
			$widget .= ' maxlength="'.$this->maxLength.'"';
		}
		
		$widget .= ' />';
		
		return $widget .= '</div>';
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