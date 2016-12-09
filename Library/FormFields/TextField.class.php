<?php
namespace Library\FormFields;

class TextField extends \Library\Field
{
	protected $cols, $rows;
	
	public function buildWidget()
	{
		$widget = '';
		
		if (!empty($this->errorMessage)) $class = ' has-error';
		else $class = '';
		
		$widget .= '<div class="form-group'.$class.'" id="'.$this->name.'" />';
		
		$widget .= '<label>'.$this->label.'</label> ';
		
		if (!empty($this->errorMessage)) {
			$widget .= $this->errorMessage.'<br />';
		}
		
		$widget .= '<textarea class="form-control" name="'.$this->name.'"';
		
		if (!empty($this->cols)) {
			$widget .= ' cols="'.$this->cols.'"';
		}
		
		if (!empty($this->rows)) {
			$widget .= ' rows="'.$this->rows.'"';
		}
		
		$widget .= '>';
		
		if (!empty($this->value)) {
			$widget .= htmlspecialchars($this->value);
		}
		
		return $widget.'</textarea></div>';
	}
	
	public function setCols($cols) {
		$cols = (int) $cols;
		
		if ($cols > 0) {
			$this->cols = $cols;
		}
	}
	
	public function setRows($rows) {
		$rows = (int) $rows;
		
		if ($rows > 0) {
			$this->rows = $rows;
		}
	}
}