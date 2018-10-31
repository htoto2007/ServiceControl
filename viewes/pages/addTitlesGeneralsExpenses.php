<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 10) exit; 
?>
<?php include ($_SERVER['DOCUMENT_ROOT']."/controllers/php/controller_ajax_titlesGeneralsExpenses_getInfo.php");?>
<div class="addTitlesGeneralsExpenses">
	<div class="titlePage">
		<b>Название перечней затрат</b>
	</div>
	<div class="form">
		<form id="addTitlesGeneralsExpenses" method="post">
			<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
			<div>
				<input type="text" name="title" placeholder="Название категории расходов">
			</div>
			<div>
				<button onClick="_TitlesGeneralsExpenses.send(); return false;">Добавить</button>
			</div>
		</form>
	</div>
	
	<div class="layouts" >
		<div class="layout">
			<?php
				foreach($TitlesGeneralsExpenses_getInfo_arr["result"] as $title){
			?>
			<div class="row">
				<div class="title">
					<?php echo $title["title"]; ?>
				</div>
				<div class="value">
					<form method="post" id="delete<?=$title["id"];?>">
						<input type="hidden" value="<?=$title["id"];?>" name="id">
						<input type="hidden" value="<?=$title["title"];?>" id="title">
						<button 
							class="no" 
							onClick="_TitlesGeneralsExpenses.deleteById('#delete<?=$title["id"];?>'); return false;">
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
</div>

<script src="/models/javascript/model_titlesGeneralsExpenses.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_titlesGeneralsExpenses.js');?>"></script>
<script>
	var _TitlesGeneralsExpenses = new TitlesGeneralsExpenses();
</script>