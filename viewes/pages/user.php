<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_user_getInfoById.php");?>

<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_accessToApartments_getInfoByIdApartment.php");?>
<?
	/*echo "<pre>";
	var_dump($user_getInfoById_arr);
	echo "</pre>";*/
?>
<div class="user">
	<div class="info">
		<div class="titlePage">
			<b>Пользователь</b>
		</div>
		<div>
			<? echo $user_getInfoById_arr["result"]["last_name"]." ".
					$user_getInfoById_arr["result"]["first_name"]." ".
					$user_getInfoById_arr["result"]["middle_name"]; ?>
		</div>
		<div>
			<? echo $user_getInfoById_arr["result"]["login"]; ?>
		</div>
	</div>

	<div class="layouts" >
		<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
		<form method="post" id="accessToApartment">
		<input type="hidden" value="<?=$SUBPAGE;?>" name="id_employee">
		<?
			$Apartment = new Apartment();
			$Apartment_GetInfo_ArrResult = json_decode($Apartment->getInfo(), true);
			foreach($Apartment_GetInfo_ArrResult["result"] as $apartment){
				$AccessToApartments->idEmployee = $SUBPAGE;
				$AccessToApartments->idApartment = $apartment["id"];
				$accessToApartments_getInfoByIdEmployeeAndIdApartment_arr = json_decode($AccessToApartments->getInfoByIdEmployeeAndIdApartment(), true);
				/*echo "<pre>";
				var_dump($accessToApartments_getInfoByIdEmployeeAndIdApartment_arr);
				echo "</pre>";*/
		?>
				<div class="layout">
					<div class="row">
						<div class="title">
							<?php echo $apartment["adres"];?>
						</div>
						<div class="value">
							<input 
								name="id_apartment[]" 
								value="<?=$apartment["id"];?>"
								type="checkbox" 
								<?php if($accessToApartments_getInfoByIdEmployeeAndIdApartment_arr["result"] !== false) echo "checked";?>>
						</div>
					</div>
					
				</div>
		<?
			}
		?>
			<div>
				<button onClick="_AccessToApartments.send(); return false;">применить</button>
			</div>
		</form>
	</div>
</div>
<script src="/models/javascript/model_accessToApartment.js"></script>
<script>
	var _AccessToApartments = new AccessToApartments();
</script>