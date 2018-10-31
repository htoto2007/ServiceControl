<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 1) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_privateExpenses_getInfoByIdApartment.php");?>
<?php
	/*echo "<pre>";
	var_dump($privateExpenses_getInfoByIdApartment_arr);
	echo "</pre>";*/
?>

<div class="privateExpenses">
	<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
	<div class="titlePage">
		<b>Частные расходы</b>
	</div>
	<form method="post" id="createInfo">
		<input type="hidden" name="id_employee" value="<?=$_COOKIE['id_user'];?>">
		<input type="hidden" name="id_apartment" value="<?=$SUBPAGE;?>">
		<div>
			<textarea placeholder="Наименование расхода" name="comment"></textarea>
		</div>
		<div>
			<input type="number" name="price" placeholder="Сумма денег">
		</div>
		<div>
			<button onClick="_PrivateExpenses.createInfo(); return false;">Отправить</button>
		</div>
	</form>
	
	<div class="layouts">
		<?
			foreach($privateExpenses_getInfoByIdApartment_arr["result"] as $arrValues){
		?>
				<div class="layout">
					<div>
						<?=$arrValues["date"];?>
					</div>
					<div class="row">
						<div class="title">
							<?=$arrValues["comment"];?>
						</div>
						<div class="value">
							<?=$arrValues["price"];?> Руб.
						</div>
					</div>
				</div>
		<?php
			}
		?>
	</div>
</div>

<script type="text/javascript" src="/models/javascript/model_privateExpenses.js"></script>
<script>
	var _PrivateExpenses = new PrivateExpenses();
</script>