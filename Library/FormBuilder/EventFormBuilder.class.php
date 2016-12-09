<?php
namespace Library\FormBuilder;

class EventFormBuilder extends \Library\FormBuilder
{
	public function build()
	{
		$this->form->add(new \Library\FormFields\StringField(array(
			'label' => 'Date de l\'événement (exemple : 01/12/2016) :',
			'name' => 'event_day',
			'maxLength' => 10,
			'validators' => array(
				// new \Library\FormFields\Validators\MaxLengthValidator('Assurez-vous que la date saisie soit dans le bon format (exemple : 03/12/2016)', 10),
				new \Library\FormFields\Validators\DateValidator('La date n\'est pas dans un format correct'),
				new \Library\FormFields\Validators\NotNullValidator('Ce champ n\'a pas été rempli !')
				))))
		->add(new \Library\FormFields\SelectField(array(
			'label' => 'Type d\'événement :',
			'name' => 'event_type',
			'listOptions' => array("NPU", "PPU", "SPU"),
			'validators' => array(
				// new \Library\MaxLengthValidator('...', 1)
				))))
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Nom de l\'événement :',
			'name' => 'event_name',
			'maxLength' => 100,
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Le nom spécifié est trop long (100 caractères maximum)', 100),
				new \Library\FormFields\Validators\NotNullValidator('Ce champ n\'a pas été rempli !')
				))))
				
		->add(new \Library\FormFields\TextField(array(
			'label' => 'Description de l\'événement :',
			'name' => 'event_description',
			'rows' => 8,
			'cols' => 60,
			'validators' => array(
				new \Library\FormFields\Validators\NotNullValidator('Ce champ n\'a pas été rempli !')
			))))
		/*
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Lieu du rendez-vous :',
			'name' => 'event_lieu',
			'maxLength' => 100,
			'validators' => array(				
				new \Library\FormFields\Validators\NotNullValidator('Ce champ n\'a pas été rempli !')
				))))
		*/
		->add(new \Library\FormFields\AddressField(array(
			'label' => 'Lieu du rendez-vous :',
			'name' => 'event_lieu',
			'maxLength' => 30,
			'validators' => array(
				// new \Library\MaxLengthValidator('L\'email spécifié est trop long (30 caractères maximum)', 30)
				))))
		->add(new \Library\FormFields\CoordosField(array(			
			'label' => '',
			'name' => 'event_coordos',			
			'validators' => array(				
				))))
		->add(new \Library\FormFields\SelectHour(array(
			'label' => 'Heure du rendez-vous :',
			'name' => 'event_hour',			
			'validators' => array(
				// new \Library\MaxLengthValidator('...', 1)
				))))
		->add(new \Library\FormFields\StringField(array(
			'label' => 'Maximum de participants (en chiffres) :',
			'name' => 'event_max',
			'maxLength' => 30,
			'validators' => array(
				new \Library\FormFields\Validators\MaxLengthValidator('Plus de 100 personnes, vous êtes sûr ?', 2),
				new \Library\FormFields\Validators\NotNullValidator('Ce champ n\'a pas été rempli !')
				))));
	}
}