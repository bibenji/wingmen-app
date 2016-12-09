<?php
namespace Library\Models;

use \Library\Entities\Membre;

abstract class MembresManager extends \Library\Manager
{
	/**
	* Méthode pour ajouter un membre
	* @return void
	*/
	abstract public function add(Membre $membre);
	
	/**
	* Méthode pour maj membre
	*/
	abstract public function updateMb(Membre $membre);
	
	/**
	* Méthode pour compter les membres inscripts
	*/
	abstract public function count();
	
	/**
	* Méthode pour supprimer un membre
	*/
	abstract public function delete(Membre $membre);
	
	/**
	* Méthode pour savoir si un membre existe déjà
	*/
	abstract public function exists($info);
	
	/**
	* Méthode pour obtenir les infos sur un membre
	*/
	abstract public function get($info);
	
	/**
	* Méthode pour mettre à jour la dernière date de connection
	*/
	abstract public function updateCon($id);		
	
	/**
	* Méthode pour obtenir la liste des membres
	*/
	abstract public function getList($pseudo, $like, $age);
	
	/**
	* Méthode pour enregistrer un nouveau membre	
	*/
	public function save(\Library\Entities\Membre $membre)
	{
		// Utilisé pour débuguer :
		// var_dump($membre);
		// echo $membre->mb_id();
		// echo $this->exists($membre->mb_id());
		
		if ($this->exists($membre->mb_id())) {			
			return $this->updateMb($membre);
		}
		else {					
			if ($this->exists($membre->mb_name())) {
				return false;
			}
			else {			
				return $this->add($membre);				
			}
		}
	}
	
	/**
	* Méthode pour enregistrer et maj l'avatar
	**/
	abstract public function updateAvatar($id, $avatar);
	
	/**
	* Méthode pour récupérer tous les messages reliés à un membre
	**/
	abstract public function getMess($membre_id);
	
	/**
	* Méthode pour récupérer tous les messages reliés à un membre
	**/
	abstract public function getAllMessWith($membre_id, $other_id);
	
	/**
	* Méthode pour obtenir la liste des events auxquels un membre est inscrit
	**/
	abstract public function getEvents($membre_id);
	
	/**
	* Méthode pour supprimer un membre
	*/
	abstract public function supprMembre($membre_id);
}