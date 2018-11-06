function Apartment() {
	this.add = function () {
		var io = new IO;
		io.start({
			'idForm': "form#addApartment", // Форма отправляемых данных
			'data': "", // Если форма получения данных не определена в idForm, принемает массив отправляемых данных
			'url': "/controllers/php/controller_ajax_apartment_add.php", // Путь до обработчика данных
			'method': "POST", // Принемает тип метода передачи данных
			'async': true, // Определяет асинхронность AJAX
			'idError': "div.notice div.err", // Принемает id элемента для вывода ошибок
			'idBefore': "", // Принемает id элемента для вывода статуса отправки данных
			'typeOut': "html", // Принемает значения "html" и "vlue". Определяет тип вывода данных
			'idSuccess': "", // Принемает id элемента для вывода ответа сервера (обработчика данных)
			'idComplete': "", // Принемает id элемента для вывода ответа сервера (обработчика данных) после полной отработки AJAX
			'delay': "", // Определяет время задержки вывода вывода ответа сервера на экран после полной отработки AJAX
			'callback': "", // Принемает функцию. Инициализирует фпринятую функцию после полной отработки AJAX
			'completeText': "",
			'beforeSendFunction': "",
			'successFunction': function (html) {
				var arr = Array();
				try {
					arr = JSON.parse(html);
				} catch (e) {
					io.notice("div.notice div.err", html);
					return;
				}
				if (arr['status'] == false) {
					if (arr.result.result == "empty")
						io.notice("div.notice div.err", "Адрес не может быть пустым!");
					else if (arr.result.result == "length < 10")
						io.notice("div.notice div.err", "Адрес не может быть короче 10 символов!");
					else
						io.notice("div.notice div.err", "Неожиданная ошибка!");
				} else if (arr['status'] == true) {
					io.notice("div.notice div.ok", "Запись успешно добавлена в базу.");
					setTimeout(function () {
						_pageLoader.redirectTo("/addApartment", false);
					}, 1000);
				} else {
					io.notice("div.notice div.err", "Неожиданная ошибка!");
				}
			},
			'idProgressBar': ""
		});
	}

	this.deleteById = function (idForm) {
		$(".jquery_ui_dialogs").html("Вы действительно хотите удалить " + $("form" + idForm + " input#adres").val() + "?")
		$(".jquery_ui_dialogs").dialog({
			resizable: false,
			height: "auto",
			width: "auto",
			modal: true,
			draggable: false,
			title: "Обратите внимание!",
			buttons: {
				"Да": function () {
					f();
					$(this).dialog("close");
				},
				"Нет": function () {
					$(this).dialog("close");
				}
			}
		});

		function f() {
			var io = new IO;
			io.start({
				'idForm': "form" + idForm, // Форма отправляемых данных
				'data': "", // Если форма получения данных не определена в idForm, принемает массив отправляемых данных
				'url': "/controllers/php/controller_ajax_apartment_deleteById.php", // Путь до обработчика данных
				'method': "POST", // Принемает тип метода передачи данных
				'async': true, // Определяет асинхронность AJAX
				'idError': "div.notice div.err", // Принемает id элемента для вывода ошибок
				'idBefore': "", // Принемает id элемента для вывода статуса отправки данных
				'typeOut': "html", // Принемает значения "html" и "vlue". Определяет тип вывода данных
				'idSuccess': "", // Принемает id элемента для вывода ответа сервера (обработчика данных)
				'idComplete': "", // Принемает id элемента для вывода ответа сервера (обработчика данных) после полной отработки AJAX
				'delay': "", // Определяет время задержки вывода вывода ответа сервера на экран после полной отработки AJAX
				'callback': "", // Принемает функцию. Инициализирует фпринятую функцию после полной отработки AJAX
				'completeText': "",
				'beforeSendFunction': "",
				'successFunction': function (html) {
					var arr = Array();
					try {
						arr = JSON.parse(html);
					} catch (e) {
						io.notice("div.notice div.err", html);
						return;
					}
					if (arr['status'] == false) {
						io.notice("div.notice div.err", "Неожиданная ошибка!");
					} else if (arr['status'] == true) {
						io.notice("div.notice div.ok", "Запись успешно удалена.");
						setTimeout(function () {
							_pageLoader.redirectTo(window.location.pathname, false);
						}, 1000);
					} else {
						io.notice("div.notice div.err", "Неожиданная ошибка!");
					}
				},
				'idProgressBar': ""
			});
		}
	}
	
	this.sortUpdate = function () {
		
		var elems = $("div.layouts").find("div.layout");
		console.log(elems.length);
		
		$.each(elems, function( index, value ) {
			var arr = { 
				"id": $(value).attr('id'),
				"sort": index
			}
			$(value).children("div.row").children("form.sort").children("input.sort").val(index);
			
			var io = new IO;
			io.start({
				'idForm': "", // Форма отправляемых данных
				'data': arr, // Если форма получения данных не определена в idForm, принемает массив отправляемых данных
				'url': "/controllers/php/controller_ajax_apartment_updateSort.php", // Путь до обработчика данных
				'method': "POST", // Принемает тип метода передачи данных
				'async': true, // Определяет асинхронность AJAX
				'idError': "div.notice div.err", // Принемает id элемента для вывода ошибок
				'idBefore': "", // Принемает id элемента для вывода статуса отправки данных
				'typeOut': "html", // Принемает значения "html" и "vlue". Определяет тип вывода данных
				'idSuccess': "", // Принемает id элемента для вывода ответа сервера (обработчика данных)
				'idComplete': "", // Принемает id элемента для вывода ответа сервера (обработчика данных) после полной отработки AJAX
				'delay': "", // Определяет время задержки вывода вывода ответа сервера на экран после полной отработки AJAX
				'callback': "", // Принемает функцию. Инициализирует фпринятую функцию после полной отработки AJAX
				'completeText': "",
				'beforeSendFunction': "",
				'successFunction': function (html) {

					var arr = Array();

					try {
						arr = JSON.parse(html);
					} catch (e) {
						io.notice("div.notice div.err", html);

						return;
					}

					if (arr.status === false) {
						io.notice("div.notice div.err", arr.result.result);
						return;
					}

					if (arr.status === true) {
						var idContent = "#" + $(elem).attr('id');
						var idElement = "#" + $(elem).prev().attr('id');
						//$(idContent).insertBefore(idElement);
						return;
					}

					io.notice("div.notice div.err", "Неожиданная ошибка!");
				},
				'idProgressBar': ""
			});
		});
	};

	this.moveUp = function (elem) {
		var idContent = "#" + $(elem).attr('id');
		var idElement = "#" + $(elem).prev().attr('id');
		$(idContent).insertBefore(idElement);
	};
	
	this.moveDown = function(elem) {
		var idContent = "#" + $(elem).attr('id');
		var idElement = "#" + $(elem).next().attr('id');
		$(idContent).insertAfter(idElement);
	};
}
