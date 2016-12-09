<?php
namespace Library\Models;

use \Library\Entities\Notif;

abstract class NotifsManager extends \Library\Manager
{
	/**
	* Méthode pour récupérer toutes les notifs et mettre à jour la dernière visite des notifications
	*/
	public function getNotifs($id_membre)
	{
		// $this->sawNotifs($id_membre);
		return $this->getAllNotifs($id_membre);
	}
	
	/**
	* MAJ de la dernière visite des notifications
	*/
	abstract public function sawNotifs($id_membre);
	
	/**
	* Méthode pour récupérer toutes les notifs
	*/
	abstract public function getAllNotifs($id_membre);
	
	/**
	* Méthode pour enregistrer une nouvelle notif dans la liste
	*/
	abstract public function newNotif($id_event, $content, $type = null, $id_membre = null);
	
	/**
	* Méthode pour avoir le nombre de nouvelles notifications
	*/
	abstract public function getNumberNewNotifs($id_membre);
}