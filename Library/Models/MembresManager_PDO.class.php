<?php
namespace Library\Models;

use \Library\Entities\Membre;

class MembresManager_PDO extends MembresManager
{	
	public function add(Membre $membre)
	{
		$q = $this->dao->prepare('INSERT INTO membres SET pseudo = :pseudo, mdp = :mdp, email = :email');
		$q->bindValue(':pseudo', $membre->mb_name());
		$q->bindValue(':mdp', $membre->mb_mdp());
		$q->bindValue(':email', $membre->mb_email());		
		$q->execute();
		return $this->dao->lastInsertId();
	}
	
	public function updateMb(Membre $membre)
	{		
		$q = $this->dao->prepare('UPDATE membres SET pseudo = :pseudo, mdp = :mdp, email = :email, sexe = :sexe, age = :age, adresse = :adresse, coordos = :coordos, description = :description WHERE id = :id');		
		$q->bindValue(':id', $membre->mb_id(), \PDO::PARAM_INT);
		$q->bindValue(':pseudo', $membre->mb_name());		
		$q->bindValue(':mdp', $membre->mb_mdp());		
		$q->bindValue(':email', $membre->mb_email());		
		$q->bindValue(':sexe', $membre->mb_sexe());		
		$q->bindValue(':age', $membre->mb_datenaissance());		
		$q->bindValue(':adresse', $membre->mb_adresse());
		$q->bindValue(':coordos', $membre->mb_coordos());
		$q->bindValue(':description', $membre->mb_descri());		
		$q->execute();		
		return $membre->mb_id();
	}	
	 
	
	public function updateAvatar($id, $avatar)
	{
		$q = $this->dao->prepare('UPDATE membres SET mb_avatar = :mb_avatar WHERE id = :id');
		$q->bindValue(':mb_avatar', $avatar);		
		$q->bindValue(':id', $id, \PDO::PARAM_INT);
		$q->execute();
	}
	
	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM membres');
	}
	
	public function delete(Membre $membre)
	{
		$this->dao->exec('DELETE FROM membres WHERE id = ' . (int)$membre->mb_id());
	}
	
	public function exists($info)
	{
		if (is_int($info)) {
			return (bool) $this->dao->query('SELECT COUNT(*) FROM membres WHERE id = ' . $info)->fetchColumn();
		}
		else {
			$q = $this->dao->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = :pseudo');
			$q->execute(array(':pseudo' => $info));
			return (bool) $q->fetchColumn();
		}
	}
	
	public function get($info)
	{
		if (is_int($info)) {
			$q = $this->dao->query('SELECT id mb_id, pseudo mb_name, mdp mb_mdp, email mb_email, sexe mb_sexe, age mb_age, adresse mb_adresse, coordos mb_coordos, mb_avatar, description mb_descri, last_con mb_lastCon FROM membres WHERE id = ' . $info);
			$donnees = $q->fetch(\PDO::FETCH_ASSOC);
			
			return new \Library\Entities\Membre($donnees);
		}
		else {
			$q = $this->dao->prepare('SELECT id mb_id, pseudo mb_name, mdp mb_mdp, email mb_email, sexe mb_sexe, age mb_age, adresse mb_adresse, coordos mb_coordos, mb_avatar, description mb_descri, last_con mb_lastCon FROM membres WHERE pseudo = :pseudo');
			$q->execute(array(':pseudo' => $info));
			return new \Library\Entities\Membre($q->fetch(\PDO::FETCH_ASSOC));
		}
	}
	
	public function updateCon($id)
	{		
		$q = $this->dao->query('UPDATE membres SET last_con = NOW() WHERE id = '.(int)$id);
	}
	
	public function getList($pseudo, $like, $age)
	{
		// partie pour recherche par pseudo
		if ($like) {
			$like = ' AND pseudo LIKE "%'.$like.'%"';
		}
		
		// partie pour recherche par âge
		if ($age) {
			$age = ' AND age IS NOT NULL AND age BETWEEN '.$age;
		}
		
		$q = $this->dao->prepare('
			SELECT id mb_id, pseudo mb_name, mb_avatar, sexe mb_sexe, age mb_age, adresse mb_adresse, description mb_descri, last_con mb_lastCon
			FROM membres
			WHERE pseudo <> :pseudo '.
			$age
			.' AND pseudo <> "MON_APP"'.
			$like
			.' ORDER BY last_con DESC, pseudo');
		
		// var_dump($q);
		
		$q->execute(array(':pseudo' => $pseudo));
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Membre');
		
		// $membres = $q->fetchAll(\PDO::FETCH_OBJ);
		
		$membres = $q->fetchAll();
		
		return $membres;
	}
	
	public function getAllMessWith($membre_id, $other_id) // fonction à revoir
	{
		$q = $this->dao->query('
			SELECT ms.mess_from mess_from, mb1.pseudo mess_from_pseudo, ms.mess_date mess_date, ms.mess_text mess_text
			FROM messages ms, membres mb1
			WHERE ms.id_conv = '.$other_id.'
			AND ms.mess_from = mb1.id
			ORDER BY ms.mess_id
		');
		
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Message');
		
		$mess = $q->fetchAll(\PDO::FETCH_OBJ);
		
		return $mess;
	}
	
	public function getMess($membre_id)
	{
		$q = $this->dao->query('
			SELECT test.id_conv id_conv, test.participants participants, mess.mess_from mess_from_id, mb2.pseudo mess_from, mess.mess_date mess_date, mess.mess_text mess_text
			FROM
			(
			SELECT id_conv, GROUP_CONCAT(pseudo SEPARATOR ", ") participants
			FROM participe, membres
			WHERE id_conv IN (
				SELECT id_conv
				FROM participe
				WHERE id_membre = '.(int)$membre_id.'
				)
			AND id = id_membre
			AND id <>  '.(int)$membre_id.'
			GROUP BY id_conv
			) as test, messages mess, membres mb2
			WHERE test.id_conv = mess.id_conv
			AND mess.mess_id IN (
				SELECT MAX(mess_id)
				FROM messages
				GROUP BY id_conv
			)
			AND mb2.id = mess.mess_from
		');
		
		$q->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Library\Entities\Message');
		$mess = $q->fetchAll(\PDO::FETCH_OBJ);

		return $mess;		
	}
	
	public function getEvents($membre_id)
	{
		$q = $this->dao->query('SELECT e.id id, e.event_date date, e.event_name name, e.event_lieu lieu
			FROM events e, inscriptions i
			WHERE e.id = i.id_event
			AND e.creator != '.(int) $membre_id.'
			AND i.id_inscrit = '.(int) $membre_id);
		
		$results = array();
		
		while ($result = $q->fetch()) {
			$result['date'] = new \Library\Entities\OneDate($result['date']);			
			$results[] = $result;
		}
		
		return $results;
	}
	
	public function getCreatedEvents($membre_id)
	{
		$q = $this->dao->query('SELECT e.id id, e.event_date date, e.event_name name, e.event_lieu lieu
			FROM events e
			WHERE e.del <> 1
			AND e.creator = '.(int) $membre_id);
			
		$results = array();
		
		while ($result = $q->fetch()) {
			$result['date'] = new \Library\Entities\OneDate($result['date']);			
			$results[] = $result;
		}
		
		return $results;		
	}
	
	public function supprMembre($membre_id)
	{
		$q = $this->dao->prepare('DELETE FROM membres WHERE id = :id');
		$q->bindValue(':id', $membre_id, \PDO::PARAM_INT);
		return $q->execute();
	}
}