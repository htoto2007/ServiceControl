// JavaScript Document

function TitlesGeneralsExpenses(){
	this.send = function(){
		var io = new IO;
		io.start({
			'idForm': "form#addTitlesGeneralsExpenses",					// Форма отправляемых данных
			'data': "",						// Если форма получения данных не определена в idForm, принемает массив отправляемых данных
			'url': "/controllers/php/controller_ajax_titlesGeneralsExpenses_send.php",						// Путь до обработчика данных
			'method': "POST",				// Принемает тип метода передачи данных
			'async': true,					// Определяет асинхронность AJAX
			'idError': "div.notice div.err",// Принемает id элемента для вывода ошибок
			'idBefore': "",					// Принемает id элемента для вывода статуса отправки данных
			'typeOut': "html",				// Принемает значения "html" и "vlue". Определяет тип вывода данных
			'idSuccess': "",				// Принемает id элемента для вывода ответа сервера (обработчика данных)
			'idComplete': "",				// Принемает id элемента для вывода ответа сервера (обработчика данных) после полной отработки AJAX
			'delay': "",					// Определяет время задержки вывода вывода ответа сервера на экран после полной отработки AJAX
			'callback': "",					// Принемает функцию. Инициализирует фпринятую функцию после полной отработки AJAX
			'completeText': "",
			'beforeSendFunction': "",
			'successFunction': function(html){
				
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
				}else
					io.notice("div.notice div.err", "Ошибка!");
			},
			'idProgressBar': ""
		});
	};
	
	this.deleteById = function(idForm){
		$(".jquery_ui_dialogs").html("Вы действительно хотите удалить наименование расхода "+$("form"+idForm+" input#title").val()+"?")
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
				'idForm': "form"+idForm,					// Форма отправляемых данных
				'data': "",						// Если форма получения данных не определена в idForm, принемает массив отправляемых данных
				'url': "/controllers/php/controller_ajax_titlesGeneralsExpenses_deleteById.php",						// Путь до обработчика данных
				'method': "POST",				// Принемает тип метода передачи данных
				'async': true,					// Определяет асинхронность AJAX
				'idError': "div.notice div.err",// Принемает id элемента для вывода ошибок
				'idBefore': "",					// Принемает id элемента для вывода статуса отправки данных
				'typeOut': "html",				// Принемает значения "html" и "vlue". Определяет тип вывода данных
				'idSuccess': "",				// Принемает id элемента для вывода ответа сервера (обработчика данных)
				'idComplete': "",				// Принемает id элемента для вывода ответа сервера (обработчика данных) после полной отработки AJAX
				'delay': "",					// Определяет время задержки вывода вывода ответа сервера на экран после полной отработки AJAX
				'callback': "",					// Принемает функцию. Инициализирует фпринятую функцию после полной отработки AJAX
				'completeText': "",
				'beforeSendFunction': "",
				'successFunction': function(html){
					
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
					}else
						io.notice("div.notice div.err", "Ошибка!");
				},
				'idProgressBar': ""
			});
		}
	};
}