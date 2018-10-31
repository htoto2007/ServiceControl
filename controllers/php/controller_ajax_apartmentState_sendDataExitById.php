<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$ApartmentState = new ApartmentState();
	/*echo "<pre>";
	var_dump($_POST);
	echo "</pre>";*/
	
	$ApartmentState->id 						= $_POST["id_apartment_state"];
	$ApartmentState->idEmployee 				= $_POST['id_employee'];
	$ApartmentState->isExit 					= $_POST["is_exit"];
	$ApartmentState->bailReturned 				= $_POST["bail_returned"];
	$ApartmentState->depositCanBeTransferred 	= $_POST["deposit_can_be_transferred"];
	$ApartmentState->dateExit 					= $_POST["date_exit"];
	echo $ApartmentState->sendDataExitById();
?>