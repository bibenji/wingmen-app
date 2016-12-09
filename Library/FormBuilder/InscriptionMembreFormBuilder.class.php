<?php
namespace Library\FormBuilder;

class InscriptionMembreFormBuilder extends \Library\FormBuilder
{
	public function build()
	{
		$this->form->add(new \Library\FormFields\StringField(array(
			'label' => 'Choisissez un pseudo :',
			'name' => 'mb_name',
			'maxLength' => 30,
			'placeHolder' => 'PSEUDO',
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Le pseudo choisi est trop long (30 caractères maximum)', 30),
				new \Library\FormFields\Validators\NotNullValidator('Merci de spécifier un pseudo')
				))))		
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Choisissez un mot de passe :',
			'name' => 'mb_mdp',
			'maxLength' => 30,
			'placeHolder' => 'PASSWORD',
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Le mot de passe spécifié est trop long (50 caractères maximum)', 50),
				new \Library\FormFields\Validators\NotNullValidator('Merci de spécifier un mot de passe')
				))))
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Entrez votre adresse mail :',
			'name' => 'mb_email',
			'maxLength' => 30,
			'placeHolder' => 'E-MAIL',
			'validators' => array(
				new \Library\FormFields\Validators\EmailValidator('L\'email spécifié n\'est pas au bon format'),
				new \Library\FormFields\Validators\NotNullValidator('Merci de spécifier une adresse mail')
				))));
	}
}