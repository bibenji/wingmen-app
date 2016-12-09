<?php
namespace Library\Entities;

use \Library\Entities\OneDate;

class Event extends \Library\Entity
{
	protected $erreurs = array(),
			$id,
			$creator, $pseudo, $avatar,
			$event_hour, $event_day, $event_date, $event_time,
			$event_name, $event_description, $event_max, $event_type,
			$event_lieu, $event_coordos,
			$inscrits,
			$dateAjout, $dateModif;
		
	const CREATOR_INVALIDE = 1,
		PSEUDO_INVALIDE = 2,
		DATE_INVALIDE = 3,
		DESCRIPTION_INVALIDE = 4,
		LIEU_INVALIDE = 5,
		AVATAR_INVALIDE = 6,
		MAX_INVALIDE = 7,
		ERREUR_INSCRITS = 8,
		TYPE_INVALIDE = 9;
		
	public function isValid() // à terminer
	{		
		return !(empty($this->creator) || empty($this->event_name) || empty($this->event_description));
	}
	
	public function isPast()
	{
		$date = date('Y-m-d h:i:s');
		return $this->event_date < $date;		
	}
	
	// Constructeur
	public function __construct($donnees = null)
	{
		// echo 'constructeur de event<br />';
		if (is_array($donnees) AND !(is_null($donnees))) { $this->hydrate($donnees);}
	}
	
	// Hydratation
	public function hydrate(array $donnees)
	{
		// echo 'function hydrate de event';
		foreach ($donnees as $key => $value)
		{
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}
	
		
	// SETTERS //
	public function setCreator($creator) {
		$creator = (int) $creator;
		if ($creator > 0) {
			$this->creator = $creator;
		}
		else $this->erreurs[] = self::CREATOR_INVALIDE;		
	}
	
	public function setPseudo($pseudo) {
		if(is_string($pseudo)) {
			$this->pseudo = $pseudo;
		}
		else $this->erreurs[] = self::PSEUDO_INVALIDE;		
	}
	
	public function setAvatar($avatar) {
		if(is_string($avatar)) {
			$this->avatar = $avatar;
		}
		else $this->erreurs[] = self::AVATAR_INVALIDE;		
	}
	
	public function setEvent_time($time) {
		$this->event_time = new \Library\Entities\OneDate($time);
	}
	
	public function setEvent_hour($hour)
	{
		if (preg_match("/[0-9]{2}:[0-9]{2}:[0-9]{2}/", $hour)) {
			$this->event_hour = $hour;			
			if (!empty($this->event_day())) {
				$goodDate = $this->GoodFormatDate($this->event_day());
				$this->event_date = $goodDate.' '.$hour;
			}
		}
		else $this->erreurs[] = self::DATE_INVALIDE;
	}
	
	public function setEvent_day($day) {
		if (preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $day)) {
			$day = explode('-', $day);
			$day = $day[2].'/'.$day[1].'/'.$day[0];
			$this->event_day = $day; // met la date au format 00/00/0000			
		}
		elseif (preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $day)) {
			
			$this->event_day = $day; // garde la date au format 00/00/0000
			
			$day = explode('/', $day);
			$day = $day[2].'-'.$day[1].'-'.$day[0];
			// $this->event_day = $day; // nécessaire pour setEvent_date si appelé depuis setEvent_hour
			if (!empty($this->event_hour())) $this->event_date = $day.' '.$this->event_hour;			
		}
		else $this->erreurs[] = self::DATE_INVALIDE;
	}
	
	protected function GoodFormatDate($date) {
		if (preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $date)) {
			$date = explode('/', $date);
			$date = $date[2].'-'.$date[1].'-'.$date[0];
			return $date;
		}
		else return $date;
	}
	
	public function setEvent_date($event_date) {		
		if (preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/", $event_date)) {			
			preg_match_all("/([0-9]{4}-[0-9]{2}-[0-9]{2})\s([0-9]{2}:[0-9]{2}:[0-9]{2})/", $event_date, $out);
			
			// création de l'objet OneDate
			$this->setEvent_time($event_date);
			
			$this->setEvent_day($out[1][0]);
			$this->event_hour = $out[2][0];
		}
		else $this->erreurs[] = self::DATE_INVALIDE; 
		
	}
	
	public function setEvent_name($event_name) {
		if (!is_string($event_name) || empty($event_name)) {
			$this->erreurs[] = self::NAME_INVALIDE;
		}
		else $this->event_name = $event_name;
	}
	
	public function setEvent_description($event_description) {
		if (!is_string($event_description) || empty($event_description)) {
			$this->erreurs[] = self::DESCRIPTION_INVALIDE;
		}
		else $this->event_description = $event_description;
	}
	
	public function setEvent_lieu($event_lieu) {
		if (!is_string($event_lieu) || empty($event_lieu)) {
			$this->erreurs[] = self::LIEU_INVALIDE;
		}
		else $this->event_lieu = $event_lieu;
	}
	
	public function setEvent_coordos($event_coordos) {
		if(empty($event_coordos)) {
			$this->erreurs[] = self::LIEU_INVALIDE;
		}
		else $this->event_coordos = $event_coordos;
	}
	
	public function setEvent_max($event_max) {
		$event_max = (int) $event_max;
		if ($event_max > 0) {
			$this->event_max = $event_max;
		}
		else $this->erreurs[] = self::MAX_INVALIDE;
	}
	
	public function setInscrits($inscrits) {
		$inscrits = (int) $inscrits;
		if ($inscrits > 0) {
			$this->inscrits = $inscrits;
		}
		else $this->erreurs[] = self::ERREUR_INSCRITS;
	}
	
	public function setDateAjout(\DateTime $dateAjout) { $this->dateAjout = $dateAjout;}
	public function setDateModif(\DateTime $dateModif) { $this->dateModif = $dateModif;}
	
	public function setEvent_type($event_type) {
		if (!is_string($event_type) || empty($event_type)) {
			$this->erreurs[] = self::TYPE_INVALIDE;
		}
		else $this->event_type = $event_type;
	}
		
	// GETTERS //
	public function creator() { return $this->creator;}
	public function pseudo() { return $this->pseudo;}
	public function avatar() { return $this->avatar;}
	public function event_hour() { return $this->event_hour;}
	public function event_day() { return $this->event_day;}
	public function event_date() { return $this->event_date;}
	public function event_name() { return $this->event_name;}
	public function event_description() { return $this->event_description;}
	
	public function event_shortDescription($nombreCaracteres) {
		$contenu = $this->event_description;
		if (strlen($contenu) > $nombreCaracteres) {
			$contenu = substr($contenu, 0, $nombreCaracteres);
			$contenu = substr($contenu, 0, strrpos($contenu, ' ')) . '...';			
		}
		return $contenu;		
	}
	
	public function event_lieu() { return $this->event_lieu;}
	public function event_coordos() { return $this->event_coordos;}
	public function event_max() { return $this->event_max;}
	public function inscrits() { return $this->inscrits;}
	public function dateAjout() { return $this->dateAjout;}
	public function dateModif() { return $this->dateModif;}
	public function event_type() { return $this->event_type;}
	public function event_time() { return $this->event_time;}
}