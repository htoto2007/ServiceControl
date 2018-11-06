<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<script src="/models/javascript/model_apartment.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_apartment.js');?>"></script>
<script>
	var _apartment = new Apartment;
	setTimeout(function(){
	
	}, 5000);
</script>
<div class="addApartment">
	<div class="titlePage">
		Добавление/удаление квартир
	</div>
	<div class="form">
		<form id="addApartment">
			<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
			<div>
				<input type="text" name="adres" placeholder="Адрес квартиры">
			</div>
			<div>
				<button onClick="_apartment.add(); return false;">Добавить</button>
			</div>
		</form>
	</div>
	<div class="titlePage">
		Список квартир
	</div>
	<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfo.php");?>
	<div class="layouts">
		<script>
			var arrIds = [];
		</script>
		<?php
			$AccessToApartments = new AccessToApartments();
			foreach($apartment_getInfo_arrResult["result"] as $key => $apartment){
				$AccessToApartments->idEmployee = $_COOKIE['id_user'];
				$AccessToApartments->idApartment = $apartment["id"];
				$accessToApartments_getInfoByIdApartment_arr = json_decode($AccessToApartments->getInfoByIdEmployeeAndIdApartment(), true);
				/*echo "<pre>";
				var_dump($accessToApartments_getInfoByIdApartment_arr);
				echo "</pre>";*/
				if($accessToApartments_getInfoByIdApartment_arr["result"] !== false){
		?>
				<div class="layout" id="<?=$apartment['id'];?>">
					
					<script>
						arrIds[<?=$key;?>] = <?=$apartment["id"];?>
					</script>
					
					<div class="row" id="apartmentItem">
						<div class="header">
							<?=$apartment["adres"];?>
						</div>
						<div class="title">
							<a 
							href="/apartmentCard/<?=$apartment['id'];?>"
							class="linkButton"
							onClick="_pageLoader.goTo(event, this); return false;">
								<i class="fas fa-sign-in-alt"></i><i class="fas fa-sign-out-alt"></i>
							</a>
						</div>
						<div class="value">
							<form method="post" id="delete<?=$apartment['id'];?>">
								<input type="hidden" name="id" value="<?=$apartment['id'];?>">
								<input type="hidden" id="adres" value="<?=$apartment['adres'];?>">
								<button 
									class="no" 
									onClick="_apartment.deleteById('#delete<?=$apartment['id'];?>'); return false;">
									<i class="fas fa-trash-alt"></i>
								</button>
							</form>
						</div>
						<form class="sort" id="sort<?=$apartment['id'];?>">
							<input type="number" name="sort" class="sort" readonly value="<?=(int)$key;?>">
							<input type="hidden" name="id" value="<?=$apartment['id'];?>">
							
							<i class="fas fa-chevron-circle-down" 
								onClick="
									var elem = $(this).parent().parent().parent();
									_apartment.moveDown(elem);
										 _apartment.sortUpdate();
								"></i>
							<i class="fas fa-chevron-circle-up" 
								onClick="
									var elem = $(this).parent().parent().parent();
									_apartment.moveUp(elem);
										 _apartment.sortUpdate();
								"></i>
						</form>
						
					</div>
				</div>
			<?php	
				}
			}
		?>
	</div>
</div>
<script>
	_apartment.sortUpdate();
</script>