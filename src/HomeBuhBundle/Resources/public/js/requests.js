window.onload = function() {	
	function refreshCat() {
		request("getCat", function(data) {
			$('#sectionMain form#addCatSum select#cat_val').html(data);
		}); 
	}	
	//initialisation of date controls
	var now = new Date();
	$('#curDate').val(now.myFormat());
	$('#viewDate').val(now.myFormat());
	$('#repDate1').val(now.myMonthBeg().myFormat());
	$('#repDate2').val(now.myMonthEnd().myFormat());

	//set enent onclick for adding data
	$('input#cat_bnt_add').click(function() {	
		devMess();
		var postData = {};
		postData.dateAdd = $('form#addCatSum input#curDate').val();
		postData.catAdd = $('form#addCatSum select#cat_val').val();		
		postData.sumAdd = $('form#addCatSum input#cat_summa').val();
		postData.txtAdd = $('form#addCatSum input#cat_text').val();
		postData.accAdd = $('form#addCatSum select#acc_val').val();	
		if (postData.catAdd != "none" && postData.sumAdd > 0 
			&& postData.dateAdd != "" && postData.accAdd != "") {
			decorated_request("addSum", function(data) {				
				$('form#addCatSum select#cat_val').val("none");
				$('form#addCatSum input#cat_summa').val("0");
				$('form#addCatSum input#cat_text').val("");				
				$('form#addCatSum select#acc_val').val("1");	
			}, this, 1000, postData);			
		}
	});

	//set event onclick for viewing data
	$('input#bnt_view').click(function() {
		devMess();
		
		var tableRowDelClick = function() {
			if (confirm("Delete this row ?")) {
				var postData = {};
				var el = this;
				postData.rowId = $(el).attr('dbrowid');
				request("delRow", function(data) {
					//devMess(data);
					$(el).parent().remove();
				}, postData); 				
			}
		}

		var postData = {};
		postData.viewData = $('form#viewSummas input#viewDate').val();
		if (postData.viewData != "") {
			decorated_request("viewSum", function(data) {
				$('form#viewSummas table#viewTable > tbody').html(data);
				$('form#viewSummas table#viewTable td.del')
					.click(tableRowDelClick);
			}, this, 1000, postData);
		}
	});

	//set event onclick for report btn
	$('input#bnt_report').click(function() {
		var tableRowDrillDownClick = function() {
			var dbrowid = $(this).attr('dbrowid');
			var el = $('tr.hidden[dbrowid=' + dbrowid + ']');
			if ($(el).attr('hidden') == 'hidden') {
				$(el).removeAttr('hidden')
			} else {
				$(el).attr('hidden','hidden');
			}			
		}

		var postData = {};
		postData.repData1 = $('form#reportSummas input#repDate1').val();
		postData.repData2 = $('form#reportSummas input#repDate2').val();
		postData.repAccType = $('form#reportSummas select#acc_rep_val').val();
		if (postData.repData1 != "" && postData.repData2 != "") {
			decorated_request("repSum", function(data) {				
				$('form#reportSummas table#repTable > tbody').html(data);
				//set event onclick to drill down
				$('form#reportSummas table#repTable > tbody td.drillDown')
					.click(tableRowDrillDownClick);
				//calculate percent of summa
				var summa = $('form#reportSummas table#repTable > tbody tr > th.sum_all').html();				
				$('form#reportSummas table#repTable > tbody tr.row').each(function(index) {
					var pers = Math.round($($(this).children()[1]).html() / summa * 100) + "%";
					$($(this).children()[2]).html(pers);
				});
			}, this, 1000, postData);
		}
	});

	var editingCategoryButtons = function() {
		var el = this;
		var postData = {};
		postData.catId = $(el).attr("db_row_id");
		postData.text = $('form#editCat input.edCatText[db_row_id=' + postData.catId + ']').val();
		postData.priority = $('form#editCat input.edCatOrd[db_row_id=' + postData.catId + ']').val();
		
		decorated_request("edCat", function(data) {						
			if (data == "ok") {
				$('nav.dependent li#mnuEditCat').click();		
				refreshCat();			
			} else {
				devMess(data);
			}
		}, this, 1000, postData);
	}

	var deletingCategoryButtons = function() {
		var el = this;
		var postData = {};
		postData.catId = $(el).attr("db_row_id");
		
		decorated_request("delCat", function(data) {						
			if (data == "ok") {
				$('nav.dependent li#mnuEditCat').click();		
				refreshCat();			
			} else {
				devMess(data);
			}
		}, this, 1000, postData);
	}

	var dependentMenuClickFun = function() {
		var el = this;
		$('nav.dependent li').removeClass('active');
		$(el).addClass('active');
		var clickedId = $(el).attr("id");
		$('#sectionMain form').hide();
		if (clickedId == "mnuPWD") { 
			$('#sectionMain form#options').show();
		} else if (clickedId == "mnuEditCat") {
			$(this).children().not('.mydiv').remove();			
			$('#sectionMain form#editCat').show();
			postData = {};
			decorated_request2("getCatToEdit", function(data) {		
				$("#sectionMain form#editCat #initialRowCatEdit").hide();
				$("#sectionMain form#editCat #initialRowCatEdit").nextAll().remove();
				var row;				
				for(var i = 0; i < data.length; i++) {
					row = $("#sectionMain form#editCat #initialRowCatEdit").clone().removeAttr("id").appendTo("#sectionMain form#editCat div.tableView").show();
					row.find("input.edCatText").attr("db_row_id", data[i].id).attr("name", "edCatText" + data[i].id).attr("id", "edCatText" + data[i].id).attr("value", data[i].name);
					row.find("input.edCatOrd").attr("db_row_id", data[i].id).attr("name", "edCatPrior" + data[i].id).attr("id", "edCatPrior" + data[i].id).attr("value", data[i].ord);
					row.find("input.edCatBtn").attr("db_row_id", data[i].id).attr("name", "edCatBtn" + data[i].id).attr("id", "edCatBtn" + data[i].id);
					row.find("input.delCatBtn").attr("db_row_id", data[i].id).attr("name", "delCatBtn" + data[i].id).attr("id", "delCatBtn" + data[i].id);
				}
				$('#sectionMain form#editCat input.edCatBtn').click(editingCategoryButtons);
				$('#sectionMain form#editCat input.delCatBtn').click(deletingCategoryButtons);
			}, this, 1000, postData);
		} else if (clickedId == "mnuEditAcc") {
			$('#sectionMain form#123').show();
  		} else {
  			
  		}
	};
	//set event main menu click
	var mainMenuClickFun = function() {
		var el = this;
		$('nav.main li').removeClass('active');
		$('nav.dependent').html("");
		$(el).addClass('active');
		var clickedId = $(el).attr("id");		
		if (clickedId == "mnuAdd") {  			
			$('#sectionMain form').hide();
			$('#sectionMain form#addCatSum').show();
  		} else if (clickedId == "mnuView") {
  			$('#sectionMain form').hide();
  			$('#sectionMain form#viewSummas').show();		  			
  		} else if (clickedId == "mnuReport") {
			$('#sectionMain form').hide();
  			$('#sectionMain form#reportSummas').show();	
  		} else if (clickedId == "mnuOption") {
  			$('#sectionMain form').hide();
  			var mnu = "<ul><li id = 'mnuPWD' class = 'active'>password</li>" +
  					"<li id = 'mnuEditCat'>catedory</li>" +  					
  					"<li id = 'mnuEditAcc'>accounts</li></ul>";
  			$('nav.dependent').html(mnu);
  			$('nav.dependent li').click(dependentMenuClickFun);
  			$('#sectionMain form#options').show();
  		} else if (clickedId == "mnuLogout") {
			$('#sectionMain form').hide();
  			$('#sectionMain form#login').show();	
  			$('nav').html("");
  			$('#sectionMain form#addCatSum select#cat_val').html("");
  			$('#sectionMain form#addCatSum select#acc_val').html("");
  			$('#sectionMain form#reportSummas select#acc_rep_val').html("");
  		} else {
  			$('#sectionMain form').hide();
  		}
	};
	
	//set event onclick to login btn
	$('input#bnt_login').click(function() {
		var postData = {};
		postData.username = $('form#login input#userName').val();
		postData.userpass = $('form#login input#userPass').val();
		$('form#login input#userPass').val("");
		decorated_request("login", function(data) {
			if (data != "") {
				$('nav.main').html(data);
				//set event onclick for menu items
				$('nav.main li').click(mainMenuClickFun);

				//send request to fill categories list
				refreshCat();
				//send request to fill account list
				request("getAcc", function(data) {
					$('#sectionMain form#addCatSum select#acc_val').html(data);
					var data2 = "<option value = \"none\">All types</option>" + data;
					$('#sectionMain form#reportSummas select#acc_rep_val').html(data2);
				}); 

				//show adding form
				$('#sectionMain form').hide();
				$('#sectionMain form#addCatSum').show(); 
				//devMess(data);

			}
		}, this, 1000, postData);
	});

	//change password click
	$('input#change_pwd_btn').click(function() {	
		devMess();
		var postData = {};
		if ($('form#options input#newPwd').val() !== $('form#options input#newPwd2').val()) {
			mess("wrong password conformation !");
			$('form#options input#newPwd]').val("");
			$('form#options input#newPwd2]').val("");
			return;
		}
		postData.oldpass = $('form#options input#oldPwd').val();
		postData.newpass = $('form#options input#newPwd').val();				
		decorated_request("chPassW", function(data) {		
			$('form#options input[type=password]').val("");		
			if (data == "ok") {
				$('nav.main li#mnuAdd').click();
			}
		}, this, 1000, postData);			
	});

	//inserting category
	$('input#insCat').click(function() {
		devMess();
		var postData = {};
		postData.text = $('form#editCat input#insCatText').val();
		postData.priority = $('form#editCat input#insCatPrior').val();
		if (postData.text != "" && postData.priority != "") {			
			decorated_request("addCat", function(data) {						
				if (data == "ok") {
					$('form#editCat input#insCatText').val("");
					$('form#editCat input#insCatPrior').val("0");
					$('nav.dependent li#mnuEditCat').click();					
				} else {
					devMess(data);
				}
			}, this, 1000, postData);
		}
	});
};