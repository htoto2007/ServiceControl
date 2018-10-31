<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$Counters = new Counters();
	/*echo "<pre>";
	var_dump($_POST);
	echo "</pre>";*/
	
	$Counters->idApartment = $_POST["id_apartment"];
	$Counters->idEmployee = $_POST["id_employee"];
	$Counters->gasPrice = $_POST["gas_price"];
	$Counters->gasPaid = $_POST["gas_paid"];
	$Counters->shineReadings = $_POST["shine_readings"];
	$Counters->shinePrice = $_POST["shine_price"];
	$Counters->shinePaid = $_POST["shine_paid"];
	$Counters->waterReadings = $_POST["water_readings"];
	$Counters->waterPrice = $_POST["water_price"];
	$Counters->waterPaid = $_POST["water_paid"];
	$Counters->communalPrice = $_POST["communal_price"];
	$Counters->communalPaid = $_POST["communal_paid"];
	echo $Counters->sendData();
?>