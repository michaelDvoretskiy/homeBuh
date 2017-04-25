//show message
function mess(txt) {
	if (txt == undefined) {
		txt = "";
	}
	$("section#sectionMain div#message").html(txt);
}
function devMess(txt) {
	$("section#sectionMain div#devMessage").hide();
	$("section#sectionMain div#devMessage").html("");	
	if (txt == undefined) {
		txt = "";
	}
	if (txt.trim() != "") {
		$("section#sectionMain div#devMessage").html(txt);	
		$("section#sectionMain div#devMessage").show();
	}	
}
//sent ajax request for data
function request(action, func, data) {
	var par = {			
		url: 'include/response.php?action=' + action,
		async: true,
	  	success: func
	};
	if (data != undefined) {
		par.type = 'POST';
		par.data = data;		
	}
	$.ajax(par);
}
//
function request2(action, func, data) {
	$.getJSON('include/response.php?action=' + action, data, func);
}
function decorated_request2(action, func, el, timeout, postData) {
	mess("processing ...");
	if (el != null) {
		$(el).prop( "disabled", true );
	}
	request2(action, function(data) {
		func(data.main);
		if (data.err) {
			devMess(data.err.text);
		} else {
			devMess();
		}
		mess("complete !");
		setTimeout(function(){
			mess();
			if (el != null) {
				$(el).prop( "disabled", false);
			}
		}, timeout);
	}, postData);
}
//send request with messages
function decorated_request(action, func, el, timeout, postData) {
	mess("processing ...");
	$(el).prop( "disabled", true );
	request(action, function(data) {
		func(data);
		if (data.substring(0, 3) == "err" && data.length > 3) {
			devMess(data.substring(4) + data.length);	
		} else {
			mess("complete !");
		}		
		setTimeout(function(){
			mess();
			$(el).prop( "disabled", false);
		}, timeout);		
	}, postData);
}
//adding date prototype functions
Date.prototype.myFormat = function() {
	var d = new Date();
    var day = this.getDate();
    if (day < 10) {
    	day = "0" + day;
    }
    var month = this.getMonth() + 1;
    if (month < 10) {
    	month = "0" + month;
    }
    var year = this.getFullYear();
    return year + "-" + month + "-" + day;
}
Date.prototype.myMonthBeg = function() {
	return new Date( this.getFullYear(), this.getMonth(), 1 );
}
Date.prototype.myMonthEnd = function() {
	return new Date( this.getFullYear(), this.getMonth() + 1, 0);
}