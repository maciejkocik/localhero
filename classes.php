<?php

include_once('classes/DBConnect.php');


function classesAutoLoader($className)
{
	if(file_exists('classes/'.$className.'.php'))
	{
		include_once('classes/'.$className.'.php');
		return true;
	}
	else
	{
		return false;
	}
}

spl_autoload_register('classesAutoLoader');

?>