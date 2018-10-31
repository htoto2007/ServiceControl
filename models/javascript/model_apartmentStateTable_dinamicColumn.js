// JavaScript Document


function DinamicColumn(){
	this.apartmentAdreses = [];
	this.apartmentDate = [];
	
	this.show = function(){
		if($('table').is(".floatTable")) $(".floatTable").remove();
		if($('table').is(".floatHeader")) $(".floatHeader").remove();
		
		var left = parseInt($("th.headerColumnFlat").width()) + 25;
		var top = parseInt($("div.content").height());
		
		// date
		/*
		var strTable = "<table class='floatHeader' style='top: "+ top +"px; left: " + left + "px; background-color: darkkhaki;'>";
		strTable += "<tr>";
		for(var i = 0; i < this.apartmentDate.length; i++){
			strTable += "<th class='but' ";
			strTable += " height='" + $("th.date" + i).height() + "px'"; 
			strTable += " width='" + $("th.date" + i).width() + "px'";
			strTable += "style='padding:" + $("th.date" + i).css('padding') + "'";
			strTable += " ><b>";
			strTable += this.apartmentDate[i];
			strTable += "</b></th>";
			
		}
		strTable += "</tr>";
		
		strTable += "<tr>";
		for(var i = 0; i < this.apartmentDate.length; i++){
			strTable += "<th colspan='2' ";
			strTable += "height='" + $("th.countPersons" + i).height() + "px' ";
			strTable += "width='" + $("th.countPersons" + i).width() + "px'";
			strTable += ">";
			strTable += "Кол-во человек";
			strTable += "</th>";
			strTable += "<th rowspan='2' ";
			strTable += "height='" + $("th.sum" + i).height() + "px' ";
			strTable += "width='" + $("th.sum" + i).width() + "px'";
			strTable += ">";
			strTable += "Сумма";
			strTable += "</th>";
		}
		strTable += "</tr>";
		strTable += "<tr>";
		for(var i = 0; i < this.apartmentDate.length; i++){
			strTable += "<th ";
			strTable += "height='" + $("th.parent" + i).height() + "px' ";
			strTable += "width='" + $("th.parent" + i).width() + "px'";
			strTable += ">";
			strTable += "ВЗР";
			strTable += "</th>";
			strTable += "<th ";
			strTable += "height='" + $("th.child" + i).height() + "px' ";
			strTable += "width='" + $("th.child" + i).width() + "px'";
			strTable += ">";
			strTable += "Д";
			strTable += "</th>";
		}
		strTable += "</tr>";
		
		strTable += "</table>";
		*/
		$("div .table").append(strTable);
		
		// apartment
		top = parseInt($("div.content").height()) + parseInt($("th.headerColumnFlat").height()) + 12;
		
		var strTable = "<table class='floatTable' style='top: "+top+"px'>";
		for(var i = 1; i < this.apartmentAdreses.length; i++){
			strTable += "<tr>";
			strTable += "<td colspan='3' height='" + $("td.apartment" + i).height() + "px'"; 
			strTable += "width='" + $("td.apartment" + i).width() + "px'";
			strTable += " style='background-color: darkkhaki;'><b>";
			strTable += this.apartmentAdreses[i];
			strTable += "</b></td></tr>";
			
		}
		strTable += "</table>";
		$("div .table").append(strTable);
	}
	
	this.updatePosition = function(){
		var p = $("th.headerColumnFlat").offset().top - $(window).scrollTop();
		//$("div.out").html(p);
		var position = $("th.headerColumnFlat").offset();
		
		var top = position.top + $("th.headerColumnFlat").height() + 12 - $(window).scrollTop();
		$("table.floatTable").css({'top':top});
		
		
		/*
		p = $("th.headerColumnFlat").offset().left - $(window).scrollLeft();
		position = $("th.headerColumnFlat").offset();
		var left = position.left + $("th.headerColumnFlat").width() + 12 - $(window).scrollLeft();
		$("table.floatHeader").css({'left':left});
		
		
		for(var i = 0; i < this.apartmentDate.length; i++){
			$('th.but').width($("th.date" + i).width());
			$('th.but').height($("th.date" + i).height());
			$('th.but').css("padding", "5px");
		}
		*/
	}
	
	
}