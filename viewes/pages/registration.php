<?php
	if(!class_exists('GuestLeft'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
?>
<div class="login">
	<div  class="titlePage">
		Регистрация пользователей
	</div>
	<div class="form">
		<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
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
					?>
								<option 
									value="<?=$result['id'];?>" 
									selected><?=$result["name"];?></option>
					<?php
							}
						}
					?>
				</select>
			</div>
			<div>
				<button name="signIn" onClick="_user.sendRegistration(); return false;">Вход</button>
			</div>
		</form>
		<div class="data">
			
		</div>
	</div>
</div>

<script src="/models/javascript/model_user.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_user.js');?>"></script>
<script>
	var _user = new User();
</script>