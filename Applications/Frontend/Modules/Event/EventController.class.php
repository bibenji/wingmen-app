<?php
namespace Applications\Frontend\Modules\Event;

class EventController extends \Library\BackController
{
	public function executeHome()
	{	
		$this->page->addVar('title', 'Bienvenue sur Wingmen App');		
	}
	
	public function executeTipoftheday()
	{
		$this->page->addVar('title', 'Tip Of The Day');
	}	
	
	public function executeTodo()
	{
		unset($_SESSION);
		$this->page->addVar('title', 'Features à venir sur Wingmen App');
	}	
	
	public function executeEvents(\Library\HTTPRequest $request)
	{	
		/* Deconnexion */
		// créer une page déconnexion
		if (($request->getExists('deconnexion')) AND ($request->getData('deconnexion') == 1))
		{				
			$this->app->user()->setConnected(false);
			$this->app->user()->setFlash('Vous avez bien été déconnecté !');
			$this->app->httpResponse()->redirect('/MON_APP/Web/');
		}
		
		$present = true;
		if ($request->getData('type') != 'events') $present = false;
		
		/* Récupération d'éléments de configuration */
		$nombreEvents = $this->app->config()->get('nombre_events');
		
		$nombreCaracteres = $this->app->config()->get('nombre_caracteres');
		
		$manager = $this->managers->getManagerOf('Events');
				
		if ($present) $nb_events = $manager->countEvents();
		else $nb_events = $manager->countPastEvents();
				
		$pages = ceil($nb_events / $nombreEvents);
		// echo 'pages : ', $pages, ', nb_events : ', $nb_events, ', nombreEvents : ', $nombreEvents;
		
		$deb = $request->getData('deb');		
		$deb = $deb * $nombreEvents;
		
		if ($present) $listeEvents = $manager->getList($deb, $nombreEvents, null);
		else $listeEvents = $manager->getList($deb, $nombreEvents, true);
				
		$this->page->addVar('title', 'Liste des événements');
		$this->page->addVar('listeEvents', $listeEvents);
		$this->page->addVar('pages', $pages);
		$this->page->addVar('present', $present);
	}
		
	
	
	public function executeOneEvent(\Library\HTTPRequest $request)
	{
		$events_manager = $this->managers->getManagerOf('Events');
		$event = $events_manager->getUnique($request->getData('id'));
		if (empty($event)) { $this->app->httpResponse()->redirect404();}
		else
		{
			$inscrits = $events_manager->getInscrits($request->getData('id'));
		
			if ($this->app->user()->isConnected())
			{
				$estinscrit = $events_manager->estInscrit($this->app->user()->id(), $request->getData('id'));
				$this->page->addVar('estinscrit', $estinscrit);
			}
		
			$this->page->addVar('title', $event->event_name());
			$this->page->addVar('event', $event);
			$this->page->addVar('nb_inscrits', count($inscrits));
		
			$this->page->addVar('inscrits', $inscrits);
			$this->page->addVar('comments', $this->managers->getManagerOf('Comments')->getListOf($event->id()));
		}
	}
	
	
	
	public function executeDelete(\Library\HTTPRequest $request)
	{
		if ($request->method() == 'POST') // si qqc posté...
		{			
			$event_manager = $this->managers->getManagerOf('Events');
			$levent = $event_manager->getUnique($request->getData('id'));
			
			if ($this->app->user()->id() == $levent->creator())
			// pour éviter que quelqu'un ne supprime un événement dont il n'est pas l'auteur
			{
				// $lesinscrits = $event_manager->getInscrits($request->getData('id')); // ne sert plus
			
				$notifs_mng = $this->managers->getManagerOf('Notifs');			
				$content = 'L\'événement <a href="/MON_APP/Web/event-'.$request->getData('id').'.html">'.$levent->event_name().'</a>" auquel vous êtiez inscrit a été annulé par son organisateur !';
				
				$notifs_mng->newNotif($request->getData('id'), $content, 'Annulation', $this->app->user()->id());				
				
				$event_manager->delete($request->getData('id'));
				$this->app->user()->setFlash('Evénement bien supprimé !');
				$this->app->httpResponse()->redirect('/MON_APP/Web/events/0');				
			}
			else
			{
				$this->app->user()->setFlash('Vous n\'êtes pas autorisé à supprimer cet événement.');				
			}
		}
		else
		{
			
		}
		$this->page->addVar('title', 'Suppression d\'un événement');
	}
	
	
	
	public function executeInsert(\Library\HTTPRequest $request)
	{
		$this->processForm($request);
		$this->page->addVar('title', 'Organiser un événement');
	}
	
	public function executeUpdate(\Library\HTTPRequest $request)
	{
		$event_manager = $this->managers->getManagerOf('Events');
		$levent = $event_manager->getUnique($request->getData('id'));
				
		if ($this->app->user()->id() == $levent->creator())
		// pour éviter que quelqu'un ne mette un jour un événement dont il n'est pas l'auteur
		{
			$this->processForm($request);
			$this->page->addVar('title', 'Modification d\'un événement');		
		}
		else
		{
			$this->app->user()->setFlash('Vous n\'êtes pas autorisé à modifier cet événement.');
			$this->app->httpResponse()->redirect('/MON_APP/Web/events/0');				
		}
			
		
	}
		
	protected function processForm(\Library\HTTPRequest $request)
	{
		if ($request->method() == 'POST') // si qqc posté...
		{		
			$event = new \Library\Entities\Event($request->postAll());			
			$event->setCreator($this->app->user()->id());			
			if ($request->getExists('id')) { $event->setId($request->getData('id'));} // si update, on vérifie l'existence d'un id
		}
		else // soit on a rien posté et c'est 1ère arrivé sur la page
		{
			 // si y'a l'id c'est de l'update
			if ($request->getExists('id')) { $event = $this->managers->getManagerOf('Events')->getUnique($request->getData('id'));}
			else { $event = new \Library\Entities\Event;} // sinon création new questionnaire avec event vide
		}
				
		$formBuilder = new \Library\FormBuilder\EventFormBuilder($event); // on créer le nouveau questionnaire
		$formBuilder->build();
		$form = $formBuilder->form();		
		
		$formHandler = new \Library\FormHandler($form, $this->managers->getManagerOf('Events'), $request);
		if ($formHandler->process())		
		{
			if($event->isNew())
			{
				$this->app->user()->setFlash('L\'événement a bien été enregistré !');
				$this->app->httpResponse()->redirect('/MON_APP/Web/events/0');
			}
			else
			{							
				$notifs_mng = $this->managers->getManagerOf('Notifs');
				$content = 'Un événement auquel vous participez a été modifié <a href="/MON_APP/Web/event-'.$request->getData('id').'.html">'.$event->event_name().'</a>.';
				
				$notifs_mng->newNotif($request->getData('id'), $content, 'Organisation', $this->app->user()->id());				
								
				$this->app->user()->setFlash('L\'événement a bien été modifié !');				
			}
		}
					
		$this->page->addVar('form', $form->createView());
	}
	
	
	
	/* --- POUR L'INSCRIPTION --- */
	public function executeInscriptionEvent(\Library\HTTPRequest $request)
	{
			$this->page->addVar('title', 'Inscription à une session');
			$events_manager = $this->managers->getManagerOf('Events');
			
			$levent = $events_manager->getUnique($request->getData('id'));
			
			$retour = $events_manager->inscriretrue($request->getData('id'), $this->app->user()->id());
			
			if ($retour) {
				$notifs_mng = $this->managers->getManagerOf('Notifs');
				$content = $this->app->user()->membre()->mb_name().' s\'est inscrit à un événement auquel vous participez <a href="/MON_APP/Web/event-'.$request->getData('id').'.html">'.$levent->event_name().'</a>.';
				
				$notifs_mng->newNotif($request->getData('id'), $content, 'Participation', $this->app->user()->id());				
				
				$this->app->user()->setFlash('Vous avez bien été inscrit !');
				$this->app->httpResponse()->redirect('/MON_APP/Web/events/0');
			}
			else {
				$this->app->user()->setFlash('Problème lors de l\'inscription, merci de réessayer...');
			}
	}
	
	public function executeDesinscriptionEvent(\Library\HTTPRequest $request)
	{
			$this->page->addVar('title', 'Désinscription à une session');
			
			$events_manager = $this->managers->getManagerOf('Events');			
			$levent = $events_manager->getUnique($request->getData('id'));
			
			if ($this->app->user()->id() == $levent->creator())
			// pour éviter que quelqu'un ne mette un jour un événement dont il n'est pas l'auteur
			{	
								
			}
			else
			{
				$retour = $events_manager->desinscrire($request->getData('id'), $this->app->user()->id());
			
				if ($retour) {
					$notifs_mng = $this->managers->getManagerOf('Notifs');
					$content = $this->app->user()->membre()->mb_name().' s\'est désinscrit à un événement auquel vous participez <a href="/MON_APP/Web/event-'.$request->getData('id').'.html">'.$levent->event_name().'</a>.';
									
					$notifs_mng->newNotif($request->getData('id'), $content, 'Participation', $this->app->user()->id());
					
					$this->app->user()->setFlash('Vous avez bien été désinscrit !');
					$this->app->httpResponse()->redirect('/MON_APP/Web/events/0');
				}
				else {
					$this->app->user()->setFlash('Problème lors de la désinscription...');
				}
			}
	}
	
	
	
	/* --- POUR LES COMMENTAIRES --- */
	
	public function executeInsertComment(\Library\HTTPRequest $request)
	{		
		// Si le formulaire a été envoyé.
		if ($request->method() == 'POST')
		{			
			$comment = new \Library\Entities\Comment(array(
				'com_event' => $request->getData('com_event'),
				'com_creator' => $this->app->user()->id(),
				'com_text' => $request->postData('com_text')
				));		
		}
		else { $comment = new \Library\Entities\Comment;} // on créer un comm vide
		
		$formBuilder = new \Library\FormBuilder\CommentFormBuilder($comment); // on créer le formulaire avec ses params...
		$formBuilder->build();
		$form = $formBuilder->form();
		
		// pour tester
		// echo $request->method();
		// echo $form->isValid();
		
		$formHandler = new \Library\FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
				
		if ($formHandler->process())
		{
			$events_manager = $this->managers->getManagerOf('Events');
			$levent = $events_manager->getUnique($request->getData('com_event'));
						
			$notifs_mng = $this->managers->getManagerOf('Notifs');
			$content = $this->app->user()->membre()->mb_name().' a commenté l\'événement <a href="/MON_APP/Web/event-'.$request->getData('com_event').'.html">'.$levent->event_name().'</a>.';
			
			$notifs_mng->newNotif($request->getData('com_event'), $content, 'Commentaire', $this->app->user()->id());
				
			$this->app->user()->setFlash('Votre commentaire a bien été enregistré !');
			$this->app->httpResponse()->redirect('/MON_APP/Web/event-'.$request->getData('com_event').'.html');
		}
		
		
		$this->page->addVar('comment', $comment);
		$this->page->addVar('form', $form->createView());
		$this->page->addVar('title', 'Ajout d\'un commentaire');
		
	}
	
	public function executeUpdateComment()
	{
		
	}
	
	public function executeDeleteComment()
	{
		
	}
}