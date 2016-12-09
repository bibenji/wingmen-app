<?php
namespace Applications\Backend\Modules\Event;

class EventController extends \Library\BackController
{
	public function executeIndex(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Gestion des events');
		$manager = $this->managers->getManagerOf('Events');
		$this->page->addVar('listeEvents', $manager->getList());
		$this->page->addVar('nombreEvents', $manager->count());
	}
	
	public function executeInsert(\Library\HTTPRequest $request)
	{
		$this->processForm($request);
		$this->page->addVar('title', 'Ajout d\'un event');
	}
	
		public function executeUpdate(\Library\HTTPRequest $request)
	{
		$this->processForm($request);
		$this->page->addVar('title', 'Modification d\'un event');
	}
	
	public function executeUpdateComment(\Library\HTTPRequest $request)
	{
		$this->page->addVar('title', 'Modification d\'un commentaire');
		if ($request->method() == 'POST')
		{
			$comment = new \Library\Entities\Comment(array(
							'id' => $request->getData('id'), // ça ou id ???
							'com_creator' => $request->postData('com_creator'),
							'com_text' => $request->postData('com_text')
							));
		}
		else
		{
				$comment = $this->managers->getManagerOf('Comments')->get($request->getData('id')); // un doute sur ça
		}
		$formBuilder = new \Library\FormBuilder\CommentFormBuilder($comment);
		$formBuilder->build();
		$form = $formBuilder->form();
		
		$formHandler = new \Library\FormHandler($form, $this->managers->getManagerOf('Comments'), $request);
		if ($formHandler->process())
		{
			$this->app->user()->setFlash('Le commentaire a bien été modifié');
			$this->app->httpResponse()->redirect('/MON_APP/Web/admin/');
		}
				
		$this->page->addVar('form', $form->createView());		
	}
	
	
	public function processForm(\Library\HTTPRequest $request)
	{
		if ($request->method() == 'POST') // soit on a posté qqc et c'est de l'insert...
		{
			$event = new \Library\Entities\Event(array(
				'creator' => $request->postData('creator'),
				'event_name' => $request->postData('event_name'),
				'event_description' => $request->postData('event_description')
				));
			
			if ($request->getExists('id'))
			{
				$event->setId($request->getData('id'));
			}
		}
		else // soit on a rien posté et c'est de l'update ???
		{
			if ($request->getExists('id')) // si y'a l'id c'est de l'update
			{
				$event = $this->managers->getManagerOf('Events')->getUnique($request->getData('id'));
			}
			else
			{
				$event = new \Library\Entities\Event; // sinon création new questionnaire
			}
		}
		
		// on créer le nouveau questionnaire
		$formBuilder = new \Library\FormBuilder\EventFormBuilder($event);
		$formBuilder->build();
		$form = $formBuilder->form();		
		
		$formHandler = new \Library\FormHandler($form, $this->managers->getManagerOf('Events'), $request);
		if ($formHandler->process())
		{
			$this->app->user()->setFlash($event->isNew() ? 'L\'event a bien été ajouté !' : 'L\'event a bien été modifié !');
			$this->app->httpResponse()->redirect('/MON_APP/Web/admin/');
		}
					
		$this->page->addVar('form', $form->createView());
	}
	

	
	public function executeDelete(\Library\HTTPRequest $request)
	{
		$this->managers->getManagerOf('Events')->delete($request->getData('id'));
		$this->app->user()->setFlash('L\'event a bien été supprimé !');
		$this->app->httpResponse()->redirect('.');
	}
	
	
	public function executeDeleteComment(\Library\HTTPRequest $request)
	{
		$this->managers->getManagerOf('Comments')->delete($request->getData('id'));
		$this->app->user()->setFlash('Le commentaire a bien été supprimé!');
		$this->app->httpResponse()->redirect('.');
	}
}