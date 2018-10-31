<?php
	if(!class_exists('ApartmentState'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
	print_r($_POST);
	$ApartmentState = new ApartmentState();
	$ApartmentState->id = $_POST["id_apartment_state"];
	$ApartmentState->amountInCashSsReceived = $_POST['amountInCashSsReceived'];
	echo $ApartmentState->updateAmountInCashSsReceived();
?>