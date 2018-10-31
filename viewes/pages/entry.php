<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 1) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartmentState_initDataByIdApartment.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfoById.php");?>
<?php //include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_apartmentState_getApartmentStateIdByIdApartment.php");?>
<?php
	/*echo "<pre>";
	var_dump($ApartmentState_initDataByIdApartment_arrResult);
	echo "</pre>";*/
	if($ApartmentState_initDataByIdApartment_arrResult["status"] === true){
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartmentState_getInfoByIdApartment.php");?>
<?php //include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_guestEntered_initByIdApartmentState.php");?>
<?php
	/*echo "<pre>";
	var_dump($ApartmentState_getInfoByIdApartment_arr);
	echo "</pre>";*/
?>
<div class="entry">
	<div class="form">
		<div class="titlePage">
			<b><?=$Apartment_GetInfoById_ArrResult["result"]["adres"];?></b> (заезд)
		</div>
		<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
		<form method="post" id="sendEntry">
			<input 
				type="hidden" 
				name="id_apartment_state" 
				value="<?=$ApartmentState_getInfoByIdApartment_arr["result"][0]["id"];?>">
			<input 
				type="hidden" 
				name="id_employee" 
				value="<?=$_COOKIE["id_user"];?>">
			
			<div class="title">
				Дата заезда
			</div>
			<div>
				<input 
					value="<?=$ApartmentState_getInfoByIdApartment_arr["result"][0]["date_entry"];?>"
					type="date" 
					name="date_entry">
			</div>
			
			<div class="title">
				Количество взрослых
			</div>
			<div>
				<input 
					value="<?=$ApartmentState_getInfoByIdApartment_arr["result"][0]["number_of_adults"];?>" 
					type="number" 
					name="number_of_adults">
			</div>
			
			<div class="title">
				Количество детей
			</div>
			<div>
				<input 
					value="<?=$ApartmentState_getInfoByIdApartment_arr["result"][0]["number_of_children"];?>" 
					type="number" 
					name="number_of_children">
			</div>
			
			<div class="title">
				Сумма наличные
			</div>
			<div>
				<input 
					value="<?=$ApartmentState_getInfoByIdApartment_arr["result"][0]["amount_in_cash"];?>"
					type="number" 
					name="amount_in_cash">
			</div>
			
			<div class="title">
				Залог
			</div>
			<div>
				<input 
					value="1"
					<?php
						if((bool)$ApartmentState_getInfoByIdApartment_arr["result"][0]["pledge"] === true)
							echo "checked";
					?>
					type="checkbox" 
					name="pledge">
			</div>
			<div>
				<button onClick="_GuestEntered.sendData(); return false;">Сохранить</button>
			</div>
		</form>
	</div>
</div>
<?php
	}
?>
<script src="/models/javascript/model_guestEntered.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_guestEntered.js');?>"></script>
<script>
	var _GuestEntered = new GuestEntered();
</script>