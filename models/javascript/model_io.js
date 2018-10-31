// JavaScript Document
// ===========================================================================================
// IO
// -------------------------------------------------------------------------------------------
// Автор:               Денисов В.С. (Вит Ден)
// Страна\город:        Россия \ Санкт-Петербург
// Сделано:             2016.09.16
// Редакция:            2018.03.14
// Контакты:            http://vitden.ru
//						http://vk.com/vitden
//                      +7 (999) 203-77-15
// Краткое описание:    Для обмена данными между клиентом и сервером
//
// ===========================================================================================

	function IO(){
		// Параметры
		"use strict";
		var params = {
			'idForm': "",											// Форма отправляемых данных
			'data': "",												// Если форма отправки данных не определена в idForm, принемает массив отправляемых данных
			'url': "",												// Путь до обработчика данных
			'method': "POST",										// Принемает тип метода передачи данных
			'async': true,											// Определяет асинхронность AJAX
			'dataType': "html",										// Intelligent Guess (xml, json, script, or html)
			'contentType': 'application/x-www-form-urlencoded', 	// если false то jQuery скажет серверу что это строковой запрос
			'processData': true,
			'idError': "",											// Принемает id элемента для вывода ошибок
			'idBefore': "",											// Принемает id элемента для вывода статуса отправки данных
			'textBefore': "",										// Принемает html для отображения при событии before
			'typeOut': "html",										// Принемает значения "html", "vlue" и "append". Определяет тип вывода данных
			'idSuccess': "",										// Принемает id элемента для вывода ответа сервера (обработчика данных)
			'idComplete': "",										// Принемает id элемента для вывода ответа сервера (обработчика данных) после полной отработки AJAX
			'delay': "",											// Определяет время задержки вывода вывода ответа сервера на экран после полной отработки AJAX
			'callback': "",											// Принемает функцию. Инициализирует фпринятую функцию после полной отработки AJAX
			'completeText': "",										// Принемает функцию.
			'completeFunction': "",
			'beforeSendFunction': "",								// Принемает функцию.
			'successFunction': "",									// Принемает функцию.
			'idProgressBar': "",										// Элемент вывода прогресс бара
			"idProgressValue": ""
		};
		
		var descripterTimer = false;								// Дескриптор таймера запроса/ответа
		var timeout = 60;											// время ожидания ответа сервера в секундах
		
		this.start = function(params){
			
			if(params.idForm !== "") params.data = $(params.idForm).serializeArray();	// Если форма указана, то берем из формы
			if((params.method === "") || (params.method === undefined)) params.method = "POST";
			if((params.dataType === "") || (params.dataType === undefined)) params.dataType = "html";
			
			if((params.processData === "") || (params.processData === undefined))
				params.processData = true;
			
			if((params.contentType === "") || (params.contentType === undefined))
				params.contentType = 'application/x-www-form-urlencoded';
			
			$(params.idProgressBar).css('width', '0%');
			$(params.idProgressBar).css('display', 'block');
			
			$.ajax({
				url:params.url,
				data:params.data,
				type:params.method,
				cache:true,
				dataType:params.dataType,
				async:params.async,
				timeout: timeout * 1000,
				processData: params.processData, // Не обрабатываем файлы (Don't process the files)
				contentType: params.contentType, // Так jQuery скажет серверу что это строковой запрос
				xhr: function(){
					var progress = 0;
					var xhr = new window.XMLHttpRequest();
					//var xhr = $.ajaxSettings.xhr();
					
					// прогресс загрузки на сервер
					xhr.upload.addEventListener("progress", function(obj){
						if (obj.lengthComputable) {
							progress = 100 / (obj.total / obj.loaded);
							//$(params.idProgressBar).css("width", progress+"%");
							$(params.idProgressValue).html(progress+"%");
						}
					}, false);
					// прогресс скачивания с сервера
					xhr.addEventListener("progress", function(obj){
						//alert(JSON.stringify(xhr));
						if (obj.lengthComputable) {
							progress = 100 / (obj.total / obj.loaded);
							//$(params.idProgressBar).css("width", progress+"%");
							$(params.idProgressValue).html(progress+"%");
						}
					}, false);
					return xhr;

				},
				error: function(a,b,c){
					$(params.idBefore).empty();
					errorLog(params.idError, a + " " + b + " " + c);
				},
				beforeSend: function(){
					
					if((params.beforeSendFunction !== "") && (typeof params.beforeSendFunction === 'function')){
						var callback = params.beforeSendFunction;
						callback();
					}
					var timer = 0;
					$(params.idBefore).html(params.textBefore);
				},
				success: function(html){
					$(params.idBefore).empty();
					$(params.idProgressBar).css('display', 'none');
					
					
					if((params.successFunction !== "") && (typeof params.successFunction === 'function')){
						var callback = params.successFunction;
						callback(html);
					}
					switch(params.typeOut){
						case 'value':
							$(params.idSuccess).val(html);
						break;
						case 'html':
						case undefined:
						case '':
							$(params.idSuccess).html(html);
						break;
						case 'append':
							$(params.idSuccess).append(html);
						break;
						default:
							alert("Не верный тип вывода! '"+params.typeOut+"'");
					}
					if((params.callback !== "") && (typeof params.callback === 'function')){
						var callback = params.callback;
						callback(html);
					}
					
				},
				complete: function(XMLHttpRequest, status){
					
					$(params.idComplete).html(params.completeText);
					$(params.idComplete).css('display','block');
					setTimeout(function(){
						$(params.idComplete).fadeOut(500);
					}, params.delay);
					
					if((params.completeFunction !== "") && (typeof params.completeFunction === 'function')){
						var callback = params.completeFunction;
						callback(html);
					}
				}
			});
			return true;
		};

		function errorLog(idError, text){
			$(idError).html(text);
			$(idError).css('display','block');
			setTimeout(function(){
				$(idError).css('display', 'none');
			}, 5000);
		}
		
		this.notice = function(idError, text){
			$(idError).html(text);
			$(idError).css('display','block');
			setTimeout(function(){
				$(idError).css('display', 'none');
			}, 5000);
		}
	}