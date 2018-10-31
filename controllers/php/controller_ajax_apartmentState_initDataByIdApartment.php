<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$ApartmentState = new ApartmentState();
	$ApartmentState->idApartment = $SUBPAGE;
	$ApartmentState_initDataByIdApartment_arrResult = json_decode($ApartmentState->initDataByIdApartment(), true);
	/*echo "<pre>";
	var_dump($ApartmentState_initDataByIdApartment_arrResult);
	echo "</pre>";*/
?>