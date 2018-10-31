<?php
	if(!class_exists('GeneralsExpenses'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	if($_POST["id_expenses"] !== NULL){
		$GeneralsExpenses = new GeneralsExpenses();
		$GeneralsExpenses->id = $_POST["id_expenses"];
		//echo $GeneralsExpenses->id;
		echo $GeneralsExpenses->deleteById();
	}else{
		//echo $GeneralsExpenses->id." - sssss";
		echo json_encode(array(
			"act" => __METHOD__." ".__LINE__,
			"status" => false,
			"result" => "IdExpenses is empty!"
		));
	}
?>