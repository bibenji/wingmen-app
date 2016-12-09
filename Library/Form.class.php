<?php
namespace Library;

class Form
{
	protected $entity;
	protected $fields;

	public function __construct(\Library\Entity $entity) { $this->setEntity($entity);}
	
	public function add(\Library\Field $field)
	{
		
		$attr = $field->name(); // On récupère le nom du champ. exemple : com_creator
		
		$field->setValue($this->entity->$attr()); // On assigne la valeur correspondante au champ. // $this->entity contient $membre revient à faire $membre->mb_name() par ex
		// on fait la méthode de cette entity soit $this->entity->com_creator() pour avoir sa value
	
		$this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
		return $this;
	}
	
	public function createView()
	{
		$view = '';
		foreach ($this->fields as $field) // On génère un par un les champs du formulaire.
		{
			$view .= '<div class="form-group">'.$field->buildWidget().'</div>';
		}
		return $view;
	}
	
	public function isValid()
	{	
		$valid_form = true;
		// $valid = false;
		
		foreach ($this->fields as $field) // On vérifie que tous les champs sont valides.		
		{			
			if (!$field->isValid()) { /*echo 'doit afficher'; */$valid_form = false;}
		}
		
		return $valid_form;
	}
	
	public function entity() { return $this->entity;}
	public function setEntity(Entity $entity) { $this->entity = $entity;}
}