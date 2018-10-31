// ===========================================================================================
// AJAX navigator engine
// -------------------------------------------------------------------------------------------
// Author: 			Denisov V.S. (Vit Den)
// Location: 		Russia \ Saint-Petersburg
// Start project: 	2016.10.16
// Modification: 	2018.03.26
// Contacts: 		http://vk.com/vitden
// 					+7 (905) 233-68-23
// About project: 	... 
// ===========================================================================================

	function PageLoader(){
		var url;
		this.urlParams = Array();
		
		this.goTo = function(event, element){
			event.preventDefault();
			url = element;
			window.history.pushState(null, null, url.href);
			this.parseURL();
			this.loadePage();
			return true;
		}
		
		
		this.redirectTo = function(link, historyFlag){
			url = document.createElement('a');
			url.href = link;
			if(historyFlag == true) window.history.pushState(null, null, url.href);
			this.parseURL();
			this.loadePage();
			return true;
		}
		
		this.effectOut = function(){
			$('div.content div').fadeOut();
			return true;
		}
		
		this.goToForNavigate = function(element){
			url = element;
			this.parseURL();
			this.loadePage();
			return true;
		}
		
		this.navigationButton = function(event){ 
			window.addEventListener( 
				"popstate",
				function(event) {  
					event.preventDefault();
					var pageLoader = new PageLoader();
					pageLoader.goToForNavigate(window.location);
				},  
				false 
			); 
		}
		
		this.parseURL = function(){
			var path = url.pathname;
			var search = url.search;
			
			if(path.indexOf('index.php') !== -1){
				search = search.replace('?section=', '/');
				search = search.replace('&', '/');
				search = search.replace('subsection=', '');
				search = search.split("/");
				if(search[0] === "") search.splice(0,1);
				this.urlParams = search;
				
			
			}else{
				path = path.split("/");
				if(path[0] === "") path.splice(0,1);
				if(path[path.length - 1] === "") path.splice(path.length - 1,1);
				this.urlParams = path;
			}
			var data = {
				"section": this.urlParams[0],
				"subsection": this.urlParams[1],
				"model": this.urlParams[2],
				"submodel": this.urlParams[3]
			}
			this.urlParams = data;
			return true;
		}
		
		function scrollToId(){
			if($('div').is(url.hash)){
				$('html,body').stop().animate({
					'scrollTop': $(url.hash).offset().top
				}, 500);
			}
				
		}
		
		this.loadePage = function(){
			var urlParams = this.urlParams;
			var io = new IO;
			io.start({
				'idForm': "",					
				'data': urlParams,						
				'url': "/controllers/php/controller_pages.php",						
				'async': true,
				'method': "GET",				
				'idError': "div.errorDialog",					
				'idBefore': "",					
				'typeOut': "html",				
				'idSuccess': "div.content",				
				'idComplete': "",				
				'delay': "",
				'idProgressBar': "div.progressBar",
				'beforeSendFunction': function(){
					$('body div.loader').css('display', 'block');
				},
				'callback': function(){
					/*$('div.content').animate({opacity: 1}, 500);
					$('div.content').slideDown(400, function(){scrollToId();});
					$('div.content').css('display', 'none');*/
					//scrollToId();
				},					
				'idProgressValue': "body div.loader div.progress",
				'successFunction': function(){
					$('body div.loader').css('display', 'none');
				}
			});
			return true;
		}
	}