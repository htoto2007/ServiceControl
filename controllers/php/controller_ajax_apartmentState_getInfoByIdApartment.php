<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$ApartmentState = new ApartmentState();
	$ApartmentState->idApartment = $SUBPAGE;
	$ApartmentState_getInfoByIdApartment_arr = json_decode($ApartmentState->getInfoByIdApartment(), true);
?>