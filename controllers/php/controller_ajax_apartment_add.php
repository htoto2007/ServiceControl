<?php
	if(!class_exists('Apartment'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
		
	$Apartment = new Apartment();
	$Apartment->adres = $_POST['adres'];
	echo $Apartment->add();
	//if($_POST['adres'] == "") return
?>