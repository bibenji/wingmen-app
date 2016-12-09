<?php
namespace Library\Models;

use \Library\Entities\Event;

abstract class EventsManager extends \Library\Manager
{
	/**
	* M�thode permettant de modifier un event.
	* @param $event event l'event � modifier
	* @return void
	*/
	abstract protected function modify(\Library\Entities\Event $event);
	
	/**
	* M�thode permettant d'ajouter un event.
	* @param $event Event L'event � ajouter
	* @return void
	*/
	abstract protected function add(\Library\Entities\Event $event);

	/**
	* M�thode renvoyant le nombre d'events total.
	* @return int
	*/
	abstract public function countEvents();
	
	/**
	* M�thode renvoyant le nombre d'events pass�s total.
	* @return int
	*/
	abstract public function countPastEvents();
	
	/**
	* M�thode permettant de supprimer un event.
	* @param $id int L'identifiant de l'event � supprimer
	* @return void
	*/
	abstract public function delete($id);
		
	/**
	* M�thode retournant un event pr�cis.
	* @param $id int L'identifiant de l'event � r�cup�rer
	* @return Event L'event demand�e
	*/
	abstract public function getUnique($id);

	/**
	* M�thode permettant d'enregistrer un event.
	* @param $event Event l'event � enregistrer
	* @see self::add()
	* @see self::modify()
	* @return bool
	*/
	public function save(\Library\Entities\Event $event)
	{		
		if ($event->isValid())
		{
			$event->isNew() ? $this->add($event) : $this->modify($event);
			return true;
		}
		else
		{
			throw new RuntimeException('L\'event doit �tre valide pour �tre enregistr�');
		}
	}
	
	/**
	* M�thode pour avoir le nom du prochain event auquel un membre est inscrit
	*/
	abstract public function getNextEvent($mb_id);
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// FONCTIONS POUR RECUPERER PLUSIEURS EVENEMENTS //
		
	/**
	* M�thode retournant une liste d'events demand�e.
	* @param $debut int Le premier event � s�lectionner
	* @param $limite int Le nombre d'events � s�lectionner
	* @return array La liste des events. Chaque entr�e est une instance de Event.
	*/
	abstract public function getList($debut = -1, $limite = -1, $past = null);
	
	/**
	* M�thode pour avoir les 5 derniers �v�nements cr��s par un membre
	*/
	abstract public function getCreatedEvents($membre_id, $past = null);
	
	/**
	* M�thode pour obtenir la liste des events auxquels un membre est inscrit
	**/
	abstract public function getEvents($membre_id, $past = null);
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// GESTION DES INSCRIPTIONS //
	
	/**
	* Fonction pour inscrire un membre
	**/
	abstract public function inscrire($mb_id);
	
	/**
	* Fonction pour v�rifier si maximum d'inscrits atteint
	**/
	abstract protected function hasMaxInscrits($id_event);
	
	/**
	* Foncton pr�-inscription d'un membre
	**/
	public function inscriretrue($event, $membre)
	{
		
		// echo $event, $this->hasMaxInscrits($event);
				
		if ($this->hasMaxInscrits($event)) {
			return false;
		}
		else {
			return $this->inscriretruetrue($event, $membre);
		}
		
	}
	
	/**
	* Fonction pour inscrire un membre
	**/
	abstract protected function inscriretruetrue($event, $membre);
	
	/**
	* Fonction pour d�sinscrire un membre
	**/
	abstract public function desinscrire($event, $membre);
		
	/**
	* Fonction pour avoir la liste des inscrits � un �v�nement
	**/
	abstract public function getInscrits($event_id);
	
	/**
	* Fonction pour savoir si un membre est inscrit � un �v�nement
	**/
	abstract public function estInscrit($user, $event_id);
	
}