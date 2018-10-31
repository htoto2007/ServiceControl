<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$ApartmentState = new ApartmentState();
	$ApartmentState->id = $_POST["id_apartment_state"];
	$ApartmentState->apartmentIsReady = $_POST["apartment_is_ready"];
	echo $ApartmentState->sendReady();
?>