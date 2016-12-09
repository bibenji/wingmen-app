<?php
namespace Library\Entities;

use \Library\Entities\OneDate;

class Membre extends \Library\Entity
{
	protected $erreurs = array(),
		$mb_id,
		$mb_name,
		$mb_avatar,
		$mb_mdp,
		$mb_email,
		$mb_sexe,
		$mb_age,
		$mb_adresse,
		$mb_coordos,
		$mb_descri,
		$mb_lastCon;
	
	const ERROR = 1; // erreurs à préciser
	
	// Constructeur
	public function __construct($donnees = null)
	{
		if (is_array($donnees) AND !(is_null($donnees))) { $this->hydrate($donnees);}
	}
	
	// Hydratation
	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value)
		{
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}
	
	// Les getters et setters
	public function mb_id() { return $this->mb_id;}
	public function mb_name() { return $this->mb_name;}
	public function mb_avatar() { return $this->mb_avatar;}
	public function mb_mdp() { return $this->mb_mdp;}
	public function mb_email() { return $this->mb_email;}
	public function mb_sexe() { return $this->mb_sexe;}
	
	// pour l'enregistrement en bdd
	public function mb_datenaissance() {
		return $this->mb_age;
	}
	
	// pour la gestion du formulaire
	public function mb_age() {		
		if (preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $this->mb_age)) {
			$age = explode('-', $this->mb_age);
			$age = $age[2].'/'.$age[1].'/'.$age[0];
			return $age;
		}
		else return $this->mb_age;		
	}
	
	// pour l'affichage de l'age
	public function mb_year_age() {
		if (!is_null($this->mb_age)) {
			$age = date_create_from_format('Y-m-d', $this->mb_age);
			$now = new \DateTime();
			$interval = $age->diff($now);
			return $interval->y;			
		}
		else return null;
		
	}
	
	
	public function mb_adresse() { return $this->mb_adresse;}
	public function mb_coordos() { return $this->mb_coordos;}
	public function mb_descri() { return $this->mb_descri;}
	
	public function mb_lastCon() {
		return new \Library\Entities\OneDate($this->mb_lastCon);
	}
	
	public function setMb_id($id) {
		$id = (int) $id;
		if ($id > 0) {
			$this->mb_id = $id;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_name($pseudo)	{
		if (is_string($pseudo)) {
			$this->mb_name = $pseudo;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_avatar($avatar) {
		if (is_string($avatar)) {
			$this->mb_avatar = $avatar;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_mdp($mdp) {
		if (is_string($mdp)) {
			$this->mb_mdp = $mdp;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_email($email) {
		if (is_string($email)) {
			$this->mb_email = $email;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_sexe($sexe) {
		if ($sexe == "M" OR $sexe == "F") {
			$this->mb_sexe = $sexe;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_age($age)	{		
		if (preg_match("/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/", $age)) {
			$age = explode('/', $age);
			$age = $age[2].'-'.$age[1].'-'.$age[0];
			$this->mb_age = $age;
		}
		elseif (preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $age)) {		
			$this->mb_age = $age;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_adresse($adresse) {
		if (is_string($adresse)) {
			$this->mb_adresse = $adresse;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_coordos($coordos)	{		
		if (!empty($coordos)) {
			$this->mb_coordos = $coordos;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_descri($descri) {
		if (is_string($descri)) {
			$this->mb_descri = $descri;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMb_lastCon($lastCon)	{
		if (!empty($lastCon)) {
			$this->mb_lastCon = $lastCon;
		}
		else $this->erreurs[] = self::ERROR;
	}
}