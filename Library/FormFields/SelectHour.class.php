<?php
namespace Library\FormFields;

class SelectHour extends \Library\Field
{	
	public function buildWidget()
	{
		$widget = '';
		
		if (!empty($this->errorMessage)) {
			$widget .= $this->errorMessage.'<br />';
		}
		
		$widget .= '<label>'.$this->label.'</label><select class="form-control" name="'.$this->name.'">';
		
		if (!empty($this->value)) $selected = $this->value;
		else $selected = '12:00:00';
	
		
		for ($i = 0; $i < 24; $i++) {
			if ($i < 10) $h = '0'.$i;
			else $h = $i;
			for ($j = 0; $j < 60; $j = $j + 30) {				
				if ($j == 0) $m = '00';
				else $m = $j;
				$hour = $h.':'.$m;
				if ($hour.':00' == $selected) $sel = 'selected="selected"';
				else $sel = '';
				$widget .= '<option value="'.$hour.':00" '.$sel.'">'.$hour.'</option>';
			}
		}
		
		$widget .= '</select>';
		
		return $widget;
	}	
}