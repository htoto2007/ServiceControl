<?php 
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
	if((int)$user_getRankById_arr["result"] < 1) exit; 
?>
<?php 
	if(!class_exists('User'))
		include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");
	$User = new User();
	$User->id = $_COOKIE["id_user"];
	$user_getRankById_arr = json_decode($User->getRankById(), true);
?>
<div class="home">
	<div  class="titlePage">
		Основное меню
	</div>
	<div class="menu">
	<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/pages/notice.php");?>
		<a 
			href="/apartmetsList" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Список квартир</a>
		<?php if((int)$user_getRankById_arr["result"] >= 10){ ?>
		<a 
			href="/apartmentStateTable/" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Таблица квартир</a>
		<a 
			href="/addApartment" 
			class="linkButton"
			onClick="_pageLoader.goTo(event, this); return false;">Управление квартирами</a>
			
		<a 
			href="/generalsExpenses" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Общие расходы</a>
		
		<a 
			href="/generalsExspensesTable/" 
			class="linkButton" 
			onClick="_pageLoader.goTo(event, this); return false;">Таблица общих расходов</a>
		<a 
			href="/addTitlesGeneralsExpenses" 
			class="linkButton"
			onClick="_pageLoader.goTo(event, this); return false;">Наименования общих расходов</a>
			
		<a 
			href="/registration" 
			class="linkButton"
			onClick="_pageLoader.goTo(event, this); return false;">Добавить пользователя</a>
		<a 
			href="/users" 
			class="linkButton"
			onClick="_pageLoader.goTo(event, this); return false;">Список пользователей</a>
		<a 
			href="/salaryTable" 
			class="linkButton"
			onClick="_pageLoader.goTo(event, this); return false;">Таблица зарплат</a>
		<?php } ?>
	</div>
		<a 
			href="/" 
			class="linkButton"
			onClick="_User.logout(); return false;">Выход</a>
</div>
<script src="/models/javascript/model_user.js"></script>
<script>
	var _User = new User;
</script>