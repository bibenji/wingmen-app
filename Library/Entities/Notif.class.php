<?php
namespace Library\Entities;

class Notif extends \Library\Entity
{
	protected $erreurs = array(),
		$id_notif,
		$id_event,
		$date_notif,
		$content_notif,
		$saw_notifs,
		$event_name,
		$type_notif;
		
	const ERROR = 1; // erreurs à préciser
		
	public function __construct($donnees = null) {
		if (is_array($donnees) AND !(is_null($donnees))) {
			$this->hydrate($donnees);
		}
	}
	
	public function hydrate(array $donnees) {
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}
	
	public function setId_notif($val) {
		$val = (int) $val;
		if ($val > 0) {
			$this->id_notif = $val;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setId_event($val) {
		$val = (int) $val;
		if ($val > 0) {
			$this->id_event = $val;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setDate_notif($val) {
		if (!empty($val)) {
			$this->date_notif = new \Library\Entities\OneDate($val);
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setContent_notif($val) {
		if (!empty($val)) {
			$this->content_notif = $val;
		}
		else $this->erreurs[] = self::ERROR;		
	}
	
	public function setSaw_notifs($val) {
		if (!empty($val)) {
			$this->saw_notifs = new \Library\Entities\OneDate($val);
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function id_notif() { return $this->id_notif;}
	public function id_event() { return $this->id_event;}
	public function date_notif() { return $this->date_notif;}
	public function content_notif() { return $this->content_notif;}
	public function saw_notifs() { return $this->saw_notifs;}
	public function event_name() { return $this->event_name;}
	public function type_notif() { return $this->type_notif;}
}