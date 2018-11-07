<?php
//print_r($_POST);	
if(!class_exists('AccessToApartments'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
	$ApartmentCleaning 					= new ApartmentCleaning();
	
	if($_POST['id_cleaning'] !== ""){ 
		$ApartmentCleaning->id = $_POST['id_cleaning'];
		$ApartmentCleaning->deleteById();
	}
	$ApartmentCleaning->idApartment 	= $_POST['id_apartment'];
	$ApartmentCleaning->date 			= $_POST['date_cleaning'];
	$ApartmentCleaning->idEmployee 		= $_POST['id_employee'];
	echo $ApartmentCleaning->add();
?>