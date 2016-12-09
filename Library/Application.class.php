<?php
namespace Library;

abstract class Application
{
	protected $httpRequest;
	protected $httpResponse;
	protected $user;
	protected $config;
	protected $name;

	public function __construct()
	{
		$this->httpRequest = new HTTPRequest($this);
		$this->httpResponse = new HTTPResponse($this);
		$this->user = new User($this);
		$this->config = new Config($this);
		$this->name = '';
	}
	
	public function getController() // complexe !!!
	{
		$router = new \Library\Router; // Routes possibles
		$xml = new \DOMDocument; // Classe de base dans php
		$xml->load(__DIR__ . '/../Applications/' . $this->name . '/Config/routes.xml');
		$routes = $xml->getElementsByTagName('route');
		
		foreach ($routes as $route) // On parcourt les routes du fichier XML.
		{
			$vars = array();
			if ($route->hasAttribute('vars')) // On regarde si des variables sont présentes dans l'URL.
			{
				$vars = explode(', ', $route->getAttribute('vars'));
			}
			$router->addRoute(new Route($route->getAttribute('url'),
										$route->getAttribute('module'),
										$route->getAttribute('action'),
										$vars)); // On ajoute la route au routeur.
		}
		try
		{
			//echo $this->httpRequest->requestURI() . '<br />'; // pour tester : c'est good!
			
			$matchedRoute = $router->getRoute($this->httpRequest->requestURI()); // On récupère la route correspondante à l'URL.
			
		}
		catch (\RuntimeException $e)
		{
			if ($e->getCode() == \Library\Router::NO_ROUTE) { $this->httpResponse->redirect404();}
		}
		
		$_GET = array_merge($_GET, $matchedRoute->vars()); // On ajoute les variables de l'URL au tableau $_GET.
		
		$controllerClass = 'Applications\\' . $this->name . '\\Modules\\' . $matchedRoute->module() . '\\' . $matchedRoute->module() . 'Controller'; // On instancie le contrôleur.
		return new $controllerClass($this, $matchedRoute->module(),	$matchedRoute->action());
	}
		
	abstract public function run();
	
	// GETTERS //
	public function httpRequest() { return $this->httpRequest;}
	public function httpResponse() { return $this->httpResponse;}
	public function name() { return $this->name;}
	public function config() { return $this->config;}
	public function user() { return $this->user;}
}