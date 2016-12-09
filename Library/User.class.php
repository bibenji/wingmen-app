<?php
namespace Library;

session_start();

class User extends ApplicationComponent
{
	private $user_connected;
	public function getUser_connected() { return $this->$user_connected;}
	protected function setUser_connected(\Library\Entities\Membre $mb) { $this->user_connected = $mb;}
		
	public function isAuthenticated() { return isset($_SESSION['auth']) && $_SESSION['auth'] === true;}
	public function setAuthenticated($authenticated = true)
	{
		if (!is_bool($authenticated)) { throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthenticated() doit être un boolean');}
		$_SESSION['auth'] = $authenticated;
	}	
		
	
	
	private $mb_connected;	
	public function getMb_connected() { return $this->$mb_connected;}
	protected function setMb_connected(\Library\Entities\Membre $mb) { $this->mb_connected = $mb;}

	
	
	
	public function isConnected() { return isset($_SESSION['is_connected']) && $_SESSION['is_connected'] === true;} // fonction pour savoir si un membre est connecté
	
	// raccourci pour l'id
	public function id() {
		if (isset($_SESSION['mb_connected'])) {
			return $_SESSION['mb_connected']->mb_id();
		}
	}
	
	// raccourci pour l'ensemble des données
	public function membre() {
		if (isset($_SESSION['mb_connected'])) {
			return $_SESSION['mb_connected'];
		}
	}
	
	public function setConnected($connected, \Library\Entities\Membre $mb = null, $password = null) // fonction pour connecter ou déconnecter un membre
	{
		if (!is_bool($connected)) { throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setMbAuthenticated() doit être un boolean');}
		
		if($connected) // demande de connection
		{
			if ($mb->mb_mdp() == $password)
			{
				// $this->setMb_connected($mb); // sert à rien en fait ???
				if ($_SESSION['mb_connected'] = $mb) {
					$_SESSION['is_connected'] = true;
				}
				return true;
			}					
		}
		else // demande de déconnection
		{
			// $_SESSION['mb_auth'] = false;						
			unset($_SESSION['mb_connected']);			
			unset($_SESSION['is_connected']);
		}
	}
	
	
	
	/* stocker dans $_SESSION */
	public function setAttribute($attr, $value) { $_SESSION[$attr] = $value;}
	public function getAttribute($attr) { return isset($_SESSION[$attr]) ? $_SESSION[$attr] : null;}
		
	/* système de message */
	public function setFlash($value) { $_SESSION['flash'] = $value;}
	public function getFlash()
	{
		$flash = $_SESSION['flash'];
		unset($_SESSION['flash']);
		return $flash;
	}
	public function hasFlash() { return isset($_SESSION['flash']);}	
	
}