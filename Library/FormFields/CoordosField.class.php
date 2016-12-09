<?php
namespace Library\FormFields;

class CoordosField extends \Library\Field
{
	public function buildWidget()
	{			
		$widget = '<div class=""><input type="text" id="true_coordos" class="form-control" name="'.$this->name.'"';
		
		if (!empty($this->value)) {			
			$widget .= ' value="'.htmlspecialchars($this->value).'"';
		}
		
		return $widget .= ' readonly /></div>';
	}	
}