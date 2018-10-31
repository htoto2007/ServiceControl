<?php
	if(!class_exists('AccessToApartments'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
	$ApartmentCleaning = new ApartmentCleaning();
	$ApartmentCleaning->id = $_POST['idCleaning'];
	if($ApartmentCleaning->id !== "") $ApartmentCleaning->deleteById();
	$ApartmentCleaning->idApartment = $_POST['idApartment'];
	$ApartmentCleaning->date = $_POST['dateCleaning'];
	$ApartmentCleaning->idEmployee = $_POST['employee'];
	echo $ApartmentCleaning->add();
?>