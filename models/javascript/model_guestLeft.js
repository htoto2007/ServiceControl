// JavaScript Document

function GuestLeft(){
	this.sendData = function(){
		var io = new IO;
		io.start({
			'idForm': "form#sendEntry",					// Форма отправляемых данных
			'data': "",						// Если форма получения данных не определена в idForm, принемает массив отправляемых данных
			'url': "/controllers/php/controller_ajax_apartmentState_sendDataExitById.php",						// Путь до обработчика данных
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
				if(arr['status'] == true)
					io.notice("div.notice div.ok", "Сохранено.");
				else
					io.notice("div.notice div.err", "Ошибка!");
			},
			'idProgressBar': ""
		});
	};
}