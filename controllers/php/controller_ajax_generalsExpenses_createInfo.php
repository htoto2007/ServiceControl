<?php
	if(!class_exists('GeneralsExpenses'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");

	/*echo "<pre><div style='text-align: left; font-size: 10pt; color: #000;'>";
	var_dump($apartment_getInfo_arrResult);
	echo "</div></pre>";*/

	$Apartment = new Apartment();
	if($_POST["id_apartment"][0] === "0"){
		$apartment_getInfo_arrResult = json_decode($Apartment->getInfo(), true);
	}else{
		$arr2;
		foreach($_POST["id_apartment"] as $key => $id){
			$Apartment->id = $id;
			$arr = json_decode($Apartment->getInfoById(), true);
			$arr2["result"][$key] = $arr["result"];
		}
		$apartment_getInfo_arrResult = $arr2;
	}
	/*echo "<pre><div style='text-align: left; font-size: 10pt; color: #000;'>";
	var_dump($apartment_getInfo_arrResult["result"]);
	echo "</div></pre>";
	exit();*/
	$GeneralsExpenses = new GeneralsExpenses();
	$GeneralsExpenses->idTitlesGeneralsExpenses = $_POST["id_titles_generals_expenses"];
	$GeneralsExpenses->arrApartments = $apartment_getInfo_arrResult["result"];
	$GeneralsExpenses->price = $_POST["price"];
	$GeneralsExpenses->idEmployee = $_POST["id_employee"];
	$GeneralsExpenses->startDate = $_POST["start_date"];
	$GeneralsExpenses->endDate = $_POST["end_date"];
	$GeneralsExpenses->comment = $_POST["comment"];
	echo $GeneralsExpenses->create();
?>