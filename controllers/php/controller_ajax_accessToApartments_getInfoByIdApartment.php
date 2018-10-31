<?php
	if(!class_exists('AccessToApartments'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
		
	$AccessToApartments = new AccessToApartments();
	$AccessToApartments->idEmployee = $SUBPAGE;
	$accessToApartments_getInfoByIdApartment_arr = json_decode($AccessToApartments->getInfoByIdApartment(), true);
?>