<?php
	if(!class_exists('AccessToApartments'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
		
	$AccessToApartments = new AccessToApartments();
	$AccessToApartments->idEmployee = $_POST["id_employee"];
	$AccessToApartments->idApartment = $_POST["id_apartment"];
	echo $AccessToApartments->send();
?>