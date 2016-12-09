<?php
namespace Applications\Frontend\Modules\Membre;

class MembreController extends \Library\BackController
{
	public function executeGlobalView()
	{			
		$events_mng = $this->managers->getManagerOf('Events');
		$created = $events_mng->getCreatedEvents($this->app->user()->id());
		$events = $events_mng->getEvents($this->app->user()->id());
		$next_event = $events_mng->getNextEvent($this->app->user()->id());		
		
		$mess_manager = $this->managers->getManagerOf('Messages');		
		$new_mess = $mess_manager->getNumberNewMess($this->app->user()->id());
		
		$notifs_mng = $this->managers->getManagerOf('Notifs');
		$new_notifs = $notifs_mng->getNumberNewNotifs($this->app->user()->id());
		
		$this->page->addVar('title', 'Vue générale');
		
		$this->page->addVar('new_mess', $new_mess);
		$this->page->addVar('new_notifs', $new_notifs);
		$this->page->addVar('next_event', $next_event);
		$this->page->addVar('created', $created);
		$this->page->addVar('events', $events);
	}
	
	public function executeHistorique()
	{			
		$events_mng = $this->managers->getManagerOf('Events');
		$created = $events_mng->getCreatedEvents($this->app->user()->id(), true);
		$events = $events_mng->getEvents($this->app->user()->id(), true);
				
		$this->page->addVar('title', 'Historique');
		
		$this->page->addVar('created', $created);
		$this->page->addVar('events', $events);		
	}
	
	
	
	public function executeParams()
	{
		$mb_manager = $this->managers->getManagerOf('Membres');
				
		$this->page->addVar('title', 'Paramètres');		
				
		$membre = $mb_manager->get($this->app->user()->id());
		$this->page->addVar('membre', $membre);		
	}
	
	
	
	public function executeZoneMembre(\Library\HTTPRequest $request)
	{	
		$mb_manager = $this->managers->getManagerOf('Membres');
		
		if ($request->postData('search_pseudo') != null) {
			$like = $request->postData('search_pseudo');
		}
		else $like = '';
				
		
		
		if ( ($request->method() == 'POST') AND (($request->postData('age_max') != '-') OR ($request->postData('age_min') != '-')) )
		{
			// calcul de la date de naissance min et max
			$mois_jour = date('-m-d');
			$an = date('Y');
			
			$age_min = $an-15;
			$age_min .= $mois_jour;
			$age_max = $an-100;
			$age_max .= $mois_jour;
			
			if ($request->postData('age_max') != '-') {
				$age_max = $request->postData('age_max');
			}	
			if ($request->postData('age_min') != '-') {
				$age_min = $request->postData('age_min');
			}		
					
			$age = '\''. $age_max .'\' AND \''. $age_min .'\'';			
		}
		else
		{
			$age = '';
		}
		
		// echo $age, '<br />';
		
		

		
		$lesmembres = $mb_manager->getList($this->app->user()->membre()->mb_name(), $like, $age);
		

		
		$this->page->addVar('title', 'Liste des Membres');
		// $this->page->addVar('membre', $this->app->user()->membre());
		$this->page->addVar('lesmembres', $lesmembres);
	}
	
	public function executeOneMembre(\Library\HTTPRequest $request)
	{
		$mb_manager = $this->managers->getManagerOf('Membres');
		
		if ($request->getData('id')) {
			if ($mb_manager->exists((int) $request->getData('id'))) {
				$membre = $mb_manager->get((int) $request->getData('id'));
				
				$this->page->addVar('title', 'Présentation de '.$membre->mb_name());
				$this->page->addVar('membre', $membre);				
			}
		}
	}
	
	public function executeSupprimer(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Supprimer votre compte');
		
		$test = array();
		var_dump(empty($test));
		
		if ( ($request->method() == 'POST') ) {
			
			$mb_manager = $this->managers->getManagerOf('Membres');
			$events_manager = $this->managers->getManagerOf('Events');
			$notifs_mng = $this->managers->getManagerOf('Notifs');
			
			$errors = array();
			
			// on supprime d'éventuelles inscriptions à des événements
			$events_inscrit = $mb_manager->getEvents($this->app->user()->id());			
			foreach ($events_inscrit as $event) {
				if ($events_manager->desinscrire($event['id'], $this->app->user()->id())) {				
					$content = $this->app->user()->membre()->mb_name().' s\'est désinscrit à un événement auquel vous participez <a href="/MON_APP/Web/event-'.$event['id'].'.html">'.$event['name'].'</a>.';								
					$notifs_mng->newNotif($event['id'], $content, 'Participation', $this->app->user()->id());							
				}
				else $errors[] = 'Erreur lors de la désinscription à un événement';
			}
			
			// on supprime d'éventuels événements créés
			$events_created = $mb_manager->getCreatedEvents($this->app->user()->id());
			foreach ($events_created as $event) {
				// $lesinscrits = $event_manager->getInscrits($event['id']); // ne sert plus
			
				$notifs_mng = $this->managers->getManagerOf('Notifs');			
				$content = 'L\'événement <a href="/MON_APP/Web/event-'.$event['id'].'.html">'.$event['name'].'</a>" auquel vous êtiez inscrit a été annulé par son organisateur !';
				$notifs_mng->newNotif($event['id'], $content, 'Annulation', $this->app->user()->id());				
				
				if ($events_manager->delete($event['id'])) {
					
				}
				else $errors[] = 'Erreur lors de l\'annulation d\'un événement';
			}
			
			if (empty($errors)) {
				if ($mb_manager->supprMembre($this->app->user()->id())) {
					$this->app->user()->setConnected(false);
					$this->app->user()->setFlash('Votre compte a bien été supprimé !');
					$this->app->httpResponse()->redirect('/MON_APP/Web/');
					
				}
			}
		}
	}
	
	public function executeConnexion(\Library\HTTPRequest $request) // ok
	{
		$this->page->addVar('title', 'Se connecter');
		$this->page->addVar('req', 'connexion'); // obtenir partie du formulaire nécessaire uniquement pour la connection
				
		if ($request->postExists('pseudo'))
		{			
			$mb_manager = $this->managers->getManagerOf('Membres');
			if ($mb_manager->exists($request->postData('pseudo')))
			{	
				$membre = $mb_manager->get($request->postData('pseudo'));				
				
				$connected = $this->app->user()->setConnected(true, $membre, $request->postData('mdp'));				
								
				if ($connected)
				{	
					$mb_manager->updateCon($membre->mb_id());
					if ($this->app->user()->membre()->mb_lastCon() === null) {
						$this->app->user()->setFlash('Première fois dans la zone membre ? Pensez à renseigner vos informations personnelles...');
						$this->app->httpResponse()->redirect('/MON_APP/Web/account/');
					}
					else {
						$this->app->user()->setFlash('Connexion réussie !');
						$this->app->httpResponse()->redirect('../zonemb/');						
					}					
				}
				else
				{
					$this->app->user()->setFlash('Erreur de mot de passe...');
				}				
			}
			else $this->app->user()->setFlash('Pas de membre correspondant...');
		}		
	}
	
	public function executeForgot()
	{
		$this->page->addVar('title', 'Mot de passe oublié ?');
	}
	
	
	
	public function executeAccount(\Library\HTTPRequest $request)
	{			
		if ($this->app->user()->isConnected() AND $request->method() != 'POST') {
			$membre = $this->app->user()->membre();
			$this->page->addVar('title', 'Modification du compte');
		}
		elseif ($request->method() == 'POST') {
			$membre = new \Library\Entities\Membre($request->postAll());			
			
			if ($this->app->user()->isConnected()) {				
				$membre->setMb_id($this->app->user()->id());
				$this->page->addVar('title', 'Modification du compte');
			}
			else {
				$this->page->addVar('title', 'Inscription');
			}
		}
		else {
			$membre = new \Library\Entities\Membre;
			$this->page->addVar('title', 'Inscription');
		} // on créer un mb vide
		
		if ($this->app->user()->isConnected()) {
			// formulaire pour les membres connectés
			$formBuilder = new \Library\FormBuilder\MembreFormBuilder($membre);
		} else {
			$formBuilder = new \Library\FormBuilder\InscriptionMembreFormBuilder($membre); // on créer le formulaire avec ses params...
		}
		
		
		
		$formBuilder->build();
		$form = $formBuilder->form();	
		
		if ($request->method() == 'POST') // trouver mieux que ça				
		{	
			$mng = $this->managers->getManagerOf('Membres');
			$formHandler = new \Library\FormHandler($form, $mng, $request);
			
			if ($last_id = $formHandler->process())
			{	
		
				if ($this->app->user()->isConnected()) {
					$membre = $mng->get($last_id);
					$this->app->user()->setConnected(true, $membre, $membre->mb_mdp());						
				}				
				else {
					$this->app->user()->setFlash('Vous avez bien été inscrit, merci !');
					$this->app->httpResponse()->redirect('/MON_APP/Web/');
				}
								
				// faire plutôt le traitement de l'image ici si tout s'est bien passé avec un last insert id...
				if (isset($_FILES['mb_avatar']) AND (!empty($_FILES['mb_avatar']['name']))) {
					$pic_name = $last_id.'.jpg';
					$pic_url = '../Applications/Frontend/Modules/Membre/Ressources/Avatars/'.$pic_name;
					move_uploaded_file($_FILES['mb_avatar']['tmp_name'], $pic_url);
					$mng->updateAvatar($last_id, $pic_name);
					$this->app->user()->membre()->setMb_avatar($pic_name);
				} 
				
				if ($this->app->user()->isConnected()) // séparé pour pouvoir enregistrer un changement d'avatar
				{
					$this->app->user()->setFlash('Votre compte a bien été modifié !');
					$this->app->httpResponse()->redirect('/MON_APP/Web/zonemb/params/');
				}
				
			}
			else
			{				
				$this->app->user()->setFlash("Erreur lors de l'enregistrement... Assurez-vous que tous les champs aient été bien remplis. Sinon, il est également possible que ce membre existe déjà.");				
			}
		}		
		
		$this->page->addVar('membre', $membre);
		$this->page->addVar('form', $form->createView());				
	}

	
	
	public function executeNotifications()
	{
		$mng = $this->managers->getManagerOf('Notifs');
		$lesnotifs = $mng->getNotifs($this->app->user()->id());		
		$mng->sawNotifs($this->app->user()->id());
		$this->page->addVar('lesnotifs', $lesnotifs);
	}
}