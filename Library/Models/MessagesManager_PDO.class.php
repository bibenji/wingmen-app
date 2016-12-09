<?php
namespace Library\Models;

use \Library\Entities\Message;

class MessagesManager_PDO extends MessagesManager
{
	public function getConvOf($id_membre)
	{
		$q = $this->dao->prepare('SELECT id_conv FROM participe WHERE id_membre = :id_membre');
		$q->bindValue(':id_membre', $id_membre, \PDO::PARAM_INT);

		$q->execute();
		return $q->fetchAll();		
	}
	
	protected function getConvBetween($mb1_id, $mb2_id) {
		$q = $this->dao->query('
			SELECT p1.id_conv id_conv
			FROM participe p1, participe p2
			WHERE p1.id_membre = '.(int) $mb1_id.'
			AND p2.id_membre = '.(int) $mb2_id.'
			AND p1.id_conv = p2.id_conv');		
		return $q->fetchAll();
	}
	
	public function getOthersInConv($id_conv, $mb_id)
	{
		$q = $this->dao->query('
			SELECT m.id id, m.pseudo pseudo, m.mb_avatar mb_avatar
			FROM participe p, membres m
			WHERE p.id_conv = '.(int) $id_conv.'
			AND p.id_membre <> '.(int) $mb_id.'
			AND p.id_membre = m.id
			');
		return $q->fetchAll();
	}
		
	public function newMess(Message $message)
	{		
		$q = $this->dao->prepare('INSERT INTO messages SET mess_from = :mess_from, mess_to = :mess_to, mess_date = NOW(), mess_text = :mess_text, id_conv = :id_conv');
		$q->bindValue(':mess_from', $message->mess_from());
		$q->bindValue(':mess_to', $message->mess_to());
		$q->bindValue(':mess_text', $message->mess_text());
		$q->bindValue(':id_conv', $message->id_conv());
		return $q->execute();		
	}
	
	public function createConv(Message $message)
	{
		$this->dao->query('INSERT INTO conversations SET date_crea = NOW()');
		return $this->dao->lastInsertId();
	}
	
	public function getAllMessInConv($id_conv) {		
		$q = $this->dao->query('
			SELECT ms.mess_from mess_from, mb1.pseudo mess_from_pseudo, mb1.mb_avatar mess_from_avatar, ms.mess_date mess_date, ms.mess_text mess_text
			FROM messages ms, membres mb1
			WHERE ms.id_conv = '.(int) $id_conv.'
			AND ms.mess_from = mb1.id
			ORDER BY ms.mess_id
			');		
		
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Message');
		$mess = $q->fetchAll(\PDO::FETCH_OBJ);
		return $mess;
	}
	
	public function updateTracking($id_membre, $id_conv) {
		$q1 = $this->dao->query('SELECT * FROM participe WHERE id_membre = '.(int)$id_membre.' AND id_conv = '.(int)$id_conv);
		
		if (!$q1->fetchColumn()) return false;
		else {
			$q2 = $this->dao->prepare('
			UPDATE participe SET tracking = NOW() WHERE id_membre = :id_membre AND id_conv = :id_conv;
			SELECT ROW_COUNT();
			');		
			$q2->bindValue(':id_membre', $id_membre, \PDO::PARAM_INT);
			$q2->bindValue(':id_conv', $id_conv, \PDO::PARAM_INT);
			
			return $q2->execute();
		}
	}
	
	public function getMess($membre_id) {
		$q = $this->dao->query('
			SELECT test.id_conv id_conv, test.participants participants, test.avatars avatars, mess.mess_from mess_from_id, mb2.pseudo mess_from, mess.mess_date mess_date, mess.mess_text mess_text, par.tracking lasttrack
				FROM
				(
				SELECT id_conv, GROUP_CONCAT(pseudo SEPARATOR ", ") participants, GROUP_CONCAT(mb_avatar SEPARATOR ", ") avatars
				FROM participe, membres
				WHERE id_conv IN (
					SELECT id_conv
					FROM participe
					WHERE id_membre = '.(int) $membre_id.'
					)
				AND id = id_membre
				AND id <> '.(int) $membre_id.'
				GROUP BY id_conv
				) as test, messages mess, membres mb2, participe par
				WHERE test.id_conv = mess.id_conv
				AND par.id_conv = test.id_conv
				AND par.id_membre = '.(int) $membre_id.'
				AND mess.mess_id IN (
					SELECT MAX(mess_id)
					FROM messages
					GROUP BY id_conv
				)
				AND mb2.id = mess.mess_from
				ORDER BY mess.mess_date DESC
			');
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Message');
		$mess = $q->fetchAll(\PDO::FETCH_OBJ);
		return $mess;		
	}
	
	public function getNumberNewMess($id_membre)
	{
		$q = $this->dao->query('
			SELECT COUNT(*)
			FROM (
			SELECT MAX(mess_date) last_mess_date, id_conv FROM messages
			WHERE id_conv IN
			(
				SELECT id_conv FROM participe WHERE id_membre = '.$id_membre.'
			)
			GROUP BY id_conv
			) q, participe p
			WHERE id_membre = '.$id_membre.'
			AND q.id_conv = p.id_conv
			AND q.last_mess_date > p.tracking
			');
		return $q->fetchColumn();
	}
	
	public function addMembre($id_conv, $id_membre, $tracking) // fonctionnalité encore à implémenter
	{		
		$q = $this->dao->prepare('INSERT INTO participe SET id_conv = :id_conv, id_membre = :id_membre, tracking = :tracking');
		
		$q->bindValue(':id_conv', $id_conv);
		$q->bindValue(':id_membre', $id_membre);
		$q->bindValue(':tracking', $tracking);
		
		$q->execute();
	}	
}