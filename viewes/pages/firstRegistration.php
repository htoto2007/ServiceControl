<?php 
	$User = new User();
	$arrResult = $User->status();
	$arrResult = json_decode($arrResult, true);
	if($arrResult["status"] === false){
		$arrResult = $User->firstWorck();
		$arrResult = json_decode($arrResult, true);
		echo "<pre>";
		var_dump($arrResult);
		echo "</pre>";
		if(($arrResult["status"] !== true) || ($arrResult["result"] !== 0)) exit;
		else{
?>
		<div class="login">
			<div class="err"></div>
			<div class="form">
				<form method="post" id="login">
					<div>
						<input type="text" name="last_name" placeholder="Фамилия">
					</div>
					<div>
						<input type="text" name="first_name" placeholder="Имя">
					</div>
					<div>
						<input type="text" name="middle_name" placeholder="Отчество">
					</div>
					<div>
						<select name="id_access_group">
							<?php 
								$AccessGroup = new AccessGroup();
								$arrResult = $AccessGroup->getInfo();
								$arrResult = json_decode($arrResult, true);
								if($arrResult["status"] === true){
									foreach($arrResult["result"] as $result){
										if($result['rank'] === "10"){
							?>
											<option 
												value="<?=$result['id'];?>" 
												selected><?=$result["name"];?></option>
							<?php
										}
									}
								}
							?>
						</select>
					</div>
					<div>
						<button name="signIn" onClick="_user.sendRegistration(); return false;">Вход</button>
					</div>
				</form>
				<div class="data"></div>
			</div>
		</div>
<script src="/models/javascript/model_user.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_user.js');?>"></script>
<script>
	var _user = new User();
</script>	
<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/footer.php");?>	
<?php
			exit;
		}
	}
?>
