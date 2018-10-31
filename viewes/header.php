<?php
	session_start();
?>
<?php
	if((int)$_COOKIE['init'] < 2){
		(int)$_COOKIE['init']++;
		setcookie("init", $_COOKIE['init']);
	}
?>
<!doctype html>
<html>
<head>
	<?php include ($_SERVER['DOCUMENT_ROOT']."/models/php/model_ServiceControl.php");?>
	<?php include ($_SERVER['DOCUMENT_ROOT']."/viewes/logo.php");?>
	<meta charset="utf-8">
	<title>Service Control</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="Cache-Control" content="no-cache">
	
	<link 
		rel="stylesheet" 
		href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" 
		integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" 
		crossorigin="anonymous">
	<link 
		rel="stylesheet" 
		type="text/css" 
		href="/viewes/css/style.css?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/viewes/css/style.css');?>">
	
	<script src="/models/javascript/jquery.min.js"></script>
	<script 
		src="/models/javascript/model_io.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_io.js');?>">
	</script>
	<script 
		src="/models/javascript/model_pageLoader.js?<?=filemtime($_SERVER['DOCUMENT_ROOT'].'/models/javascript/model_pageLoader.js');?>">
	</script>
	<script>
		var _pageLoader = new PageLoader();
		_pageLoader.navigationButton();
	</script>
</head>