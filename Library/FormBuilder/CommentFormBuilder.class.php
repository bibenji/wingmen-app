<?php
namespace Library\FormBuilder;

class CommentFormBuilder extends \Library\FormBuilder
{
	public function build()
	{			
		$this->form->add(new \Library\FormFields\TextField(array(
			'label' => 'Votre message :',
			'name' => 'com_text',
			'rows' => 7,
			'cols' => 50,
			'validators' => array(
				new \Library\FormFields\Validators\NotNullValidator('Vous n\'avez rien écrit ?'),
				))));
				
	}
}