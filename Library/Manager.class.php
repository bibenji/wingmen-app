<?php
namespace Library;
abstract class Manager
{
	protected $dao;

	public function __construct($dao)
	{
		$this->dao = $dao;
	}
	
	public function ledao() // pour tester, à enlever
	{
		return $this->$dao;
	}
}