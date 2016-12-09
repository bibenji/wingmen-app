<?php
namespace Library\Models;

use \Library\Entities\Event;

abstract class EventsManager extends \Library\Manager
{
	/**
	* Méthode permettant de modifier un event.
	* @param $event event l'event à modifier
	* @return void
	*/
	abstract protected function modify(\Library\Entities\Event $event);
	
	/**
	* Méthode permettant d'ajouter un event.
	* @param $event Event L'event à ajouter
	* @return void
	*/
	abstract protected function add(\Library\Entities\Event $event);

	/**
	* Méthode renvoyant le nombre d'events total.
	* @return int
	*/
	abstract public function countEvents();
	
	/**
	* Méthode renvoyant le nombre d'events passés total.
	* @return int
	*/
	abstract public function countPastEvents();
	
	/**
	* Méthode permettant de supprimer un event.
	* @param $id int L'identifiant de l'event à supprimer
	* @return void
	*/
	abstract public function delete($id);
		
	/**
	* Méthode retournant un event précis.
	* @param $id int L'identifiant de l'event à récupérer
	* @return Event L'event demandée
	*/
	abstract public function getUnique($id);

	/**
	* Méthode permettant d'enregistrer un event.
	* @param $event Event l'event à enregistrer
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
			throw new RuntimeException('L\'event doit être valide pour être enregistré');
		}
	}
	
	/**
	* Méthode pour avoir le nom du prochain event auquel un membre est inscrit
	*/
	abstract public function getNextEvent($mb_id);
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// FONCTIONS POUR RECUPERER PLUSIEURS EVENEMENTS //
		
	/**
	* Méthode retournant une liste d'events demandée.
	* @param $debut int Le premier event à sélectionner
	* @param $limite int Le nombre d'events à sélectionner
	* @return array La liste des events. Chaque entrée est une instance de Event.
	*/
	abstract public function getList($debut = -1, $limite = -1, $past = null);
	
	/**
	* Méthode pour avoir les 5 derniers événements créés par un membre
	*/
	abstract public function getCreatedEvents($membre_id, $past = null);
	
	/**
	* Méthode pour obtenir la liste des events auxquels un membre est inscrit
	**/
	abstract public function getEvents($membre_id, $past = null);
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// GESTION DES INSCRIPTIONS //
	
	/**
	* Fonction pour inscrire un membre
	**/
	abstract public function inscrire($mb_id);
	
	/**
	* Fonction pour vérifier si maximum d'inscrits atteint
	**/
	abstract protected function hasMaxInscrits($id_event);
	
	/**
	* Foncton pré-inscription d'un membre
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
	* Fonction pour désinscrire un membre
	**/
	abstract public function desinscrire($event, $membre);
		
	/**
	* Fonction pour avoir la liste des inscrits à un événement
	**/
	abstract public function getInscrits($event_id);
	
	/**
	* Fonction pour savoir si un membre est inscrit à un événement
	**/
	abstract public function estInscrit($user, $event_id);
	
}