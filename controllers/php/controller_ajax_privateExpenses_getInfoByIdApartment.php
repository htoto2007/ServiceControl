<?php
	if(!class_exists('PrivateExpenses'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$PrivateExpenses = new PrivateExpenses();
	$PrivateExpenses->idApartment = $SUBPAGE;
	$privateExpenses_getInfoByIdApartment_arr = json_decode($PrivateExpenses->getInfoByIdApartment(), true);
?>