<link rel="stylesheet" type="text/css" href="/models/javascript/jquery-ui/jquery-ui.min.css">
<script src="/models/javascript/jquery-ui/jquery-ui.min.js"></script>
<script>
	$(window).on('load', function(){
		//alert("<?=$_COOKIE["init"];?>");
		setTimeout(function(){
			if("<?=$_COOKIE["init"];?>" != "2"){ 
				location.reload();
				return;
			}
			$('div.logo').fadeOut(1000);
		}, 1000);
		
	});
</script>
