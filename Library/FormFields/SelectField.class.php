<?php
namespace Library\FormFields;

class SelectField extends \Library\Field
{	
	protected $listOptions;

	public function buildWidget()
	{
		$widget = '';
		if (!empty($this->errorMessage))
		{
			$widget .= $this->errorMessage.'<br />';
		}
		$widget .= '<div class="form-group" id="'.$this->name.'" /><label>'.$this->label.'</label><select class="form-control" name="'.$this->name.'">';
		
		if (!empty($this->listOptions))
		{
			foreach ($this->listOptions as $option)
			{
				if (!empty($this->value) AND $this->value == $option) {
					$selected = 'selected="selected"';
				} else {
					$selected = '';
				}
				$widget .= '<option '.$selected.'>'.$option.'</option>';
			}		
		}
		
		return $widget .= '</select></div>';		
	}
		
	public function setListOptions($listOptions)
	{
		if (is_array($listOptions)) {
			$this->listOptions = $listOptions;
		}
		else {
			throw new \RuntimeException('Les options doivent être passées sous la forme d\'un tableau');
		}		
	}	
}