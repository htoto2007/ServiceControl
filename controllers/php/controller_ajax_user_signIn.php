<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
?>
<?php
	$User = new User();
	$User->login = $_POST['login'];
	$User->password = $_POST['password'];
	echo $User->signIn();
?>