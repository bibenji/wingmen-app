<?php
namespace Library;
class Router
{
	protected $routes = array();
	const NO_ROUTE = 1;
	
	public function addRoute(Route $route)
	{
		if (!in_array($route, $this->routes)) { $this->routes[] = $route;} // ajout d'une nouvelle route
	}
	
	public function getRoute($url)
	{
		$url = str_replace('/MON_APP/Web', '', $url); // car le localhost pas à la racine /MON_APP/Web/
		
		// echo $url;
		// var_dump($this->routes);
		
		foreach ($this->routes as $route)
		{	
			//echo '<p>' . str_replace('/MON_APP/Web', '', $url) . ' = url</p>'; // pour tester est good!
			//echo '<p>' . $route->get_url() . ' = route dans le router</p>'; // pour tester et problème ici de l'url de la route de routes.xml
			
			if (($varsValues = $route->match($url)) !== false) // si une route correspond à l'url
			{
				if ($route->hasVars()) // si la route a des variables
				{
					
					$varsNames = $route->varsNames();
					$listVars = array();
					foreach ($varsValues as $key => $match)
					{
						if ($key !== 0) { $listVars[$varsNames[$key - 1]] = $match;} // ajout au tableau clés/variables
					}
					$route->setVars($listVars); // on rend les variables accessibles
					
				}
				return $route;
			}
		}
		throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
	}
}