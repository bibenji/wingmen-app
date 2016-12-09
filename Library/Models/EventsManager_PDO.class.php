<?php
namespace Library\Models;

use \Library\Entities\Event;

class EventsManager_PDO extends EventsManager
{
	protected function modify(\Library\Entities\Event $event)
	{		
		$requete = $this->dao->prepare('UPDATE events
			SET creator = :creator, event_date = :event_date,
			event_name = :event_name, event_description = :event_description,
			event_lieu = :event_lieu, event_coordos = :event_coordos,
			event_max = :event_max,
			dateModif = NOW(), event_type = :event_type
			WHERE id = :id');
		
		$requete->bindValue(':creator', $event->creator());		
		$requete->bindValue(':event_date', $event->event_date());		
		$requete->bindValue(':event_name', $event->event_name());
		$requete->bindValue(':event_description', $event->event_description());
		$requete->bindValue(':event_lieu', $event->event_lieu());
		$requete->bindValue(':event_coordos', $event->event_coordos());
		$requete->bindValue(':event_max', $event->event_max());
		$requete->bindValue(':event_type', $event->event_type());
		$requete->bindValue(':id', $event->id(), \PDO::PARAM_INT);
		
		$requete->execute();
	}
		
	/**
	* @see EventsManager::add()
	*/
	protected function add(\Library\Entities\Event $event)
	{
		$requete = $this->dao->prepare('INSERT INTO events
			SET creator = :creator, event_date = :event_date,
			event_name = :event_name, event_description = :event_description,
			event_lieu = :event_lieu, event_coordos = :event_coordos,
			event_max = :event_max,
			dateAjout = NOW(), dateModif = NOW(),
			event_type = :event_type');
			
		$requete->bindValue(':creator', $event->creator());
		$requete->bindValue(':event_date', $event->event_date());
		$requete->bindValue(':event_name', $event->event_name());
		$requete->bindValue(':event_description', $event->event_description());
		$requete->bindValue(':event_lieu', $event->event_lieu());
		$requete->bindValue(':event_coordos', $event->event_coordos());
		$requete->bindValue(':event_max', $event->event_max());
		$requete->bindValue(':event_type', $event->event_type());
		
		$requete->execute();
				
		$this->inscrire($event->creator()); // utilisation de last insert id		
	}
	
	/**
	* @see EventsManager::count()
	*/
	public function countEvents()
	{
		return $this->dao->query('SELECT COUNT(*) FROM events WHERE del <> 1 AND event_date >= NOW()')->fetchColumn();
	}
	
	/**
	* @see EventsManager::count()
	*/
	public function countPastEvents()
	{
		return $this->dao->query('SELECT COUNT(*) FROM events WHERE del <> 1 AND event_date < NOW()')->fetchColumn();
	}
	
	/**
	* @see EventsManager::delete()
	*/
	public function delete($id)
	{
		return $this->dao->exec('UPDATE events SET del = 1 WHERE id = '.(int) $id);
		// $this->dao->exec('DELETE FROM events WHERE id = '.(int) $id);
		// $this->dao->exec('DELETE FROM inscriptions WHERE id_event = '.(int) $id);
	}
	
	/**
	* @see EventsManager::getUnique()
	*/
	public function getUnique($id)
	{
		$requete = $this->dao->prepare('
			SELECT e.id, creator, pseudo, mb_avatar avatar, event_date, event_name, event_description, event_lieu, event_coordos, event_max, event_type, dateAjout, dateModif
			FROM events e, membres m
			WHERE e.id = :id AND e.creator = m.id');
			
		$requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		
		$requete->execute();
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Event');
		
		if ($event = $requete->fetch())
		{			
			$event->setEvent_date($event->event_date());			
			$event->setDateAjout(new \DateTime($event->dateAjout()));
			$event->setDateModif(new \DateTime($event->dateModif()));
			return $event;
		}
		return null;
	}
	
	/**
	* @see EventsManager::getNextEvent()
	*/
	public function getNextEvent($mb_id)
	{
		$q = $this->dao->query('
			SELECT e.id id, MAX(e.event_date) event_date, e.event_name event_name, e.event_lieu event_lieu
			FROM inscriptions i, events e
			WHERE i.id_inscrit = '.(int)$mb_id.'
			AND i.id_event = e.id
			AND e.del <> 1
			AND e.event_date >= NOW()
		');
		$nextEvent = $q->fetch();
		$nextEvent['event_date'] = new \Library\Entities\OneDate($nextEvent['event_date']);
		return $nextEvent;
	}
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// FONCTIONS POUR RECUPERER PLUSIEURS EVENEMENTS //
	
	private function getPastVars($past) {
		if ($past) {
			return array(
				'past' => 'AND e.event_date < NOW()',
				'order' => 'ORDER BY event_date DESC'
			);
		} else {
			return array (				
				'past' => 'AND e.event_date >= NOW()',
				'order' => 'ORDER BY event_date ASC'			
			);
		}		
	}
		
	/**
	* @see EventsManager::getList()
	*/
	public function getList($debut = -1, $limite = -1, $past = null)
	{		
		$inject = $this->getPastVars($past);
		
		$sql = 'SELECT e.id, event_date, creator, pseudo, event_name, event_description, event_lieu, event_max, event_type, dateAjout, dateModif, COUNT(i.id_inscrit) inscrits
				FROM events e, membres m, inscriptions i
				WHERE e.creator = m.id
				AND e.id = i.id_event
				AND e.del <> 1
				'.$inject['past'].'
				GROUP BY e.id
				'.$inject['order'];
					
		// On vérifie l'intégrité des paramètres fournis.
		if ($debut != -1 || $limite != -1) {
			$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
		
		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Event');
		$listeEvents = $requete->fetchAll();
		
		foreach ($listeEvents as $event) // transformation des résultats en DateTime
		{
			$event->setDateAjout(new \DateTime($event->dateAjout()));
			$event->setDateModif(new \DateTime($event->dateModif()));
			
			$event->setEvent_time($event->event_date()); // création d'un objet OneDate
		}
		
		$requete->closeCursor();
		return $listeEvents;
	}
	
	public function getEvents($membre_id, $past = null)
	{	
		$inject = $this->getPastVars($past);
		
		$sql = 'SELECT e.id id, e.event_date date, e.event_name name, e.event_lieu lieu
			FROM events e, inscriptions i
			WHERE e.id = i.id_event
			AND e.creator != '.(int) $membre_id.'
			AND i.id_inscrit = '.(int) $membre_id.'
			'.$inject['past'].'
			'.$inject['order'];
		
		$q = $this->dao->query($sql);
		
		$results = array();
		
		while ($result = $q->fetch()) {
			$result['date'] = new \Library\Entities\OneDate($result['date']);			
			$results[] = $result;
		}
		
		return $results;
	}
	
	public function getCreatedEvents($membre_id, $past = null)
	{
		$inject = $this->getPastVars($past);
		
		$sql = 'SELECT e.id id, e.event_date date, e.event_name name, e.event_lieu lieu
			FROM events e
			WHERE e.del <> 1
			AND e.creator = '.(int) $membre_id.'
			'.$inject['past'].'
			'.$inject['order'];
			
		$q = $this->dao->query($sql);
			
		$results = array();
		
		while ($result = $q->fetch()) {
			$result['date'] = new \Library\Entities\OneDate($result['date']);			
			$results[] = $result;
		}
		
		return $results;		
	}
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////
	// GESTION DES INSCRIPTIONS //
	
	public function inscrire($mb_id) // requete appelée lors de la création d'un nouvel événement
	{
		$requete = $this->dao->prepare('INSERT INTO inscriptions SET id_event = LAST_INSERT_ID(), id_inscrit = :id_inscrit');
		$requete->bindValue(':id_inscrit', $mb_id, \PDO::PARAM_INT);
		$requete->execute();
	}
	
	protected function hasMaxInscrits($id_event) {
		$requete = $this->dao->prepare('
			SELECT (COUNT(i.id_inscrit) >= event_max)
			FROM inscriptions i, events e
			WHERE i.id_event = :id_event
			AND i.id_event = e.id'
			);
		$requete->bindValue(':id_event', $id_event, \PDO::PARAM_INT);
		$requete->execute();
		return $requete->fetchColumn();
	}
	
	protected function inscriretruetrue($event, $membre)
	{
		$requete = $this->dao->prepare('INSERT INTO inscriptions SET id_event = :id_event, id_inscrit = :id_inscrit');
		$requete->bindValue(':id_event', $event, \PDO::PARAM_INT);
		$requete->bindValue(':id_inscrit', $membre, \PDO::PARAM_INT);
		return $requete->execute();
	}
	
	public function desinscrire($event, $membre)
	{
		$requete = $this->dao->prepare('DELETE FROM inscriptions WHERE id_event = :id_event AND id_inscrit = :id_inscrit');
		$requete->bindValue(':id_event', $event, \PDO::PARAM_INT);
		$requete->bindValue(':id_inscrit', $membre, \PDO::PARAM_INT);
		return $requete->execute();
	}
	
	public function getInscrits($event_id)
	{
		$requete = $this->dao->prepare('SELECT m.pseudo pseudo, m.mb_avatar avatar, i.id_inscrit id FROM membres m, inscriptions i WHERE i.id_inscrit = m.id AND i.id_event = :id_event');
		$requete->bindValue(':id_event', $event_id, \PDO::PARAM_INT);
		$requete->execute();
		// $requete->setFetchMode(\PDO::FETCH_ASSOC);
		return $requete->fetchAll();
	}
	
	public function estInscrit($user, $event_id)
	{		
		$q = $this->dao->prepare('SELECT COUNT(*) FROM inscriptions WHERE id_event = :id_event AND id_inscrit = :id_inscrit');
		$q->execute(array(':id_event' => $event_id, ':id_inscrit' => $user));
		return (bool) $q->fetchColumn();	
	}		
}