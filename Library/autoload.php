<?php
function autoload($class)
{	
	if(1 == 2) { echo '../' . str_replace('\\', '/', $class) . '.class.php<br />';}
	
	require '../' . str_replace('\\', '/', $class) . '.class.php';
}

spl_autoload_register('autoload');