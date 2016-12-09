<?php
namespace Applications\Frontend;

class FrontendApplication extends \Library\Application
{
	public function __construct()
	{
		parent::__construct();
		$this->name = 'Frontend';
	}
	
	public function run()
	{
		if (strpos($_SERVER['REQUEST_URI'], 'zonemb')) // pages de la zone membre
		{
			if ($this->user->isConnected())
			{
				$controller = $this->getController();
			}
			else
			{
				$controller = new Modules\Event\EventController($this, 'Event', 'home');
			}
		}
		else // autres pages
		{
			$controller = $this->getController();
		}		
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}