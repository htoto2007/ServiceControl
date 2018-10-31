<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$ApartmentState = new ApartmentState();
	/*echo "<pre>";
	var_dump($_POST);
	echo "</pre>";*/
	
	$ApartmentState->id = $_POST["id_apartment_state"];
	$ApartmentState->numberOfAdults = $_POST["number_of_adults"];
	$ApartmentState->numberOfChildren = $_POST["number_of_children"];
	$ApartmentState->amountInCash = $_POST["amount_in_cash"];
	$ApartmentState->dateEntry = $_POST["date_entry"];
	$ApartmentState->pledge = $_POST["pledge"];
	$ApartmentState->idEmployee = $_POST['id_employee'];
	echo $ApartmentState->sendDataEntryById();
?>