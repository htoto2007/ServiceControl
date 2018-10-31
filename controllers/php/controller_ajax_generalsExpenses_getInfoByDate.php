<?php
	if(!class_exists('GeneralsExpenses'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	$GeneralsExpenses = new GeneralsExpenses();
	//$GeneralsExpenses->dateValue = 365;
	$generalsExpenses_getInfoByDate_arr = json_decode($GeneralsExpenses->getInfo(), true);
?>