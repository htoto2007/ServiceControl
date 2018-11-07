<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_generalsExpenses_getInfoByDate.php");?>
<?php
	/*echo "<pre>";
	var_dump($generalsExpenses_getInfoByDate_arr);
	echo "</pre>";*/
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_titlesGeneralsExpenses_getInfo.php");?>
<?php
	/*echo "<pre>";
	var_dump($TitlesGeneralsExpenses);
	echo "</pre>";*/
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfo.php");?>
<?php
	/*echo "<pre>";
	var_dump($apartment_getInfo_arrResult);
	echo "</pre>";*/
?>
<div class="generalsExpenses">
	<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
	<div class="titlePage">
		<b>Общие расходы</b>
	</div>
	<form method="post" id="createInfo">
		<input type="hidden" name="id_employee" value="<?=$_COOKIE['id_user'];?>">
		<div>
			<select name="id_apartment[]" multiple>
				<option value="0">Все квартиры</option>
				<?php
					foreach($apartment_getInfo_arrResult["result"] as $apartment){
				?>
						<option value="<?=$apartment['id'];?>"><?=$apartment['adres'];?></option>
				<?php 
					}
				?>
			</select>
		</div>
		<div>
			<select name="id_titles_generals_expenses">
				<option value="">--Выбрать раздел--</option>
				<?php
					foreach($TitlesGeneralsExpenses_getInfo_arr["result"] as $title){
				?>
						<option value="<?=$title['id'];?>"><?=$title['title'];?></option>
				<?php 
					}
				?>
			</select>
		</div>
		<div>
			<textarea maxlength="900" name="comment" placeholder="Комментарий к расходу..."></textarea>
			
		</div>
		<div>
			<input type="number" name="price" placeholder="Сумма денег">
		</div>
		<div>
			<input type="date" name="start_date" placeholder="начальная дата">
		</div>
		<div>
			<input type="date" name="end_date" placeholder="конечная дата">
		</div>
		<div>
			<button onClick="_GeneralsExpenses.createInfo(); return false;">Отправить</button>
		</div>
	</form>
	<div class="layouts">
		<?php
			$TitlesGeneralsExpenses = new TitlesGeneralsExpenses();
			foreach($generalsExpenses_getInfoByDate_arr["result"] as $generalsExpenses_arrValues){
				$apartments = json_decode($generalsExpenses_arrValues["arr_apartments"], true);
				//echo "<pre>";
				//print_r($apartments);
				//echo "</pre>";
				
		?>
				<div class="layout">
					<div style="text-align: left;">
						<?php
							if(count($apartments) > 1){
								foreach($apartments as $apartment){
									/*echo "<pre>";
									var_dump($apartments);
									echo "</pre>";*/
									$Apartment = new Apartment();
									$Apartment->id = $apartment["id"];
									$apartment_getInfoById_arr = json_decode($Apartment->getInfoById(), true);
									
									echo "Для ".$apartment_getInfoById_arr["result"]["adres"]."<br>";
								}
							}
							elseif(count($apartments) === 1){
								$Apartment = new Apartment();
								$Apartment->id = $apartments[0]["id"];
								$apartment_getInfoById_arr = json_decode($Apartment->getInfoById(), true);
								/*echo "<pre>";
								var_dump($apartment_getInfoById_arr);
								echo "</pre>";*/
								echo "Для ".$apartment_getInfoById_arr["result"]["adres"];
							}
						?>
					</div>
					<div>
						<?=$generalsExpenses_arrValues["date"];?>
					</div>
					<div class="row">
						<div class="title">
							с <?=$generalsExpenses_arrValues["start_date"];?>
						</div>
						<div class="value">
							по <?=$generalsExpenses_arrValues["end_date"];?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							<?php
								$TitlesGeneralsExpenses->id = $generalsExpenses_arrValues["id_titles_generals_expenses"];
								$titlesGeneralsExpenses_getInfoById_arr = json_decode($TitlesGeneralsExpenses->getInfoById(), true);
								echo $titlesGeneralsExpenses_getInfoById_arr["result"]["title"];
								
							?>
						</div>
						<div class="value">
							<?=$generalsExpenses_arrValues["price"];?> Руб.
						</div>
						<div style="text-align: left;">
							<?="<b>Комментарий:</b> ".$generalsExpenses_arrValues["comment"];?>
						</div>
					</div>
					
					<div>
						<form method="post" id="delete<?=$generalsExpenses_arrValues["id"];?>">
							<input type="hidden" name="id_expenses" value="<?=$generalsExpenses_arrValues["id"];?>">
							<input type="hidden" id="info" value="<?=$titlesGeneralsExpenses_getInfoById_arr["result"]["title"];?></in> с <?=$generalsExpenses_arrValues["start_date"];?> - по <?=$generalsExpenses_arrValues["end_date"];?> на <?=$generalsExpenses_arrValues["price"];?> Руб.">
							<button 
								class="no" 
								onClick="_GeneralsExpenses.deleteById('#delete<?=$generalsExpenses_arrValues["id"];?>'); return false;">
								<i class="fas fa-trash-alt"></i>
							</button>
						</form>
					</div>
				</div>
		<?php
			}
		?>
	</div>
</div>
<script src="/models/javascript/model_generalsExpenses.js"></script>
<script>
	var _GeneralsExpenses = new GeneralsExpenses();
</script>