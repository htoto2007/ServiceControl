<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
?>
<?php
	$User = new User();
	$User->lastName = $_POST['last_name'];
	$User->firstName = $_POST['first_name'];
	$User->middleName = $_POST['middle_name'];
	$User->idAccessGroup = $_POST['id_access_group'];
	echo $User->registration();
?>