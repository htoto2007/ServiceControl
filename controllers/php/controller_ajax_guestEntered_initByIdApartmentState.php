<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$GuestEntered = new GuestEntered();
	/*echo "<pre>";
	var_dump($ApartmentState_initDataByIdApartment_arrResult);
	echo "</pre>";*/
	
	$GuestEntered->idApartmentState = $ApartmentState_initDataByIdApartment_arrResult["result"]["result"][0]["id"];
	$GuestEntered->idEmployee = $_COOKIE['id_user'];
	$GuestEntered_initByIdApartmentState_arr = json_decode($GuestEntered->initByIdApartmentState(), true);
?>