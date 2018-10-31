<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$User = new User();
	echo $User->logout();
?>