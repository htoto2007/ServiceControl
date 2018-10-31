<?php
	if(!class_exists('PrivateExpenses'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$PrivateExpenses = new PrivateExpenses();
	$PrivateExpenses->comment = $_POST["comment"];
	$PrivateExpenses->price = $_POST["price"];
	$PrivateExpenses->idEmployee = $_POST["id_employee"];
	$PrivateExpenses->idApartment = $_POST["id_apartment"];
	echo $PrivateExpenses->create();
?>