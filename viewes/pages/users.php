<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_user_getInfo.php");?>

<?
	/*echo "<pre>";
	var_dump($user_getInfo_arr);
	echo "</pre>";*/
?>
<div class="user">
	<div class="list">
		<div class="titlePage">
			<b>Пользователи</b>
		</div>
		<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
		<div class="layouts">
			<? foreach($user_getInfo_arr["result"] as $userKey => $user){ ?>
				<div class="layout">
					<div class="row">
						<div class="title">
							<?=$user["last_name"]."<br>".$user["first_name"]."<br>".$user["middle_name"];?>
						</div>
						<div class="value">
							<?=$user["login"]."<br>".$user["date"];?>
						</div>
					</div>
					<div class="row">
						<div class="title">
							<a 
								href="/user/<?=$user["id"];?>" 
								class="linkButton yes" 
								onClick="_pageLoader.goTo(event, this); return false;">
									<i class="fas fa-unlock-alt"></i>
							</a>
						</div>
						<div class="value">
							<form method="post" id="delete<?=$userKey;?>">
								<input type="hidden" name="id_employee" value="<?=$user["id"];?>">
								<input 
									type="hidden" 
									id="userName" 
									value="<?=$user["last_name"]." ".$user["first_name"]." ".$user["middle_name"];?>">
								<button 
									class="no" 
									onClick="_user.deleteById('#delete<?=$userKey;?>'); return false;">
									<i class="fas fa-trash-alt"></i>
								</button>
							</form>
						</div>
					</div>
					<div class="row">
						<div class="title">
							<form method="post" id="passwordRecovery<?=$userKey;?>">
								<input type="hidden" name="id_employee" value="<?=$user["id"];?>">
								<input 
									type="hidden" 
									id="userName" 
									value="<?=$user["last_name"]." ".$user["first_name"]." ".$user["middle_name"];?>">
								<button  
									onClick="_user.passwordRecovery('#passwordRecovery<?=$userKey;?>'); return false;">
									<i class="fas fa-key"></i>
								</button>
							</form>
						</div>
						<div class="value">
							
						</div>
						<div class="log" style="font-size:18pt; padding:5px;"></div>
					</div>
				</div>
			<? } ?>
		</div>
	</div>
</div>
<script src="/models/javascript/model_user.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_user.js');?>"></script>
<script>
	var _user = new User();
</script>