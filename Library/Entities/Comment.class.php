<?php
namespace Library\Entities;

class Comment extends \Library\Entity
{
	protected $erreurs = array(),
			$com_event,
			$com_creator,
			$com_creator_id,
			$com_text,
			$date,
			$mb_avatar;
	
	const CREATOR_INVALIDE = 1,
			TEXT_INVALIDE = 2,
			LINKED_EVENT = 3;
	
	public function isValid() { return !(empty($this->com_creator) || empty($this->com_text));}
	
	// SETTERS
	public function setCom_event($com_event) {
		$com_event = (int) $com_event;
		if ($com_event > 0) {
			$this->com_event = (int) $com_event;
		}
		else $this->erreurs[] = self::LINKED_EVENT;		
	}
	
	public function setCom_creator($com_creator) {
		$com_creator = (int) $com_creator;
		if ($com_creator > 0) {
			$this->com_creator = $com_creator;
		}
		else $this->erreurs[] = self::CREATOR_INVALIDE;
	}
	
	public function setCom_text($com_text) {
		if (!is_string($com_text) || empty($com_text)) {
			$this->erreurs[] = self::TEXT_INVALIDE;
		}
		else $this->com_text = $com_text;
	}
	
	public function setDate(\DateTime $date) { $this->date = $date;}
	
	// GETTERS
	public function com_event() { return $this->com_event;}
	public function com_creator() { return $this->com_creator;}
	public function com_text() { return $this->com_text;}
	public function date() { return $this->date;}
	public function mb_avatar() { return $this->mb_avatar;}
	public function com_creator_id() { return $this->com_creator_id;}
}