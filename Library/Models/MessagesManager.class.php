<?php
namespace Library\Models;

use \Library\Entities\Message;

abstract class MessagesManager extends \Library\Manager
{
	/**
	* Fonction pour récupérer toutes les conversations d'un membre
	*/
	abstract public function getConvOf($id_membre);
			
	/**
	* Méthode pour gérer les convs et les messages
	*/
	public function save(Message $message)
	{			
		if ($message->id_conv() != '') { // si on a déjà l'id de conversation						
			
		}		
		else { // sinon on doit vérifier si une conversation existe déjà
			$convs1 = $this->getConvOf($message->mess_from());
			$convs2 = $this->getConvOf($message->mess_to());
			
			$no_conv = false;
			
			if (empty($convs1) OR empty($convs2)) {
				$no_conv = true;
			}
			else {
						
				foreach ($convs1 as $conv1) {				
					foreach ($convs2 as $conv2) {
											
						if (($conv1['id_conv'] == $conv2['id_conv']) AND (!$this->getOthersInConv($conv1['id_conv'], $message->mess_from(), $message->mess_to()))) {							
							// il y a une conversation en cours et pas d'autres membres dans cette conversation
							// pas besoin de créer une nouvelle conversation							
							$message->setId_conv($conv1['id_conv']);											
						}						
						else {
							// il n'y a pas de conversation déjà en cours rien qu'entre les deux gens
							$no_conv = true;
						}
						
					}
				}
			
			}
			
			if ($no_conv) { // si on a pas trouvé de conversation existance, on la créer			
				$id_new_conv = $this->createConv($message);
				
				$new_date = (new \DateTime())->add(new \DateInterval('PT20S'));
				$new_date = $new_date->format('Y-m-d H:i:s');
				$this->addMembre($id_new_conv, $message->mess_from(), $new_date);
				
				$new_date = (new \DateTime())->sub(new \DateInterval('PT20S'));
				$new_date = $new_date->format('Y-m-d H:i:s');				
				$this->addMembre($id_new_conv, $message->mess_to(), $new_date);
				
				$message->setId_conv($id_new_conv);			
			}
			else {
				
			}
			
		}
		
		return $this->newMess($message);		
	}
	
	/**
	* Savoir si il existe déjà une conversation entre deux membres
	**/
	public function AlreadyInConv($mb1_id, $mb2_id)
	{
		// si des conversations existent déjà
		if ($convs = $this->getConvBetween($mb1_id, $mb2_id)) {
			
			foreach ($convs as $conv) {
				$results = $this->getOthersInConv($conv['id_conv'], $mb1_id);
				if (count($results) > 1) {
			
				}
				else {
					return $conv['id_conv'];
				}
			}
			
		}
	}
	
	/**
	* Obtenir les ids de conversations impliquant 2 membres
	**/
	abstract protected function getConvBetween($mb1_id, $mb2_id);
	
	/**
	* Pour avoir les autres dans la conversation et leurs avatars
	**/
	abstract public function getOthersInConv($id_conv, $mb_id);
		
	/**
	* Méthode pour enregistrer un message
	**/
	abstract public function newMess(Message $message);
		
	/**
	* Méthode de création de conversation
	**/
	abstract public function createConv(Message $message);
	
	/**
	* Méthode pour obtenir tous les messages d'une conversation
	**/
	abstract public function getAllMessInConv($id_conv);
	
	/**
	* Méthode pour mettre à jour le tracking
	**/
	abstract public function updateTracking($id_membre, $id_conv);
	
	/**
	* Méthode pour obtenir toutes les conversations d'un membre
	**/
	abstract public function getMess($id_membre);
	
	/**
	* Méthode pour obtenir le nombre de messages non-lus par un membre
	**/
	abstract public function getNumberNewMess($id_membre);
		
	/**
	* Méthode d'ajout de participants à une conv
	**/
	abstract public function addMembre($id_conv, $id_mb, $tracking);
}