<?php
namespace Library\FormFields;

class TextareaField extends \Library\Field
{	
	public function buildWidget()
	{
		$widget = '';
		
		if (!empty($this->errorMessage)) $class = ' has-error';
		else $class = '';
		
		$widget .= '<div class="form-group'.$class.'" id="'.$this->name.'" /><label>'.$this->label.'</label>';
		
		if (!empty($this->errorMessage))
		{
			$widget .= $this->errorMessage.'<br />';
		}
		
		$widget .= '<textarea class="form-control" name="'.$this->name.'" rows="5">';
		
		if (!empty($this->value)) {
			$widget .= $this->value;
		}		
		
		return $widget .= '</textarea></div>';		
	}
}