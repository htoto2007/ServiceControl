<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
?>
<?php
	//var_dump($_POST);
	$User = new User();
	$User->id = $_POST['id_employee'];
	echo $res = $User->passwordRecovery();
	//var_dump($res);
?>