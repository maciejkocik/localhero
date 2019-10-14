<?php
//include_once('checking_login.php'); //To musi być zawsze pierwsze!!!


//include_once('variables.php');
include_once('classes.php');

$path = '/action/';

if(isset($_REQUEST['file'])) {

	if(file_exists($path.'/'.$_REQUEST['file'].'.php')) { 
		include($path.'/'.$_REQUEST['file'].'.php');
	} else header("Location:index.php?error=1");

} else header("Location:index.php?error=1");



?>