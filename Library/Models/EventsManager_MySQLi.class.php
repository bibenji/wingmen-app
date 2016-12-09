<?php
class EventsManager_MySQLi extends EventsManager
{
	/**
	* Attribut contenant l'instance représentant la BDD.
	* @type MySQLi
	*/
	protected $db;
	
	/**
	* Constructeur étant chargé d'enregistrer l'instance de MySQLi dans l'attribut $db.
	* @param $db MySQLi Le DAO
	* @return void
	*/
	public function __construct(MySQLi $db)
	{
		$this->db = $db;
	}

	/**
	* @see EventsManager::add()
	*/
	protected function add(Event $event)
	{
		$vars = array($event->creator(), $event->event_name(), $event->event_description());
		$requete = $this->db->prepare('INSERT INTO events SET creator = ?,
			event_name = ?, event_description = ?, dateAjout = NOW(), dateModif = NOW()');
		$requete->bind_param(
			'sss',
			$vars[0],
			$vars[1],
			$vars[2]
			);
		$requete->execute();
	}
	
	/**
	* @see EventsManager::count()
	*/
	public function count()
	{
		return $this->db->query('SELECT id FROM events')->num_rows;
	}
	
	/**
	* @see EventsManager::delete()
	*/
	public function delete($id)
	{
		$id = (int) $id;
		$requete = $this->db->prepare('DELETE FROM events WHERE id = ?');
		$requete->bind_param('i', $id);
		$requete->execute();
	}
	
	/**
	* @see EventsManager::getList()
	*/
	public function getList($debut = -1, $limite = -1)
	{
		$listeEvents = array();
		$sql = 'SELECT id, creator, event_name, event_description,
			DATE_FORMAT(dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout,
			DATE_FORMAT(dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif
			FROM events ORDER BY id DESC';
		// On vérifie l'intégrité des paramètres fournis.
		if ($debut != -1 || $limite != -1)
		{
			$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
		$requete = $this->db->query($sql);
		while ($event = $requete->fetch_object('Event'))
		{
			$listeEvents[] = $event;
		}
		return $listeEvents;
	}
	
	/**
	* @see EventsManager::getUnique()
	*/
	public function getUnique($id)
	{
		$id = (int) $id;
		$requete = $this->db->prepare('SELECT id, creator, event_name, event_description,
			DATE_FORMAT (dateAjout, \'le %d/%m/%Y à %Hh%i\') AS dateAjout,
			DATE_FORMAT (dateModif, \'le %d/%m/%Y à %Hh%i\') AS dateModif
			FROM events WHERE id = ?');
		$requete->bind_param('i', $id);
		$requete->execute();
		$requete->bind_result($id, $creator, $event_name, $event_description, $dateAjout, $dateModif);
		$requete->fetch();
		return new Event(array(
			'id' => $id,
			'creator' => $creator,
			'event_name' => $event_name,
			'event_description' => $event_description,
			'dateAjout' => $dateAjout,
			'dateModif' => $dateModif
			));
	}

	/**
	* @see EventsManager::update()
	*/
	protected function update(Event $event)
	{
		$vars = array($event->creator(), $event->event_name(), $event->event_description(), $event->id());
		$requete = $this->db->prepare('UPDATE events SET creator = ?,
			event_name = ?, event_description = ?,
			dateModif = NOW() WHERE id = ?');
		//$requete->bind_param('sssi', $event->creator(), $event->event_name(), $event->event_description(), $event->id());
		$requete->bind_param('sssi', $vars[0], $vars[1], $vars[2], $vars[3]);
		$requete->execute();
	}
}