<?php
	if(!class_exists('Apartment'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$Apartment = new Apartment();
	$apartment_getInfo_arrResult = json_decode($Apartment->getInfo(), true);
?>