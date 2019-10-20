<?php

include_once('classes.php');
include_once('admin/checking_login.php');
include_once('admin/functions.php');

$path = 'action';

if(isset($_REQUEST['file'])) {

	if(file_exists($path.'/'.$_REQUEST['file'].'.php')) { 
		include($path.'/'.$_REQUEST['file'].'.php');
	} else header("Location:index.php?page=error");

} else header("Location:index.php?page=error");



?>