<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 1) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfoById.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_counters_getInfoByIdApartment.php");?>
<?php
	/*echo "<pre>";
	var_dump($counters_sendData_arrResult);
	echo "</pre>";*/
?>
<div class="counters">
	<div class="form">
		<div class="titlePage">
			<b><?=$Apartment_GetInfoById_ArrResult["result"]["adres"];?></b> (счетчики)
		</div>
		<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
		<form method="post" id="sendEntry">
			<input type="hidden" name="id_apartment" value="<?=$SUBPAGE;?>">
			<input type="hidden" name="id_employee" value="<?=$_COOKIE['id_user'];?>">
			
			<div class="title">
				Сумма за газ
			</div>
			<div>
				<input 
					type="number" 
					name="gas_price">
			</div>
			
			<div class="title">
				Газ оплачен
			</div>
			<div>
				<input 
					value="1"
					type="checkbox" 
					name="gas_paid">
			</div>
			
			
			<div class="title">
				Показания счетчика электроэнергии
			</div>
			<div>
				<input 
					type="number" 
					name="shine_readings">
			</div>
			
			<div class="title">
				Сумма за электроэнергию
			</div>
			<div>
				<input 
					type="number" 
					name="shine_price">
			</div>
			
			<div class="title">
				Электроэнергия оплачена
			</div>
			<div>
				<input 
					value="1"
					type="checkbox" 
					name="shine_paid">
			</div>
			
			<div class="title">
				Показания счетчика воды
			</div>
			<div>
				<input 
					type="number" 
					name="water_readings">
			</div>
			
			<div class="title">
				Сумма за воду
			</div>
			<div>
				<input 
					type="number" 
					name="water_price">
			</div>
			
			<div class="title">
				Вода оплачена
			</div>
			<div>
				<input 
					value="1"
					type="checkbox" 
					name="water_paid">
			</div>
			
			<div class="title">
				Сумма за комунальные услуги
			</div>
			<div>
				<input 
					type="number" 
					name="communal_price">
			</div>
			
			<div class="title">
				Комунальные услуги оплачены
			</div>
			<div>
				<input 
					value="1"
					type="checkbox" 
					name="communal_paid">
			</div>
			<div>
				<button onClick="_Counters.sendData(); return false;">Сохранить</button>
			</div>
		</form>
	</div>
	
	<div class="layouts">
		<?
			foreach($counters_sendData_arrResult["result"] as $arrValues){
		?>
				<div class="layout">
					<div class="row">
						<div class="title">
							Дата снятия показаний
						</div>
						<div class="value">
							<?=$arrValues["date"];?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Сумма за газ
						</div>
						<div class="value">
							<?=$arrValues["gas_price"];?> руб.
						</div>
					</div>
					<div class="row">
						<div class="title">
							Газ оплачен
						</div>
						<div class="value">
							<? 
								if((bool)$arrValues["gas_paid"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Показания счетчика электроэнергии
						</div>
						<div class="value">
							<?=$arrValues["shine_readings"];?> кВт.
						</div>
					</div>
					<div class="row">
						<div class="title">
							Сумма за электроэнергию
						</div>
						<div class="value">
							<?=$arrValues["shine_price"];?> Руб.
						</div>
					</div>
					<div class="row">
						<div class="title">
							Электроэнергия оплачена
						</div>
						<div class="value">
							<? 
								if((bool)$arrValues["shine_paid"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Показания счетчика воды
						</div>
						<div class="value">
							<?=$arrValues["water_readings"];?> м<sup>2</sup>.
						</div>
					</div>
					<div class="row">
						<div class="title">
							Сумма за воду
						</div>
						<div class="value">
							<?=$arrValues["water_price"];?> Руб.
						</div>
					</div>
					<div class="row">
						<div class="title">
							Вода оплачена
						</div>
						<div class="value">
							<? 
								if((bool)$arrValues["water_paid"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							Сумма за комунальные услуги
						</div>
						<div class="value">
							<?=$arrValues["communal_price"];?> Руб.
						</div>
					</div>
					<div class="row">
						<div class="title">
							Комунальные услуги оплачены
						</div>
						<div class="value">
							<? 
								if((bool)$arrValues["communal_paid"] === true) echo "Да";
								else echo "Нет";
							?>
						</div>
					</div>
				</div>
		<?
			}
		?>
	</div>
</div>
<script type="text/javascript" src="/models/javascript/model_counters.js"></script>
<script>
	var _Counters = new Counters();
</script>