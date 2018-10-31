<?php
	if(!class_exists('Apartment'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
		
	$Apartment = new Apartment();
	$Apartment->id = $_POST["id"];
	echo $Apartment->deleteById();
?>