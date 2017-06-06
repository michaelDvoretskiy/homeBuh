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

//get html from some controller into element
function fillElement(element, action, controller, options) {
    //$('nav.dependent').html("");
    $.get(
        Routing.generate(controller, options),
        function(data, status) {
            if (status == "success") {
                element.html(data);
                action();
            } else {
                element.html("recieving data was failed !");
            }
        }
    );
}

//run command or something like this
function doTheThing(action, controller, options) {
    $.ajax({
        url: Routing.generate(controller, options),
        async: true,
        success: action,
        type: 'POST'
    });
}