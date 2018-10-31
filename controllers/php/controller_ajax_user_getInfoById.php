<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
?>
<?php
	$User = new User();
	$User->id = $SUBPAGE;
	$user_getInfoById_arr = json_decode($User->getInfoById(), true);
?>