<?php
namespace Library\Models;

use \Library\Entities\Notif;

class NotifsManager_PDO extends NotifsManager
{
	public function sawNotifs($id_membre)
	{
		$q = $this->dao->query('UPDATE membres SET saw_notifs = NOW() WHERE id = '.$id_membre);
	}
	
	public function getAllNotifs($id_membre)
	{			
		$q = $this->dao->query('
			SELECT n.id_notif id_notif, n.id_event id_event, n.id_membre id_membre, n.date_notif date_notif, n.content_notif content_notif, m.saw_notifs saw_notifs, e.event_name event_name, n.type_notif type_notif
			FROM notifs_liste n, inscriptions i, membres m, events e
			WHERE i.id_inscrit = '.$id_membre.'
			AND i.id_event = n.id_event
			AND m.id = '.$id_membre.'
			AND (n.id_membre <> m.id OR n.id_membre IS NULL)
			AND i.date_inscription < n.date_notif
			AND n.id_event = e.id
			ORDER BY n.date_notif DESC
			LIMIT 0, 20
			');
				
		// $q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, new \Library\Entities\Notif);				
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Notif');		
		
		$donnees = array();
		while ($u = $q->fetch()) {
			$u->setDate_notif($u->date_notif());
			$u->setSaw_notifs($u->saw_notifs());
			$donnees[] = $u;			
		}
		
		return $donnees;
	}
	
	public function newNotif($id_event, $content, $type = null, $id_membre = null)
	{
		$q = $this->dao->prepare('INSERT INTO notifs_liste (id_event, content_notif, id_membre, type_notif) VALUES (:id_event, :content_notif, :id_membre, :type_notif)');		
		$q->bindValue(':id_event', $id_event, \PDO::PARAM_INT);
		$q->bindValue(':id_membre', $id_membre, \PDO::PARAM_INT);
		$q->bindValue(':content_notif', $content, \PDO::PARAM_STR);
		$q->bindValue(':type_notif', $type, \PDO::PARAM_STR);
		$q->execute();
	}
	
	public function getNumberNewNotifs($id_membre)
	{
		$q = $this->dao->query('
			SELECT COUNT(n.id_notif)
			FROM notifs_liste n, membres m, inscriptions i
			WHERE n.id_event = i.id_event
			AND i.id_inscrit = '.(int)$id_membre.'
			AND m.id = '.(int)$id_membre.'
			AND m.saw_notifs < n.date_notif
			AND (n.id_membre <> '.(int)$id_membre.' OR n.id_membre IS NULL)
			AND i.date_inscription < n.date_notif
		');
		return $q->fetchColumn();
	}
}