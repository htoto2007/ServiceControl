<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfo.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartmentState_getInfoByIdApartment.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_accessToApartments.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_ApartmentCleaning.php");?>

<script src="/models/javascript/model_apartmentStateTable_dinamicColumn.js"></script>
<script> 
	var _DinamicColumn = new DinamicColumn();
	var apartmentCounter = 0;
	var dateCellsCounter = 0;
</script>
<script src="/models/javascript/model_apartmentCleaning.js"></script>
<script>
	var _ApartmentCleaning = new ApartmentCleaning();
</script>

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
		<div class="dateControl">
			<button onClick="
				goToPeriod();
			">Вывести</button>
		</div>
	</div>
	<div style="height:190px;"></div>
</div>
<div>
	<div 
		class="datePeriodMark" 
		onClick="
			$('div.datePeriod').slideToggle(500);
			$('div.dateBlock').slideToggle(500, function(){
					_DinamicColumn.updatePosition();
			});
			
		">показать / скрыть</div>
	<div style="height:20px;"></div>
</div>
<script>
	function goToPeriod(){
		var url = "/<?=$PAGE;?>/"+$("input.date1").val()+"/"+$("input.date2").val()+"/";
		_pageLoader.redirectTo(url, false);
	}
</script>
<div class="out"></div>
<div class="table" style=" margin: 0; position: absolute;">
	<table>
		<tr  class="header0">
			<th rowspan="3" class="headerColumnFlat">
				<b>квартира</b>
			</th>
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
				$sumCash = array();
				$dateCellsCounter = 0;
				for($i = 0; $i < $period; $i++){?>
					<script>
						_DinamicColumn.apartmentDate["<?=$dateCellsCounter?>"] = "<?=date_format($date, 'd')." ".$monthArr[date_format($date, 'M')];?>";
					</script>
                    <?php
						$dateCellsCounter++;
					?>
                    <?php if( strtotime(date('Y-m-d')) === strtotime(date_format($date, 'Y-m-d')) ){?>
						<th colspan="3" class="date<?=$i;?>" style="background-color:#2186FF; color:#FFFFFF;" id="currentDate">
							<a name="currentDate"></a>
							<b><?php
								echo date_format($date, 'd')." ".$monthArr[date_format($date, 'M')];
								date_add($date, date_interval_create_from_date_string('1 days'));
							?></b>						
						</th>
					<? }else{ ?>
						<th colspan="3" class="date<?=$i;?>">
							<b><?php
								echo date_format($date, 'd')." ".$monthArr[date_format($date, 'M')];
								date_add($date, date_interval_create_from_date_string('1 days'));
							?></b>						
						</th>
			<?php
					}
				}
			?>
			<th colspan="3" rowspan="2">
				итог по количеству человек и выездов
			</th>
			<th>Уборки</th>
		</tr>
		<tr class="header1">
			<?  $date = new DateTime($startDate);
				for($i = 0; $i < $period; $i++){ 
					if( strtotime(date('Y-m-d')) === strtotime(date_format($date, 'Y-m-d')) ){?>
						<th colspan="2" class="countPersons<?=$i;?>" style="background-color: #BAD9FF;">
							Кол-во человек
						</th>
						<th rowspan="2" class="sum<?=$i;?>" style="background-color:#BAD9FF;">
							Сумма
						</th>
					<? }else{ ?>
						<th colspan="2" class="countPersons<?=$i;?>">
							Кол-во человек
						</th>
						<th rowspan="2" class="sum<?=$i;?>">
							Сумма
						</th>
					<? } ?>
					<?php date_add($date, date_interval_create_from_date_string('1 days'));?>
			<? } ?>

		</tr>	

		<tr  class="header2">
			<?  $date = new DateTime($startDate);
				for($i = 0; $i < $period; $i++){ 
					if( strtotime(date('Y-m-d')) === strtotime(date_format($date, 'Y-m-d')) ){?>
						<th class="parent<?=$i;?>" style="background-color: #BAD9FF;">
							ВЗР
						</th>
						<th class="child<?=$i;?>" style="background-color: #BAD9FF;">
							Д
						</th>
					<? }else{ ?>
						<th class="parent<?=$i;?>">
							ВЗР
						</th>
						<th class="child<?=$i;?>">
							Д
						</th>
					<? } ?>
					<?php date_add($date, date_interval_create_from_date_string('1 days'));?>
			<? } ?>
			<th >
				Взрослые
			</th>
			<th >
				Дети
			</th>
			<th >
				Кол-во выездов
			</th>
		</tr>
		<?php
			// итератор адресов
			foreach($apartment_getInfo_arrResult["result"] as $j => $apartment_result){
		?>
				<tr >
					<td>
						<?php /*?>// выводим левую колонку с названиями квартир<?php */?>
						<b><?=$apartment_result["adres"];?></b>
					</td>
					
					<?php
						$currentDate = new DateTime($startDate);
						// получаем список статистик по адресу
						for($i = 0; $i < $period; $i++){
							// получаем статистику по квартире и дате
							$ApartmentState->idApartment = $apartment_result["id"];
							$ApartmentState->dateValue = date_format($currentDate, 'Y-m-d');
							
							$apartmentState_getInfoByIdApartmentAndDates_arr = json_decode(
								$ApartmentState->getInfoByIdApartmentAndDates(), 
								true
							);
							if(count($apartmentState_getInfoByIdApartmentAndDates_arr["result"]) > 0){
						?>
								<td style="padding:0px;" colspan="3">
								<?php
									foreach($apartmentState_getInfoByIdApartmentAndDates_arr["result"] as $apartmentState_result){
										$dataEntry = strtotime($apartmentState_result["date_entry"]);
										$dateExit = strtotime($apartmentState_result["date_exit"]);
										$isExit = $apartmentState_result["is_exit"];
										$currDate = strtotime(date_format($currentDate, 'Y-m-d'));
										if($dataEntry === $currDate){?>
											<div><div class="marker entry" title="заезд"></div></div>
										<?}
										if($dateExit === $currDate){?>
											<div><?
												if((boolean)$apartmentState_result["apartment_is_ready"] === true){?>
													<i class="fas fa-thumbs-up" style="color: #056FFF;" title="Квартира готова"></i>
												<? }elseif((boolean)$apartmentState_result["is_exit"] === true){?>
													<i class="fas fa-door-open" style="color: #FD0004;" title="гость выехал"></i>
												<?}else{?>
												<div class="marker exit" title="Выезд"></div>
												<?}?>
											</div>
										<?}
										if(($dateExit !== $currDate) &&
										   ($dataEntry !== $currDate)){?>
											<div><div class="marker surrenders" title="Есть прожиапющие"></div>
										<?}
									}
								?>
								<div style="text-align: left; color: #C000FF;">
									<i class="fas fa-info-circle"  
										onMouseOver="getDateInfo('<?=date_format($currentDate, 'Y-m-d');?><br><?=$apartment_result["adres"];?>', this);"
									   onMouseOut="deleteDateInfo(this)"></i>
									</div>
								</td>
								
						<?php
							}else{
								//не арендовано;
						?>
								<td colspan="3" >
									<div style="text-align: left; color: #C000FF;">
									<i class="fas fa-info-circle"  
										onMouseOver="getDateInfo('<?=date_format($currentDate, 'Y-m-d');?><br><?=$apartment_result["adres"];?>', this);"
									   onMouseOut="deleteDateInfo(this)"></i>
									</div>
								</td>
						<?php
							}
							date_add($currentDate, date_interval_create_from_date_string((1 + $dayes).' days'));
						}
					?>
					<td><?=$sumAdults;?></td>
					<td><?=$sumChildren;?></td>
					<td><?=$leftCounter;?></td>
					<td>
						<?php
							
							$ApartmentState->idApartment = $apartment_result["id"];
							$ApartmentState->dateStart = date_format($dt1, 'Y-m-d');
							$ApartmentState->dateEnd = date_format($dt2, 'Y-m-d');
							$apartmentState_isExitByDatePeriodByIdApartment = json_decode($ApartmentState->isExitByDatePeriodByIdApartment(), true);
							$ApartmentCleaning->idApartment = $apartment_result["id"];
							$ApartmentCleaning->startDate = date_format($dt1, 'Y-m-d');
							$ApartmentCleaning->endDate = date_format($dt2, 'Y-m-d');
							$ApartmentCleaning_getInfoByDatePeriodAndIdApartment = json_decode($ApartmentCleaning->getInfoByDatePeriodAndIdApartment(), true);
							echo count($ApartmentCleaning_getInfoByDatePeriodAndIdApartment["result"]) + count($apartmentState_isExitByDatePeriodByIdApartment["result"]);
							//print_r($ApartmentCleaning_getInfoByDatePeriodAndIdApartment);
						?>
					</td>
				</tr>
		<?php
			}
		?>
		<tr>
			<th>
				ИТОГ ПО СУММЕ
			</th>
			<? for($i = 0; $i < $period; $i++){ ?>
				<td colspan="3">
					<?
						if($sumCash[$i] > 0) echo "<b>".$sumCash[$i]." руб.</b>";
					?>
				</td>
			<? } ?>
		</tr>
	</table>
</div>
<script src="/models/javascript/model_apartmentState.js"></script>
<script>
	_ApartmentState = new ApartmentState();
	
</script>
<script>
	function getDateInfo(value , elem){
		$(elem).css('color', '#ff0000');
		$('html').append('<div class="dateInfo">');
		$('div.dateInfo').css('position', 'fixed');
		$('div.dateInfo').css('top', '0px');
		$('div.dateInfo').css('left', '0px');
		$('div.dateInfo').css('padding', '10px');
		$('div.dateInfo').css('z-index', '150');
		$('div.dateInfo').css('background-color', '#0000ff');
		$('div.dateInfo').css('width', '100%');
		$('div.dateInfo').css('color', '#fff');
		$('div.dateInfo').html(value);
	}
	
	function deleteDateInfo(elem){
		$('div.dateInfo').remove();
		$(elem).css('color', '#C000FF');
	}
</script>