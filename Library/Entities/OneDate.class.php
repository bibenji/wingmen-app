<?php
namespace Library\Entities;

class OneDate
{
	private $days = array(
		"Sun" => "Dimanche",
		"Mon" => "Lundi",
		"Tue" => "Mardi",
		"Wed" => "Mercredi",
		"Thu" => "Jeudi",
		"Fri" => "Vendredi",
		"Sat" => "Samedi"		
	);
	
	private $months = array(
		"01" => "Janvier",
		"02" => "Février",
		"03" => "Mars",
		"04" => "Avril",
		"05" => "Mai",
		"06" => "Juin",
		"07" => "Juillet",
		"08" => "Aout",
		"09" => "Septembre",
		"10" => "Octobre",
		"11" => "Novembre",
		"12" => "Décembre",
	);
	
	protected $date;
	
	public function __construct($date) {
		if ($date instanceof DateTime) {
			$this->date = $date;
		}
		else {
			$this->date = date_create_from_format('Y-m-d H:i:s', $date);
		}		
	}
	
	public function getDatetime() {
		return $this->date;
	}
	
	public function getStringtime() {
		$day = $this->days[$this->date->format('D')];
		$month = $this->months[$this->date->format('m')];
		
		return $day.' '.$this->date->format('d').' '.$month.' à '.$this->date->format('H\hi');
		
		// return date_format($this->date, 'd/m/Y à H\hi');
	}
	
	public function getStringdate() {
		$day = $this->days[$this->date->format('D')];
		$month = $this->months[$this->date->format('m')];
		
		return $day.' '.$this->date->format('d').' '.$month;
	}
	
	public function getJustdate() {
		return date_format($this->date, 'l d F');
	}
	
	public function getHourtime() {
		return date_format($this->date, 'H\hi');
	}
	
	public function getPasttime() {
		
		if (is_bool($this->date)) {
			return "Pas de données";
		}
		else {
		
			$now = new \DateTime();
			$interval = $this->date->diff($now);		
			
			$intervalTexte;
			
			if ($interval->y >= 1) $intervalTexte = "Plus d'un an";
			else {
				if ($interval->m >= 1) $intervalTexte = $interval->m." mois";
				else {
					if ($interval->d >= 1) $intervalTexte = $interval->d." jour(s)";
					else {
						if ($interval->h >= 1) $intervalTexte = $interval->h." heure(s)";
						else {
							if ($interval->i >= 1) $intervalTexte = $interval->i." minute(s)";
							else {
								if ($interval->s >= 1) $intervalTexte = "Connecté";
								else $intervalTexte = "Erreur de calcul";
							}			
						}
					}
				}
			}
		
			return $intervalTexte;		
		
		}
	}
}