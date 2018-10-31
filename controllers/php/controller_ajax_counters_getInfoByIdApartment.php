<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$Counters = new Counters();
	/*echo "<pre>";
	var_dump($_POST);
	echo "</pre>";*/
	
	$Counters->idApartment = $SUBPAGE;
	$counters_sendData_arrResult = json_decode($Counters->getInfoByIdApartment(), true);
	/*echo "<pre>";
	var_dump($counters_sendData_arrResult);
	echo "</pre>";*/
?>