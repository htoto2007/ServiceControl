<?php
	if(!class_exists('TitlesGeneralsExpenses'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
		
	$TitlesGeneralsExpenses = new TitlesGeneralsExpenses();
	$TitlesGeneralsExpenses_getInfo_arr = json_decode($TitlesGeneralsExpenses->getInfo(), true);
?>