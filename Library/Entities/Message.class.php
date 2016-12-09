<?php
namespace Library\Entities;

class Message extends \Library\Entity
{
	protected $erreurs = array(),
		$mess_id,
		$mess_from,
		$mess_to,
		$mess_date,
		$mess_text,
		$id_conv;
	
	const ERROR = 1; // erreurs à préciser
					
	// Constructeur
	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
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
	public function mess_id() { return $this->mess_id;}
	public function mess_from() { return $this->mess_from;}
	public function mess_to() { return $this->mess_to;}
	public function mess_date() { return $this->mess_date;}
	public function mess_text() { return $this->mess_text;}
	public function id_conv() { return $this->id_conv;}
		
	public function setMess_id($id)	{
		$id = (int) $id;
		if ($id > 0) {
			$this->mess_id = $id;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMess_from($from)	{
		$from = (int) $from;
		if ($from > 0) {
			$this->mess_from = $from;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMess_to($to)	{
		$to = (int) $to;
		if ($to > 0) {
			$this->mess_to = $to;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMess_date($date)	{
		if (is_string($date)) {
			$this->mess_date = $date;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setMess_text($text)	{
		if (is_string($text)) {
			$this->mess_text = $text;
		}
		else $this->erreurs[] = self::ERROR;
	}
	
	public function setId_conv($id_conv) {
		if (is_string($id_conv)) $id_conv = (int) $id_conv;
		
		if (is_int($id_conv)) {
			$this->id_conv = $id_conv;
		}
		else $this->erreurs[] = self::ERROR;
	}
}