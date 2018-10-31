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
			foreach($apartment_getInfo_arrResult["result"] as $j => $result){
		?>
				<tr >
					<?php
						$apartmentCounter++;
					?>
					<td class="apartment<?=$apartmentCounter;?>">
						<?php /*?>// выводим левую колонку с названиями квартир<?php */?>
						<b><?=$result["adres"];?></b>

						<script>
							_DinamicColumn.apartmentAdreses["<?=$apartmentCounter;?>"] = "<?=$result["adres"];?>";
						</script>
					</td>
					
					<?php
						$sumAdults = 0;
						$sumChildren = 0;
						$leftCounter = 0;
						$currentDate = new DateTime($startDate);
						// получаем список статистик по адресу
						for($i = 0; $i < $period; $i++){
							// получаем статистику по квартире и дате
							$ApartmentState->idApartment = $result["id"];
							$ApartmentState->dateValue = date_format($currentDate, 'Y-m-d');
							$apartmentState_getInfoByIdApartmentAndDates_arr = json_decode(
								$ApartmentState->getInfoByIdApartmentAndDates(), 
								true
							);

							$dVal1 = $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["date_exit"];
							$dVal2 = $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["date_entry"];
							
							// въезд, выезд и следующий въезд*/

							$daysLeft = $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["daysLeft"];
							$totalDayes = $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["totalDays"];

							if($apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id"] !== NULL){
						?>
								<td style="padding:0px;" colspan="3">
									<table width="100%" height="100%">
										<?php
											if(((int)$apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["daysLeft"] === 0)){ // если конец проживания
										?>
												<tr>
													<?php
														if(($apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["apartment_is_ready"] === "1")){
															$leftCounter++;
													?>
														<td style="background-color: #2186FF; color:#FFFFFF;" colspan="3">Квартира готова</td>
													<?php
														}else{
													?>
														<td style="background-color: #DDC106;" colspan="3">Выезд</td>
													<? } ?>
												</tr>
										<?php
											}
										?>

										<?php	
											if($daysLeft === $totalDayes){ // если начало проживания
										?>
												<tr>
													<td style="background-color:#62F961;">
														<?php
															echo $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["number_of_adults"];
															$sumAdults += $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["number_of_adults"]; 
														?>
													</td>
													<td style="background-color:#62F961;">
														<?php
															echo $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["number_of_children"];
															$sumChildren += $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["number_of_children"]; 
														?>
													</td>
													<td style="background-color:#62F961;">
														<?php
															if($apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["amount_in_cash_is_received"] === "1") 
																$checked = "checked";
															else 
																$checked = "";
														?>	
														<form 
															method="post" 
															id="checkbox<?=$apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id"];?>">
															<input 
																type="hidden" 
																name="id_apartment_state" 
																value="<?=$apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id"];?>">
															<input 
																value="1"
																name="amountInCashSsReceived"
																type="checkbox" <?=$checked;?> 
																onChange="
																	var id = '#checkbox<?=$apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id"];?>'
																	_ApartmentState.updateAmountInCashSsReceived(id);
																">
														</form>
														<?php
															echo $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["amount_in_cash"]." руб.";
															$sumCash[$i] += (int)$apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["amount_in_cash"];
														?>
													</td>
												</tr>
										<?php
											}
										?>
										<?php
											// последний день аренды и не кто не въехал следующим
											if((isset($apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["daysLeft"])) && 
												((int)$apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["daysLeft"] === 0)){ // если конец проживания
										?>
												<tr>
													<?php
														if(($apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["apartment_is_ready"] === "1")){
															$leftCounter++;
													?>
														<td style="background-color: #2186FF; color:#FFFFFF;" colspan="3">Квартира готова</td>
													<?php
														}else{
													?>
														<td style="background-color: #DDC106;" colspan="3">Выезд</td>
													<? } ?>
												</tr>
										<?php
											}
										?>
										<?php
											// если в день выезда заехали вторые
											if($apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["id"] !== NULL){ // если начало проживания второй статистики
										?>
												<tr>
													<td style="background-color:#62F961;">
														<?php
															echo $apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["number_of_adults"];
															$sumAdults += $apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["number_of_adults"]; 
														?>
													</td>
													<td style="background-color:#62F961;">
														<?php
															echo $apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["number_of_children"];
															$sumChildren += $apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["number_of_children"]; 
														?>
													</td>
													<td style="background-color:#62F961;">
														<?php
															if($apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["amount_in_cash_is_received"] === "1") 
																$checked = "checked";
															else 
																$checked = "";
														?>	
														<form 
															method="post" 
															id="checkbox<?=$apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["id"];?>">
															<input 
																type="hidden" 
																name="id_apartment_state" 
																value="<?=$apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["id"];?>">
															<input 
																value="1"
																name="amountInCashSsReceived"
																type="checkbox" <?=$checked;?> 
																onChange="
																	var id = '#checkbox<?=$apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id"];?>'
																	_ApartmentState.updateAmountInCashSsReceived(id);
																">
														</form>
														<?php
															
															echo $apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["amount_in_cash"]." руб.";
															$sumCash[$i] += (int)$apartmentState_getInfoByIdApartmentAndDates_arr["result"][1]["amount_in_cash"];
														?>
													</td>
												</tr>
										<?php
											}
											
											// статус "Арендовано"
											if(($apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id"] !== NULL) &&
												($daysLeft !== $totalDayes) &&
												((int)$daysLeft > 0)){ // определяем статус как кто-то живет
										?>
												<tr>
													<td style="background-color: #00B30E;" colspan="3">
                                                    	<?php
															$AccessToApartments->idApartment = $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id_apartment"];
															$accessToApartments_getInfoByIdApartment_arr = json_decode($AccessToApartments->getInfoByIdApartment(), true);?>
															<div style="width: 190px;">
															<i class="fas fa-broom" style="width: 25px;"></i>
															<?php
																$ApartmentCleaning->idApartment = $apartmentState_getInfoByIdApartmentAndDates_arr["result"][0]["id_apartment"];
																$ApartmentCleaning->date = date_format($currentDate, 'Y-m-d');
																$ApartmentCleaning_getInfoByDateAndIdApartment = json_decode($ApartmentCleaning->getInfoByDateAndIdApartment(), true);
															?>
															<form method="post" id="<?=$ApartmentCleaning->date.$ApartmentCleaning->idApartment?>">
																<input type="hidden" id="date" value="<?=$ApartmentCleaning->date;?>">
																<input type="hidden" name="idApartment" value="<?=$ApartmentCleaning->idApartment;?>">
																<input type="hidden" name="dateCleaning" value="<?=$ApartmentCleaning->date;?>">
																<input 
																	type="hidden" 
																	name="idCleaning" 
																	id="idCleaning" 
																	value="<?=$ApartmentCleaning_getInfoByDateAndIdApartment["result"]["id"];?>">
																<select 
																	name="employee" 
																	onChange="
																		_ApartmentCleaning.add('#<?=$ApartmentCleaning->date.$ApartmentCleaning->idApartment?>');
																	"
																	style="
																		font-size: 10pt; 
																		padding: 0px; 
																		min-width: 0px; 
																		width: 150px;">
																	<?php
																		$User->id = $ApartmentCleaning_getInfoByDateAndIdApartment["result"]["id_employee"];
                                                                    	$user_getInfoById_arr = json_decode($User->getInfoById(), true);
																	?>
                                                                    <option 
                                                                    	value="<?=$ApartmentCleaning_getInfoByDateAndIdApartment["result"]["id_employee"];?>">
                                                                        <?php
																			echo $user_getInfoById_arr["result"]["id"]." ";
                                                                            echo $user_getInfoById_arr["result"]["first_name"]." ";
                                                                            echo $user_getInfoById_arr["result"]["last_name"];
																		?>
                                                                     </option>
                                                                <?php
                                                                foreach($accessToApartments_getInfoByIdApartment_arr["result"] as $access){
                                                                    $User->id = $access['id_employee'];
                                                                    $user_getInfoById_arr = json_decode($User->getInfoById(), true);
                                                                    if($user_getInfoById_arr["result"]["id"] === null) continue;
                                                                    ?><option value="<?=$access['id_employee'];?>">
                                                                        <?php
                                                                            
                                                                            $User->id = $access['id_employee'];
                                                                            $user_getInfoById_arr = json_decode($User->getInfoById(), true);
                                                                            echo $user_getInfoById_arr["result"]["id"]." ";
                                                                            echo $user_getInfoById_arr["result"]["first_name"]." ";
                                                                            echo $user_getInfoById_arr["result"]["last_name"];
                                                                        ?>
                                                                    </option><?php
                                                                }?>
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </td>
												</tr>
										<?php
											}
										?>
									</table>
									<i class="fas fa-calendar-alt" 
										onMouseOver="getDateInfo('<?=date_format($currentDate, 'Y-m-d');?>');" 
										onMouseOut="deleteDateInfo()"></i>
								</td>
								
						<?php
							}else{
								//не арендовано;
						?>
								<td colspan="3">
									<i class="fas fa-calendar-alt" 
										onMouseOver="getDateInfo('<?=date_format($currentDate, 'Y-m-d');?>');" 
										onMouseOut="deleteDateInfo()"
								</td>
						<?php
							}
							date_add($currentDate, date_interval_create_from_date_string((1 + $dayes).' days'));
						}
					?>
					<td><?=$sumAdults;?></td>
					<td><?=$sumChildren;?></td>
					<td><?=$leftCounter;?></td>
					<td>e</td>
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
<script>
		_DinamicColumn.show();
		$(document).on('scroll', function(){
			setTimeout(function(){
				_DinamicColumn.updatePosition();
			}, 500);
		});
</script>
<script src="/models/javascript/model_apartmentState.js"></script>
<script>
	_ApartmentState = new ApartmentState();
	
</script>
<script>
	function getDateInfo(value){
		$('html').append('<div class="dateInfo">');
		$('div.dateInfo').css('position', 'fixed');
		$('div.dateInfo').css('top', '10px');
		$('div.dateInfo').css('left', '10px');
		$('div.dateInfo').css('z-index', '150');
		$('div.dateInfo').html(value);
	}
	
	function deleteDateInfo(){
		$('div.dateInfo').remove();
	}
</script>