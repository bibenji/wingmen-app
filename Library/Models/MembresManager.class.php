<?php
namespace Library\Models;

use \Library\Entities\Membre;

abstract class MembresManager extends \Library\Manager
{
	/**
	* M�thode pour ajouter un membre
	* @return void
	*/
	abstract public function add(Membre $membre);
	
	/**
	* M�thode pour maj membre
	*/
	abstract public function updateMb(Membre $membre);
	
	/**
	* M�thode pour compter les membres inscripts
	*/
	abstract public function count();
	
	/**
	* M�thode pour supprimer un membre
	*/
	abstract public function delete(Membre $membre);
	
	/**
	* M�thode pour savoir si un membre existe d�j�
	*/
	abstract public function exists($info);
	
	/**
	* M�thode pour obtenir les infos sur un membre
	*/
	abstract public function get($info);
	
	/**
	* M�thode pour mettre � jour la derni�re date de connection
	*/
	abstract public function updateCon($id);		
	
	/**
	* M�thode pour obtenir la liste des membres
	*/
	abstract public function getList($pseudo, $like, $age);
	
	/**
	* M�thode pour enregistrer un nouveau membre	
	*/
	public function save(\Library\Entities\Membre $membre)
	{
		// Utilis� pour d�buguer :
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
	* M�thode pour enregistrer et maj l'avatar
	**/
	abstract public function updateAvatar($id, $avatar);
	
	/**
	* M�thode pour r�cup�rer tous les messages reli�s � un membre
	**/
	abstract public function getMess($membre_id);
	
	/**
	* M�thode pour r�cup�rer tous les messages reli�s � un membre
	**/
	abstract public function getAllMessWith($membre_id, $other_id);
	
	/**
	* M�thode pour obtenir la liste des events auxquels un membre est inscrit
	**/
	abstract public function getEvents($membre_id);
	
	/**
	* M�thode pour supprimer un membre
	*/
	abstract public function supprMembre($membre_id);
}