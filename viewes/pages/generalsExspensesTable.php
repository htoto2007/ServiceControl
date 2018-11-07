<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfo.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_titlesGeneralsExpenses_getInfo.php");?>
<?php
	/*echo "<pre>";
	var_dump($apartment_getInfo_arrResult);
	echo "</pre>";*/
?>
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
			<button onClick="goToPeriod();">Вывести</button>
		</div>
	</div>
	<div style="height:190px;"></div>
</div>
<div>
	<div 
		class="datePeriodMark" 
		onClick="
			$('div.datePeriod').slideToggle(500);
			$('div.dateBlock').slideToggle(500);
		">показать / скрыть</div>
	<div style="height:20px;"></div>
</div>
<script>
	function goToPeriod(){
		var url = "/<?=$PAGE;?>/"+$("input.date1").val()+"/"+$("input.date2").val()+"/";
		_pageLoader.redirectTo(url, false);
	}
</script>

<table>
	<tr>
		<th rowspan="1">
			Расход
		</th>
		<th rowspan="1">
			квартира/дата
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
			
			for($i = 0; $i < $period; $i++){
				if( strtotime(date('Y-m-d')) === strtotime(date_format($date, 'Y-m-d')) ){?>
					<th colspan="1" style="background-color:#2186FF; color:#FFFFFF;" id="currentDate">
						<a name="currentDate"></a>
						<b><?php
							echo date_format($date, 'd')." ".$monthArr[date_format($date, 'M')];
							date_add($date, date_interval_create_from_date_string('1 days'));
						?></b>						
					</th>
				<? }else{ ?>
					<th colspan="1">
						<b><?php
							echo date_format($date, 'd')." ".$monthArr[date_format($date, 'M')];
							date_add($date, date_interval_create_from_date_string('1 days'));
						?></b>						
					</th>
		<?php
				}
			}
		?>
		<th>
			ИТОГО
		</th>
		<th>
			Всего на каждую квартиру
		</th>
	</tr>
	
	<?php 
		// идем по списку затрат
		$sumPrice3 = 0;
		$sumPrice4 = array();
		foreach($TitlesGeneralsExpenses_getInfo_arr["result"] as $keyTitle => $title){ ?>
		<tr>
			<th rowspan="<?=count($apartment_getInfo_arrResult["result"]) + 1;?>">
				<?php echo $title["title"]; ?>
			</th>
		</tr>
		<?php 
			// идем по списку квартир
			$sumPrice2 = 0;
			foreach($apartment_getInfo_arrResult["result"] as $keyArrApartment => $arrApartment){ ?>
		<tr>
			<th>
				<?php
					echo $arrApartment["adres"];
				?>
			</th>
			<?php
				$GeneralsExpenses = new GeneralsExpenses();
				$date = new DateTime($startDate);
				$sumPrice1 = 0;
				// идем по дате
				for($i = 0; $i < $period; $i++){
					$GeneralsExpenses->dateValue = date_format($date, 'Y-m-d');
					$GeneralsExpenses->idTitlesGeneralsExpenses = $title["id"];
					$GeneralsExpenses->idApartment = $arrApartment["id"];
					$generalsExpenses_getInfoByDateAndIdTitleGeneralsExpenses_arr = json_decode($GeneralsExpenses->getInfoByDateAndIdTitleGeneralsExpensesAndIdApartment(), true);
					
					
					/*echo date_format($date, 'Y-m-d')."<br>";
					echo $title["id"]."<br>";
					echo $arrApartment["id"]."<br>";*/
					
					//echo "<pre>";
					//var_dump($generalsExpenses_getInfoByDateAndIdTitleGeneralsExpenses_arr);
					//echo "</pre>";
					// проверяем на пустоту массив квартир в общих расходах
					//if($arrApartmentsFromGEneralsExpenses !== NULL){
						
						$res = 0;
						if(count($generalsExpenses_getInfoByDateAndIdTitleGeneralsExpenses_arr["result"]) > 0){
							$infoAboutExpenses = "";
							foreach($generalsExpenses_getInfoByDateAndIdTitleGeneralsExpenses_arr["result"] as $generalsExpenses_result){
								
								$infoAboutExpenses .= $generalsExpenses_result["start_date"]." - ".$generalsExpenses_result["end_date"]."<br>";
								$infoAboutExpenses .= "<b>Комментарий:</b> ".$generalsExpenses_result["comment"]."<br>";
								
								$date1 = $generalsExpenses_result["start_date"];
								$date2 = $generalsExpenses_result["end_date"];
								$date1 = date_create($date1);
								$date2 = date_create($date2);
								$interval = date_diff($date1,$date2);
								$days = (int)$interval->format('%R%a');
								$days += 1;
								$price = $generalsExpenses_result["price"];
								// идем по списку квартир, включеных в затраты
								//echo "<pre>";
								//var_dump($arrApartments);
								//echo "</pre>";
								
								$arrApartmentsFromGEneralsExpenses = json_decode($generalsExpenses_result["arr_apartments"],true);
								
								foreach($arrApartmentsFromGEneralsExpenses as $apartmentFromGeneralsExpenses){
									// если квартира из таблицы совпадается с квартирой из общих расходов
									if(strcasecmp($arrApartment["id"], $apartmentFromGeneralsExpenses["id"]) == 0){
										$res += $price / count($arrApartmentsFromGEneralsExpenses) / $days;
										$sumPrice1 += $price / count($arrApartmentsFromGEneralsExpenses) / $days;
										$sumPrice2 += $price / count($arrApartmentsFromGEneralsExpenses) / $days;
										$sumPrice3 += $price / count($arrApartmentsFromGEneralsExpenses) / $days;
										$sumPrice4[$keyArrApartment] += $price / count($arrApartmentsFromGEneralsExpenses) / $days;
									}
								}
							}
							?>
								<td>
									<?=round($res, 3);?> Руб.
									<i class="fas fa-calendar-alt" 
										onMouseOver="
													 getDateInfo(
													 	'<?=date_format($date, 'Y-m-d');?><br>' + 
													 	'<?=$title["title"]; ?><br>' +
														'<?=$arrApartment["adres"];?><br>' + 
									   					'<?=$infoAboutExpenses;?>', this);
										"
										onMouseOut="deleteDateInfo(this)">
								</td>
							<?
						}else{?>
							<td>
								<i class="fas fa-calendar-alt" 
										onMouseOver="
													 getDateInfo(
													 	'<?=date_format($date, 'Y-m-d');?><br>' + 
													 	'<?=$title["title"]; ?><br>' +
														'<?=$arrApartment["adres"];?>', this);
										"
										onMouseOut="deleteDateInfo(this)">
							</td>
						<? 
						}
					date_add($date, date_interval_create_from_date_string('1 days'));
				}
			?>
			<th>
				<?php /*?>ИТОГО1<?php */?>
				<?=round($sumPrice1, 3);?>  Руб.
			</th>
			<? if($keyTitle === count($TitlesGeneralsExpenses_getInfo_arr["result"]) - 1){ ?>
				<th>
					<?=round($sumPrice4[$keyArrApartment], 3);?> Руб.
				</th>
			<? } ?>
		</tr>
		
		<?php } ?>
		<tr>
			<th>
				ИТОГО
			</th>
			<th colspan="<?=$days + 2;?>">
				<?=$sumPrice2;?>
			</th>
		</tr>
	<?php } ?>
	<tr>
		<th>
			ВСЕГО
		</th>
		<th colspan="<?=$days + 3;?>">
			<?=$sumPrice3;?> РУб.
		</th>
	</tr>
</table>
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
		//$('div.dateInfo').css('max-height', '5%');
		$('div.dateInfo').css('color', '#fff');
		$('div.dateInfo').css('scroll-behavior', 'auto');
		$('div.dateInfo').html(value);
	}
	
	function deleteDateInfo(elem){
		$('div.dateInfo').remove();
		$(elem).css('color', '#000');
	}
</script>