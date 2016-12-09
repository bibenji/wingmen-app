<?php
namespace Library;

class HTTPRequest extends ApplicationComponent
{
	public function getData($key) { return isset($_GET[$key]) ? $_GET[$key] : null;}
	public function getExists($key)	{ return isset($_GET[$key]);}
	
	public function method() { return $_SERVER['REQUEST_METHOD'];}
	
	public function postData($key)	{ return isset($_POST[$key]) ? $_POST[$key] : null;}
		
	public function postAll() { return $_POST;}
	
	public function postExists($key) { return isset($_POST[$key]);}
	
	public function requestURI() { return $_SERVER['REQUEST_URI'];}
}