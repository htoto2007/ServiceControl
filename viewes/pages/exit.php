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
	var_dump($ApartmentState_GetDataById_ApartmentArrResult);
	echo "</pre>";*/
	if($ApartmentState_initDataByIdApartment_arrResult["status"] === true){
?>
<?php //include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_guestLeft_initByIdApartmentState.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartmentState_getInfoByIdApartment.php");?>
<?php
	/*echo "<pre>";
	var_dump($ApartmentState_getInfoByIdApartment_arr);
	echo "</pre>";*/
?>
<div class="entry">
	<div class="form">
		<div class="titlePage">
			<b><?=$Apartment_GetInfoById_ArrResult["result"]["adres"];?></b> (выезд)
		</div>
		<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
		<form method="post" id="sendEntry">
			<input 
				type="hidden" 
				name="id_apartment_state" 
				value="<?=$ApartmentState_getInfoByIdApartment_arr["result"][0]["id"];?>">
			<input type="hidden" name="id_employee" value="<?=$_COOKIE["id_user"];?>">
			
			<div class="title">
				Дата выезда
			</div>
			<div>
				<input 
					type="date" 
					name="date_exit"
					 value="<?=$ApartmentState_getInfoByIdApartment_arr["result"][0]["date_exit"];?>">
			</div>			
			
			<div class="title">
				Гость выехал
			</div>
			<div>
				<input 
					value="1"
					<?php
						if((bool)$ApartmentState_getInfoByIdApartment_arr["result"][0]["is_exit"] === true)
							echo "checked";
					?>
					type="checkbox" 
					name="is_exit">
			</div>
			
			<div class="title">
				Залог вернулся гостю
			</div>
			<div>
				<input 
					value="1"
					<?php
						if((bool)$ApartmentState_getInfoByIdApartment_arr["result"][0]["bail_returned"] === true)
							echo "checked";
					?>
					type="checkbox" 
					name="bail_returned">
			</div>
			
			<div class="title">
				Залог можно переводить
			</div>
			<div>
				<input 
					value="1"
					<?php
						if((bool)$ApartmentState_getInfoByIdApartment_arr["result"][0]["deposit_can_be_transferred"] === true)
							echo "checked";
					?>
					type="checkbox" 
					name="deposit_can_be_transferred">
			</div>

			<div>
				<button onClick="_GuestLeft.sendData(); return false;">Сохранить</button>
			</div>
		</form>
	</div>
</div>
<?php
	}
?>
<script src="/models/javascript/model_guestLeft.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_guestLeft.js');?>"></script>
<script src="/models/javascript/model_apartmentCleaning.js<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_apartmentCleaning.js');?>"></script>
<script>
	var _GuestLeft = new GuestLeft();
</script>