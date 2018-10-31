
<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
	$User = new User();
	$user_status_arr = json_decode($User->status(), true);
	/*echo "<pre>";
	var_dump($user_status_arr);
	echo "</pre>";*/
	if($user_status_arr["status"] === false){
		$user_firstWorck_arr = json_decode($User->firstWorck(), true);
		/*echo "<pre>";
		var_dump($user_firstWorck_arr);
		echo "</pre>";*/
		if(($user_firstWorck_arr["status"] === false) && ($user_firstWorck_arr["result"] !== 0)){
?>
			<div class="login">
				<div class="form">
					<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
					<form method="post" id="login">
						<div>
							<input type="text" name="login" placeholder="логин">
						</div>
						<div>
							<input type="password" name="password" placeholder="Пароль">
						</div>
						<div>
							<button name="signIn" onClick="_user.sendLogin(); return false;">Вход</button>
						</div>
					</form>
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
