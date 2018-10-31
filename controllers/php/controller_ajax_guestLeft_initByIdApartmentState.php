<?php
	if(!class_exists('GuestLeft'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$GuestLeft = new GuestLeft();
	/*echo "<pre>";
	var_dump($_POST);
	echo "</pre>";*/
	
	$GuestLeft->idApartmentState = $ApartmentState_initDataByIdApartment_arrResult["result"]["result"][0]["id"];
	$GuestLeft->idEmployee = $_COOKIE['id_user'];
	$GuestLeft_initByIdApartmentState_arr = json_decode($GuestLeft->initByIdApartmentState(), true);
?>