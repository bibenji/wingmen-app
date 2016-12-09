<?php
namespace Library\FormBuilder;

class NewMess extends \Library\FormBuilder
{
	public function build()
	{
		$this->form->add(new \Library\FormFields\TextField(array(
			'label' => 'Votre message : ',
			'name' => 'mess_text',
			'rows' => 7,
			'cols' => 50,
			'validators' => array(
				new \Library\FormFields\Validators\NotNullValidator('Vous n\'avez saisi aucun message !'),
				))));				
	}
}