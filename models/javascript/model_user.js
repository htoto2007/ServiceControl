// JavaScript Document

	function User(){
		this.passwordRecovery = function(idForm){
			$(".jquery_ui_dialogs").html("Вы действительно хотите задать новый пароль для "+$("form"+idForm+" input#userName").val()+"?")
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
					'idForm': "form"+idForm,		// Форма отправляемых данных
					'data': "",						// Если форма получения данных не определена в idForm, принемает массив отправляемых данных
					'url': "/controllers/php/controller_ajax_user_passwordRecovery.php",						// Путь до обработчика данных
					'method': "POST",				// Принемает тип метода передачи данных
					'async': true,					// Определяет асинхронность AJAX
					'idError': "div.notice div.err",					// Принемает id элемента для вывода ошибок
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
							
							if(arr.status == false){
									io.notice("div.notice div.err", "Неожиданная ошибка! " + html);
								return;
							}else if(arr.status == true){
								io.notice("div.notice div.ok", "Пароль изменен.");
								$("form"+idForm).parent('div.title').parent('div.row').children('div.log').html("LOGIN: "+arr.result.login+"<br>");
								$("form"+idForm).parent('div.title').parent('div.row').children('div.log').append("PASS: "+arr.result.password);
							}else{
								io.notice("div.notice div.err", "Неожиданная ошибка!" + html);
								return
							}
						},
					'idProgressBar': ""
				});
			}
		}
		
		this.deleteById = function(idForm){	
			$(".jquery_ui_dialogs").html("Вы точно хотите удалить пользователя "+$("form"+idForm+" input#userName").val()+"?")
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
					'url': "/controllers/php/controller_ajax_user_deleteById.php",						// Путь до обработчика данных
					'method': "POST",				// Принемает тип метода передачи данных
					'async': true,					// Определяет асинхронность AJAX
					'idError': "div.notice div.err",					// Принемает id элемента для вывода ошибок
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
							if(arr.status == false){
									io.notice("div.notice div.err", "Неожиданная ошибка! " + html);
								return;
							}else if(arr.status == true){
								io.notice("div.notice div.ok", "Удалено");
								setTimeout(function(){
									_pageLoader.redirectTo(window.location.pathname, false);
								}, 1000);
							}else{
								io.notice("div.notice div.err", "Неожиданная ошибка!" + html);
								return
							}
						},
					'idProgressBar': ""
				});
			}
		}
		
		this.logout = function(){	
			var io = new IO;
			io.start({
				'idForm': "form#login",					// Форма отправляемых данных
				'data': "",						// Если форма получения данных не определена в idForm, принемает массив отправляемых данных
				'url': "/controllers/php/controller_ajax_user_logout.php",						// Путь до обработчика данных
				'method': "POST",				// Принемает тип метода передачи данных
				'async': true,					// Определяет асинхронность AJAX
				'idError': "div.notice div.err",					// Принемает id элемента для вывода ошибок
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
						if(arr.status == false){
								io.notice("div.notice div.err", "Неожиданная ошибка! " + html);
							return;
						}else if(arr.status == true){
							io.notice("div.notice div.ok", "Выход");
							setTimeout(function(){
								_pageLoader.redirectTo("/", true);
							}, 1000);
						}else{
							io.notice("div.notice div.err", "Неожиданная ошибка!" + html);
							return
						}
					},
				'idProgressBar': ""
			});
		}
		
		this.sendLogin = function(){	
			var io = new IO;
			io.start({
				'idForm': "form#login",					// Форма отправляемых данных
				'data': "",						// Если форма получения данных не определена в idForm, принемает массив отправляемых данных
				'url': "/controllers/php/controller_ajax_user_signIn.php",						// Путь до обработчика данных
				'method': "POST",				// Принемает тип метода передачи данных
				'async': true,					// Определяет асинхронность AJAX
				'idError': "div.notice div.err",					// Принемает id элемента для вывода ошибок
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
						//io.notice("div.notice div.err", html);
						try{
							arr = JSON.parse(html);
						}catch(e){
							io.notice("div.notice div.err", html);
							return;
						}
						if(arr.status == false){
							if(arr.result.result == "validation is 0")
								io.notice("div.notice div.err", "Не верный логин или пароль");
							else
								io.notice("div.notice div.err", "Неожиданная ошибка! " + html);
							return;
						}else if(arr.status == true){
							io.notice("div.notice div.ok", "Вход выполнен успешно.");
							setTimeout(function(){
								//_pageLoader.redirectTo("/home");
								location.reload();
							}, 1000);
						}else{
							io.notice("div.notice div.err", "Неожиданная ошибка!" + html);
							return
						}
					},
				'idProgressBar': ""
			});
		}
		
		this.sendRegistration = function(){
			var io = new IO;
			io.start({
				'idForm': "form#login",					// Форма отправляемых данных
				'data': "",						// Если форма получения данных не определена в idForm, принемает массив отправляемых данных
				'url': "/controllers/php/controller_ajax_user_registration.php",						// Путь до обработчика данных
				'method': "POST",				// Принемает тип метода передачи данных
				'async': true,					// Определяет асинхронность AJAX
				'idError': "div.notice div.err",					// Принемает id элемента для вывода ошибок
				'idBefore': "",					// Принемает id элемента для вывода статуса отправки данных
				'typeOut': "html",				// Принемает значения "html" и "vlue". Определяет тип вывода данных
				'idSuccess': "div.notice div.err",				// Принемает id элемента для вывода ответа сервера (обработчика данных)
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
					
					if(arr.status == false){
						if(arr.result.result == "firstName is short!")
							io.notice("div.notice div.err", "Имя слишком короткое!");
						if(arr.result.result == "middleName is short!")
							io.notice("div.notice div.err", "Отчество слишком короткое!");
						if(arr.result.result == "lastName is short!")
							io.notice("div.notice div.err", "Фамилия слишком короткая!");
						else
							io.notice("div.notice div.err", "Неожиданая ошибка "+html);
					} else if(arr.status == true) {
						io.notice("div.notice div.ok", "Регистрация пройдена успешно.");
						$("div.data").html("LOGIN <b>"+arr.result.login+"</b><br>PASSWORD <b>"+arr.result.password)+"</b>";
						/*setTimeout(function(){
							_pageLoader.redirectTo("/viewes/pages/newUser.php?login="+arr.result.login+"&password="+arr.result.password);
						}, 1000);*/
					}
					
				},
				'idProgressBar': ""
			});
		}
	}