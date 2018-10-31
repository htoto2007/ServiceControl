<?php
	$User = new User();
	$User->id = $_COOKIE[ "id_user" ];
	$user_getRankById_arr = json_decode( $User->getRankById(), true );
	if ( ( int )$user_getRankById_arr[ "result" ] < 1 )exit;
?>
<div class="apartmentList">
	<div class="titlePage">
		Список квартир
	</div>
	<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_apartment_getInfo.php");?>
	<div class="list"><?php
		$AccessToApartments = new AccessToApartments();
		foreach ( $apartment_getInfo_arrResult[ "result" ] as $apartment ) {
			$AccessToApartments->idEmployee = $_COOKIE[ 'id_user' ];
			$AccessToApartments->idApartment = $apartment[ "id" ];
			$accessToApartments_getInfoByIdApartment_arr = json_decode( $AccessToApartments->getInfoByIdEmployeeAndIdApartment(), true );
			if ( $accessToApartments_getInfoByIdApartment_arr[ "result" ] !== false ) {?>
			<div class="item">
				<a href="/apartment/<?=$apartment['id'];?>" class="linkButton" onClick="_pageLoader.goTo(event, this); return false;">
					<?=$apartment["adres"];?>
				</a>
			</div><?php
			}
		}?>
	</div>
</div>