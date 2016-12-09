<?php
namespace Applications\Frontend\Modules\Messagerie;

class MessagerieController extends \Library\BackController
{
	public function executeMessagerie()
	{
		$mb_manager = $this->managers->getManagerOf('Membres');
				
		$mess_manager = $this->managers->getManagerOf('Messages');
		
		$mess = $mess_manager->getMess($this->app->user()->id());
		
		$new_mess = $mess_manager->getNumberNewMess($this->app->user()->id());
				
		$this->page->addVar('title', 'Messagerie');
		$this->page->addVar('membre', $this->app->user()->membre());
		$this->page->addVar('mess', $mess);	
		$this->page->addVar('new_mess', $new_mess);	
	}
	
	
	
	public function executeNewMess(\Library\HTTPRequest $request)
	{	
		$mess_manager = $this->managers->getManagerOf('Messages');
		$mb_manager = $this->managers->getManagerOf('Membres');
		
		$permission = true;
		
		// si on à l'id du destinataire
		if ($request->getData('to_id')) {
			$to_id = $request->getData('to_id');			
			
			if ($to_id == $this->app->user()->id()) {
				$permission = false;
			}
			else {
				if ($conv = $mess_manager->AlreadyInConv($this->app->user()->id(), $to_id)) {					
					$this->app->httpResponse()->redirect('/MON_APP/Web/zonemb/new-mess-conv-'.$conv.'.html');				
				}				
				$others = array(
					$mb_manager->get((int) $to_id)
				);						
			}
		} 
		else $to_id = '';
		
		
		
		// si on à l'id de la conversation
		if ($request->getData('conv_id')) {
			$conv_id = $request->getData('conv_id');
			
			$permission = $mess_manager->updateTracking($this->app->user()->id(), $conv_id);
			// si $permission false -> personne non autorisée à voir cette conversation			
		}
		else $conv_id = '';
		
		if (!$permission) {
			$this->app->user()->setFlash('Vous ne pouvez pas prendre part à cette conversation !');
			$this->app->httpResponse()->redirect('/MON_APP/Web/zonemb/messagerie/');				
		}
		else {
			
			if ($request->method() == 'POST')
			{
				$message = new \Library\Entities\Message(array(
					"mess_from" => $this->app->user()->id(),
					"id_conv" => $request->getData('conv_id'),
					"mess_to" => $request->getData('to_id'),
					"mess_text" => $request->postData('mess_text')
				));
			}
			else { $message = new \Library\Entities\Message(array());}
					
			$formBuilder = new \Library\FormBuilder\NewMess($message);
			$formBuilder->build();
			$form = $formBuilder->form();
			
			$formHandler = new \Library\FormHandler($form, $this->managers->getManagerOf('Messages'), $request);
			
			if ($request->method() == 'POST') // redondant, trouver mieux
			{
				if ($formHandler->process()) {
					$this->app->user()->setFlash('Message bien envoyé !'); // à voir qu'est ça fait!!!
					if ($request->getData('to_id')) {
						$this->app->httpResponse()->redirect('/MON_APP/Web/zonemb/messagerie/');										
					} else {
						$this->app->httpResponse()->redirect($_SERVER['REQUEST_URI']);										
					}					
				} 
				else $this->app->user()->setFlash("Erreur lors de l'envoi du message..."); // ce truc s'affiche direct!!!
			}						
				
			if ($request->getData('to_id')) {
				$mess = $mb_manager->getAllMessWith($this->app->user()->id(), $request->getData('to_id'));
				// plus utilisé normalement ?
			}
			elseif ($request->getData('conv_id')) {			
				$mess = $mess_manager->getAllMessInConv($request->getData('conv_id'));		
				$others = $mess_manager->getOthersInConv($request->getData('conv_id'), $this->app->user()->id());
				$this->page->addVar('others', $others);
			}
			else {
				throw new Exception('Erreur');
			}
			
			$this->page->addVar('others', $others);
			
			$this->page->addVar('user_id', $this->app->user()->id());
			$this->page->addVar('mess', $mess);
			$this->page->addVar('form', $form->createView());
			$this->page->addVar('title', 'Nouveau message');
			
		}
	}
}