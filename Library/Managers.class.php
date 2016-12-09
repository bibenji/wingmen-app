<?php
namespace Library;
class Managers
{
	protected $api = null;
	protected $dao = null;
	protected $managers = array();

	public function __construct($api, $dao)
	{
		$this->api = $api;
		$this->dao = $dao;
	}

	public function getManagerOf($module)
	{
		if (!is_string($module) || empty($module))
		{
			throw new \InvalidArgumentException('Le module spécifié est	invalide');
		}
		if (!isset($this->managers[$module]))
		{
			$manager = '\\Library\\Models\\' . $module . 'Manager_' . $this->api;
			//echo '<h2>Le manager : ' . $manager . ' et le DAO : ' . var_dump($this->dao) . '</h2>'; // test
			//echo '<h2>Le module : ' . $module . '</h2>';
			//echo '<h1>test 1</h1><p>$manager = ' . $manager . '</p>'; // test
			$this->managers[$module] = new $manager($this->dao); // le problème vient de là!
			// echo '<h1>test 2</h1>'; // test
			
			
		}
		return $this->managers[$module];
		
	}
}