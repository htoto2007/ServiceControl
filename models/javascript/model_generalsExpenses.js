// JavaScript Document

function GeneralsExpenses(){
	this.createInfo = function(){
		var io = new IO;
		io.start({
			'idForm': 				"form#createInfo",
			'data': 				"",
			'url': 					"/controllers/php/controller_ajax_generalsExpenses_createInfo.php",
			'method': 				"POST",
			'async': 				true,
			'idError': 				"div.notice div.err",
			'idBefore': 			"",
			'typeOut': 				"html",
			'idSuccess': 			"",
			'idComplete': 			"",
			'delay': 				"",
			'callback': 			"",
			'completeText': 		"",
			'beforeSendFunction': 	"",
			'successFunction': 		function(html){
				var arr = Array();
				try{
					arr = JSON.parse(html);
				}catch(e){
					io.notice("div.notice div.err", html);
					return;
				}
				if(arr['status'] == true){
					io.notice("div.notice div.ok", "Сохранено.");
					setTimeout(function(){
						_pageLoader.redirectTo(window.location.pathname, false);
					}, 1000);
				}else{
					//alert(arr.result.result);
					if(arr.result.result == "Date already defined")
						io.notice("div.notice div.err", "Дата уже определена!");
					else if(arr.result.result == "Date id empty")
						io.notice("div.notice div.err", "Поля даты не заполнены!");
					else
						io.notice("div.notice div.err", "Ошибка!");
				}
			},
			'idProgressBar': ""
		});
	};
	
	this.deleteById = function(idForm){
		$(".jquery_ui_dialogs").html("Вы действительно хотите удалить "+$("form"+idForm+" input#info").val()+"?")
			$(".jquery_ui_dialogs").dialog({
			  resizable: false,
			  height: "auto",
			  width: "auto",
			  modal: true,
			  draggable: false,
			  title: "Обратите внимание!",
			  buttons: {
				"Да": function() {
					f();
					$( this ).dialog( "close" );
				},
				"Нет": function() {
					$( this ).dialog( "close" );
				}
			  }
			});
			
		function f(){
			var io = new IO;
			io.start({
				'idForm': 				"form"+idForm,
				'data': 				"",
				'url': 					"/controllers/php/controller_ajax_generalsExpenses_deleteById.php",
				'method': 				"POST",
				'async': 				true,
				'idError': 				"div.notice div.err",
				'idBefore': 			"",
				'typeOut': 				"html",
				'idSuccess': 			"",
				'idComplete': 			"",
				'delay': 				"",
				'callback': 			"",
				'completeText': 		"",
				'beforeSendFunction': 	"",
				'successFunction': 		function(html){
					var arr = Array();
					try{
						arr = JSON.parse(html);
					}catch(e){
						io.notice("div.notice div.err", html);
						return;
					}
					if(arr['status'] == true){
						io.notice("div.notice div.ok", "Сохранено.");
						setTimeout(function(){
							_pageLoader.redirectTo(window.location.pathname, false);
						}, 1000);
					}else{
						//alert(arr.result.result);
						if(arr.result.result == "IdExpenses is empty!")
							io.notice("div.notice div.err", "Идентификатор удаляемого объекта пуст!");
						else
							io.notice("div.notice div.err", "Ошибка!");
					}
				},
				'idProgressBar': ""
			});
		}
	};
}