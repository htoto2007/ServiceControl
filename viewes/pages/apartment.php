<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartmentState_initDataByIdApartment.php");?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfoById.php");?>

<?php
	/*echo "<pre>";
	var_dump($ApartmentState_initDataByIdApartment_arrResult);
	echo "</pre>";*/
	if($ApartmentState_initDataByIdApartment_arrResult["status"] === true){
?>

<div class="apartment">
	<div class="menu">
		<div class="titlePage">
			<b><?=$Apartment_GetInfoById_ArrResult["result"]["adres"];?></b>
		</div>
		<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
		<a 
			href="/entry/<?=$SUBPAGE;?>" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Заезд</a>
		
		<a 
			href="/exit/<?=$SUBPAGE;?>" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Выезд</a>
		
		<a 
			href="/counters/<?=$SUBPAGE;?>" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Счетчики</a>
			
		<a 
			href="/privateExpenses/<?=$SUBPAGE;?>" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Расходы</a>
		
		<form id="sendReady">
			<input 
				type="hidden" 
				name="id_apartment_state" 
				value="<?=$ApartmentState_initDataByIdApartment_arrResult["result"]["result"][0]["id"];?>">
			<input 
				type="hidden" 
				name="apartment_is_ready" 
				value="1">
			<a 
				href="/counters/<?=$SUBPAGE;?>" 
				class="linkButton" 
				onClick="_ApartmentState.sendReady(); return false;">Квартира готова</a>
		</form>
	</div>
</div>
<?php
	}
?>
<script src="/models/javascript/model_apartmentState.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_apartmentState.js');?>"></script>
<script>
	var _ApartmentState = new ApartmentState();
</script>