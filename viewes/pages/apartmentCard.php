<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfoById.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartmentState_getInfoByIdApartment.php");?>
<?php
	/*echo "<pre>";
	var_dump($ApartmentState_getInfoByIdApartment_arr);
	echo "</pre>";*/
?>
<div class="apartmentCard">
	<div class="titlePage">
		<b><?=$Apartment_GetInfoById_ArrResult["result"]["adres"];?></b>
		въезды/выезды
	</div>
	<div class="layouts">
		<?
			foreach($ApartmentState_getInfoByIdApartment_arr["result"] as $ApartmentStateArrValues){
		?>
				<div class="layout">
					<div class="row">
						<div class="title">
							дата въезда
						</div>
						<div class="value">
							<?=$ApartmentStateArrValues["date_entry"];?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Дата выезда
						</div>
						<div class="value">
							<?=$ApartmentStateArrValues["date_exit"];?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Количество взрослых
						</div>
						<div class="value">
							<?=$ApartmentStateArrValues["number_of_adults"];?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Количество детей
						</div>
						<div class="value">
							<?=$ApartmentStateArrValues["number_of_children"];?> 
						</div>
					</div>
					<div class="row">
						<div class="title">
							Сумма наличные
						</div>
						<div class="value">
							<?=$ApartmentStateArrValues["amount_in_cash"];?> руб.
						</div>
					</div>
					<div class="row">
						<div class="title">
							Залог
						</div>
						<div class="value">
							<? 
								if((bool)$ApartmentStateArrValues["pledge"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Гость выехал
						</div>
						<div class="value">
							<? 
								if((bool)$ApartmentStateArrValues["is_exit"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Залог можно переводить
						</div>
						<div class="value">
							<? 
								if((bool)$ApartmentStateArrValues["deposit_can_be_transferred"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Залог вернулся гостю
						</div>
						<div class="value">
							<? 
								if((bool)$ApartmentStateArrValues["bail_returned"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Квартира готова
						</div>
						<div class="value">
							<? 
								if((bool)$ApartmentStateArrValues["apartment_is_ready"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Дата последнего редактирования
						</div>
						<div class="value">
							<?=$ApartmentStateArrValues["date_edit"];?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Кем редактировалось
						</div>
						<div class="value">
							<?php
								$User = new User();
								$User->id = $ApartmentStateArrValues["id_employee"];
								$user_getInfoById_arr = json_decode($User->getInfoById(), true);
								echo $user_getInfoById_arr["result"]["last_name"].
								" ".$user_getInfoById_arr["result"]["first_name"].
								" ".$user_getInfoById_arr["result"]["middle_name"];
							?>
						</div>
						<div>
							<form method="post" id="delete<?=$ApartmentStateArrValues["id"];?>">
								<input type="hidden" name="id_apartment_state" value="<?=$ApartmentStateArrValues['id'];?>">
								<input type="hidden" id="dates" value="<?=$ApartmentStateArrValues['date_entry']." - ".$ApartmentStateArrValues['date_exit'];?>">
								<button 
									class="no" 
									onClick="_ApartmentState.deleteById('#delete<?=$ApartmentStateArrValues['id'];?>'); return false;">
									<i class="fas fa-trash-alt"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
		<?
			}
		?>
	</div>
</div>
<script src="/models/javascript/model_apartmentState.js"></script>
<script>
	var _ApartmentState = new ApartmentState;
</script>