<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
?>
<?php
	$User = new User();
	$user_getInfo_arr = json_decode($User->getInfo(), true);
?>