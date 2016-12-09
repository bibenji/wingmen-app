<?php
namespace Library\FormBuilder;

class MembreFormBuilder extends \Library\FormBuilder
{
	public function build()
	{
		$this->form->add(new \Library\FormFields\FileField(array(
			'label' => 'Votre photo de profil :',
			'name' => 'mb_avatar',			
			'validators' => array(
				))))
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Votre identifiant / pseudo :',
			'name' => 'mb_name',
			'maxLength' => 30,
			'placeHolder' => 'PSEUDO',
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Le pseudo spécifié est trop long (30 caractères maximum)', 30),
				new \Library\FormFields\Validators\NotNullValidator('Merci de spécifier un pseudo')
				))))		
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Votre mot de passe',
			'name' => 'mb_mdp',
			'maxLength' => 30,
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Le mot de passe spécifié est trop long (30 caractères maximum)', 30),
				new \Library\FormFields\Validators\NotNullValidator('Merci de spécifier un mot de passe')
				))))
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Votre adresse mail :',
			'name' => 'mb_email',
			'maxLength' => 30,
			'placeHolder' => 'E-MAIL',
			'validators' => array(
				new \Library\FormFields\Validators\EmailValidator('L\'email spécifié n\'est pas au bon format'),
				new \Library\FormFields\Validators\NotNullValidator('Merci de spécifier une adresse mail')				
				))))
		->add(new \Library\FormFields\SelectField(array(
			'label' => 'Votre sexe :',
			'name' => 'mb_sexe',
			'listOptions' => array("M", "F"),
			'validators' => array(
				// new \Library\MaxLengthValidator('...', 1)
				))))
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Votre date de naissance :',
			'name' => 'mb_age',
			'maxLength' => 10,
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Votre âge est trop grand...', 10)
				))))
		->add(new \Library\FormFields\AddressField(array(
			'label' => 'Votre adresse (nécessaire pour la localisation) :',
			'name' => 'mb_adresse',
			'maxLength' => 30,
			'validators' => array(
				// new \Library\MaxLengthValidator('L\'email spécifié est trop long (30 caractères maximum)', 30)
				))))
		->add(new \Library\FormFields\CoordosField(array(			
			'label' => '',
			'name' => 'mb_coordos',			
			'validators' => array(				
				))))
		->add(new \Library\FormFields\TextareaField(array(
			'label' => 'Un mot pour vous présenter aux autres membres (max. 200) :',
			'name' => 'mb_descri',
			// 'maxLength' => 30,
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Votre description est trop longue', 200)
				))));
	}
}