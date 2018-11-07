<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>

<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_ApartmentCleaning.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_accessToApartments.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartmentState.php");?>
<div class="dateBlock">
	<div class="datePeriod">
		<div class="title">с</div>
		<div class="dateControl">
			<input type="date" class="date1" value="<?=$SUBPAGE;?>">
		</div>
		<div class="title">по</div>
		<div class="dateControl">
			<input type="date" class="date2" value="<?=$MODEL;?>">
		</div>
		<div class="title">Сотрудник</div>
		<?php
			$jsonResult = $User->getInfo();
			$user_getInfo = json_decode($jsonResult, true);
		?>
		<div class="dateControl">
			<select class="user">
				<option value="<?=$SUBMODEL;?>">
				<?php
					$User->id = $SUBMODEL;
					$jsonResult = $User->getInfoById();
					$user_getInfoById = json_decode($jsonResult, true);
					echo $user_getInfoById["result"]["first_name"]." ";
					echo $user_getInfoById["result"]["last_name"];
				?>
				</option>
				<?php
				foreach($user_getInfo["result"] as $user){
				?>
				<option value="<?=$user["id"];?>">
					<?php
						echo $user["first_name"]." ";
						echo $user["last_name"];
					?>
				</option>
				<?php
				}
				?>
			</select>
		</div>
		<div class="dateControl">
			<button onClick="goToPeriod();">Вывести</button>
		</div>
	</div>
	<div style="height:250px;"></div>
</div>
<div>
	<div 
		class="datePeriodMark" 
		onClick="
			$('div.datePeriod').slideToggle(500);
			$('div.dateBlock').slideToggle(500, function(){});
			
		">показать / скрыть</div>
	<div style="height:20px;"></div>
</div>
<script>
	function goToPeriod(){
		var url = "/<?=$PAGE;?>/"+$("input.date1").val()+"/"+$("input.date2").val()+"/"+$("select.user").val()+"/";
		_pageLoader.redirectTo(url, false);
	}
</script>

<?php
	$dt1 = date_create($MODEL);
	$dt2 = date_create($SUBPAGE);
	$interval = date_diff($dt2,$dt1);
	$days = (int)$interval->format('%R%a');
	$days += 1;
	$period = $days;
	$startDate = $SUBPAGE;

	if($days <= 0){
		echo "ОШИБКА! Отрицательный период дат!";
		$dt1 = new DateTime("");
		$dt2 = new DateTime("");
		$interval = date_diff($dt2,$dt1);
		$days = (int)$interval->format('%R%a');
		$days += 1;
		$period = 1;
		$startDate = "";
	}
	
	$date = new DateTime($startDate);
	$monthArr = array(
		"Jan" => "Января",
		"Feb" => "Февраля",
		"Mar" => "Марта",
		"Apr" => "Апреля",
		"May" => "Мая",
		"Jun" => "Июня",
		"Jul" => "Июля",
		"Aug" => "Августа",
		"Sep" => "Сентября",
		"Oct" => "Октября",
		"Nov" => "Ноября",
		"Dec" => "Декабря",
	);
?>


<table>
	<tr>
		<th>#</th>
		<?php
		$AccessToApartments->idEmployee = $SUBMODEL;
		$jsonResult = $AccessToApartments->getInfoByIdEmployee();
		$AccessToApartments_getInfoByIdEmployee = json_decode($jsonResult, true);
		foreach($AccessToApartments_getInfoByIdEmployee["result"] as $accessToApartments){
		?>
			<th>
			<?php
				$Apartment->id = $accessToApartments["id_apartment"];
				$jsonResult = $Apartment->getInfoById();
				$Apartment_getInfoById = json_decode($jsonResult, true);
				echo $Apartment_getInfoById["result"]["adres"];
				
			?>
			</th>
		<?php
		}
		?>
	</tr>
	<?php
		$sumCleaning = 0;
		// дата
		for($i = 0; $i < $period; $i++){
	?>
	<tr>
		<th>
		<?php
			echo date_format($date, 'd')." ".$monthArr[date_format($date, 'M')];
			
		?>
		</th>
		<?php
			$AccessToApartments->idEmployee = $SUBMODEL;
			$jsonResult = $AccessToApartments->getInfoByIdEmployee();
			$AccessToApartments_getInfoByIdEmployee = json_decode($jsonResult, true);
			foreach($AccessToApartments_getInfoByIdEmployee["result"] as $accessToApartments){
				$ApartmentCleaning->date = date_format($date, 'Y-m-d');
				$ApartmentCleaning->idApartment = $accessToApartments["id_apartment"];
				$ApartmentCleaning->idEmployee = $SUBMODEL;
				$jsonResult = $ApartmentCleaning->getInfoByDateAndIdApartmentAndIdEmployee();
				$ApartmentCleaning_getInfoByDateAndIdApartmentAndIdEmployee = json_decode($jsonResult, true);
				?>
				<td>
				<?php
				$ApartmentState->idEmployee 	= $ApartmentCleaning->idEmployee;
				$ApartmentState->idApartment 	= $ApartmentCleaning->idApartment;
				$ApartmentState->dateValue 		= $ApartmentCleaning->date;
				$ApartmentState_isExitByDateByIdEmployeeByIdApartment = json_decode($ApartmentState->isExitByDateByIdEmployeeByIdApartment(), true);	
				
				if(count($ApartmentCleaning_getInfoByDateAndIdApartmentAndIdEmployee["result"]) > 0){
					$sumCleaning += count($ApartmentCleaning_getInfoByDateAndIdApartmentAndIdEmployee["result"]);
					echo " Промежуточных уборок (" . count($ApartmentCleaning_getInfoByDateAndIdApartmentAndIdEmployee["result"]) . ")";
				}
				if(count($ApartmentState_isExitByDateByIdEmployeeByIdApartment["result"]) > 0){
					$sumCleaning += count($ApartmentState_isExitByDateByIdEmployeeByIdApartment["result"]);
					echo " Выездов (" . count($ApartmentState_isExitByDateByIdEmployeeByIdApartment["result"]) . ")";
				}
				?>
				</td>
				<?php
			}
			?>
	</tr>
	<?php
			date_add($date, date_interval_create_from_date_string('1 days'));
		}
	?>
	<tr>
		<th>ИТОГО</th>
		<th colspan="<?=count($AccessToApartments_getInfoByIdEmployee["result"]);?>">
			<?=$sumCleaning;?>
		</th>
	</tr>
</table>