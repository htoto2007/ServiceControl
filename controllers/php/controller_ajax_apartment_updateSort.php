<?php
	if(!class_exists('Apartment'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	//print_r($_POST);
	$Apartment = new Apartment();
	$Apartment->sortable = (int)$_POST["sort"];
	$Apartment->id = (int)$_POST["id"];
	echo $Apartment->updateSort();
?>