function fn_help_view()
{
	var path = window.location.pathname;
	var page = path.split("/").pop();

	var data = new FormData();
	data.append("action", "VIEW");
	data.append("page", page);
	let fetchRes = fetch("h_help_view.php", {method: 'POST',body: data});
	fetchRes.then(res=>res.json()).then(d=>{
		var result = d;
		if (result[0] == "SUCCESS")
			document.getElementById("VIEW_HELP").innerHTML=result[1];
		else
			tempAlert("Help not found" + d);
	});
}
function fn_help_add() 
{
	var path = window.location.pathname;
	var page = path.split("/").pop();

	var data = new FormData();
	data.append("opt", 1);
	data.append("page", page);
	data.append("question", document.getElementById("txt_help_question").value);
	data.append("answer", document.getElementById("txt_help_answer").value);
	
	let fetchRes = fetch("h_help_add.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{

		var result = d;
		if (result[0] == "SUCCESS")
			tempAlert("Help added successfully");
		else
			alert("Error" + d);
		
	});
}








/* Page Loader Script ----------- START ----------*/

document.addEventListener("DOMContentLoaded", function () {
    // Hide the SMART_CL_PAGE_LOADER
    const SMART_CL_PAGE_LOADER = document.querySelector(".SMART_INIT_PAGE_LOADER");
    SMART_CL_PAGE_LOADER.style.display = "none";

    // Add class to enable scrolling and show content
    document.body.classList.add("SMART_CL_PAGE_LOADER-visible");
});
/* Page Loader Script ----------- END ----------*/



if (typeof LS_CUR_PAGE !== 'undefined')
	null;
else
	var LS_CUR_PAGE = "DEFAULT";



function fn_GPDS_SaveWork_DELETE2()
{
	null;
/*	
	document.getElementById("pb_save").value = "Saving... ";

	var groupworkid = document.getElementById("groupworkid").value;

	var v_tdate = document.getElementById("tdate").value;


	var v_qty = document.getElementById("txt_groupwages_qty").value;
	v_qty = RND2(v_qty);
	v_qty = +v_qty;

	var v_rpu = document.getElementById("txt_groupwages_rpu").value;
	v_rpu = RND2(v_rpu);
	v_rpu = +v_rpu;
	
	if (v_rpu > 0)
	{
		if (v_qty > 0)
		{
			var v_wages = v_rpu * v_qty;
			document.getElementById("txt_groupwages_amt").value = RND2(v_wages);
			
			

	var records = '';
	var pcounter = 0;
	var rows = document.querySelectorAll("tr.TR_EMPLOYEE_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var x1 =  rows[i].querySelector(".CL_EMP").value; 
		x1 = +x1;

		var y1 =  rows[i].querySelector(".CL_NOU").value; 
		y1 = +y1;

		if (x1 > 0)
		{
			//alert("x1 - " + x1);
			records = myTrim(records) + 'AA'  + '##$##' + x1 + '##$##' + y1 + '##$##' +  'AA' + '$$#$$';
			pcounter++;
		}
	}	
	records = myTrim(records);

	if (pcounter > 0)
	{
		null;
	}
	else
	{
		alert("Atleast one entry is required");
		document.getElementById("pb_save").value = "Save";
		return;
	}

	//alert(records);
	//records = encodeURIComponent(records);
	//alert(records);

	var subdepartmentid = document.getElementById("subdepartmentid").value;
	var productid = document.getElementById("productid").value;
	var machineid = document.getElementById("machineid").value;
	var processid = document.getElementById("processid").value;

	var v_tdate = document.getElementById("tdate").value;


	var data = new FormData();
	data.append("action", "SAVE");
	data.append("groupworkid", document.getElementById("groupworkid").value);
	data.append("tdate", document.getElementById("tdate").value);
	data.append("records", records);

	let fetchRes = fetch("t_sdept_group_entry_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
	
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
		document.getElementById("pb_save").value = "Save";
	});
*/
}








function fn_initGroupEntryDate()
{
	var date = document.getElementById("tdate").value;
	if ( date.length > 0 )
	{
		tempAlert("Kindly check the Date and Shift");
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = false;
		}
	}
	else
	{
		alert("Kindly enter the date");
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = true;
		}
	}
}

function fn_changeGroupEntryDate()
{
	var date = document.getElementById("tdate").value;
	if ( date.length > 0 )
	{
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = false;
		}
		
		if (document.getElementById("tdate").defaultValue == document.getElementById("tdate").value)	
			null;
		else
		{
			if (confirm("Sure to change Date!  Going to relaod the page") == true) 
			{
				var tdate = document.getElementById("tdate").value;
				var shiftid = document.getElementById("txt_shiftid").value;

				document.getElementById("shift2").value = shiftid;		
				
				document.cookie = "CURRENT_ENTRY_DATE=" + tdate; 
				document.cookie = "CURRENT_ENTRY_SHIFT=" + shiftid; 

				document.getElementById("tdate2").value = tdate;		
				document.getElementById("frm_sdept_group_entry_view1").submit();
			} 
			else 
			{
				return;
			}			
		}
	}
	else
	{
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = true;
		}
	}
}

function fn_changeGroupEntryShift()
{
	var shiftid = document.getElementById("txt_shiftid").value;
	if ( shiftid > 0 )
	{
		if (confirm("Sure to change Shift!  Going to relaod the page" + shiftid) == true) 
		{
			document.getElementById("tdate2").value = document.getElementById("tdate").value;		
			document.getElementById("shift2").value = shiftid;		
			
			document.cookie = "CURRENT_ENTRY_DATE=" + tdate; 
			document.cookie = "CURRENT_ENTRY_SHIFT=" + shiftid; 

			document.getElementById("frm_sdept_group_entry_view1").submit();
		} 
	}
}












function fn_empRateAutoLinks()
{
	if (confirm("Sure to do Auto create common Rate process!") == true) 
		null;		
	else 
		return;


	document.getElementById("WAIT_LOADING").style.display = "block";

	var data = new FormData();
	data.append("action", "AUTOLINKS");
	
	let fetchRes = fetch("l_sdept_emp_rate_refresh.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			document.getElementById("WAIT_LOADING").style.display = "none";
			alert("Successfully linked records based on Employee rate" + result[3]);
		}
		else
		{
			document.getElementById("WAIT_LOADING").style.display = "none";
			alert("Error" + d);
		}
		
	});
}


function fnReCalculateWages(arg_id, arg_tstamp)
{
	if (confirm("Sure to do recalculation work!") == true) 
		null;		
	else 
		return;

	document.getElementById("WAIT_LOADING").style.display = "block";

	
	var data = new FormData();
	data.append("opt", 9);
	data.append("rid", arg_id);
	data.append("tstamp", arg_tstamp);
	
	let fetchRes = fetch("t_wpentries_recalculate.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			document.getElementById("WAIT_LOADING").style.display = "none";
			alert("Successfully recalculated the wages for this wages period.");
//			alert(result[3]);
//			alert("Successfully recalculated the wages for this wages period. " + result[3]);
		}
		else
		{
			document.getElementById("WAIT_LOADING").style.display = "none";
			alert("Error" + d);
		}
		
	});
}


function fnAutoLinkWork(arg_id, arg_tstamp)
{
	if (confirm("Sure to make auto entries!") == true) 
		null;		
	else 
		return;
	
	var data = new FormData();
	data.append("opt", 9);
	data.append("rid", arg_id);
	data.append("tstamp", arg_tstamp);
	
	let fetchRes = fetch("t_wpentries_autosave.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			alert("Successfully linked works with this wages period");
		else
			alert("Error" + d);
		
	});
}


function fnSave()
{
	fnLinkWork();
}


function fnLinkWork()
{
	document.getElementById("pb_save").value = "Saving... ";

	var v_code = document.getElementById("code").value;
	var v_date = document.getElementById("date").value;

	var records = '';
	var pcounter = 0;
	var rows = document.querySelectorAll("tr.TR_EMPLOYEE_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var x1 =  rows[i].querySelector(".CL_EMP").value; 
		x1 = +x1;

		var y1 =  rows[i].querySelector(".CL_ADVANCE").value; 
		y1 = +y1;

		var FILTER_RECORDS =  "CL_CK" + x1;
		var SELECTED_RECORDS =  "";
		var counter = 0;

//		alert("x1 - " + x1 + ". Length " + rows.length);

		var inputs = document.getElementsByClassName(FILTER_RECORDS);
		for(var j = 0, l = inputs.length; j < l; ++j) 
		{
//			alert(x1 + " - " + inputs[j].checked);
			if (inputs[j].checked == true)
			{
				if (counter > 0)
					SELECTED_RECORDS =  SELECTED_RECORDS + ",";
					

				SELECTED_RECORDS =  SELECTED_RECORDS + inputs[j].value;
				counter++;
			}
		}		


		if (counter > 0)
		{
//			alert("x1 - " + x1);
			records = myTrim(records) + 'AA'  + '##$##' + x1 + '##$##' + y1 + '##$##' + SELECTED_RECORDS + '##$##' +  'AA' + '$$#$$';
			pcounter++;
		}

	}	
	records = myTrim(records);
//	alert("records - " + records);
	if (pcounter > 0)
	{
		null; 
	}
	else
	{
		alert("Atleast one entry is required");
		document.getElementById("pb_save").value = "Save";
		return;
	}

	var data = new FormData();
	data.append("action", "SAVE");
	data.append("v_code", v_code);
	data.append("v_date", v_date);
	data.append("v_records", records);

	let fetchRes = fetch("t_wpentries_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
	
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
		document.getElementById("pb_save").value = "Save";
	});
}


function fnSelectCB(employee)
{
	var parent_cb = "CK" + employee;
	var child_cb = "CL_CK" + employee;
	
	if (document.getElementById(parent_cb).checked)
	{
		var inputs = document.getElementsByClassName(child_cb);
		for(var i = 0, l = inputs.length; i < l; ++i) 
		{
			inputs[i].checked = true;
		}		
	}
	else
	{
		var inputs = document.getElementsByClassName(child_cb);
		for(var i = 0, l = inputs.length; i < l; ++i) 
		{
			inputs[i].checked = false;
		}		
	}
}




function fn_wagesperiod_add() 
{
	var data = new FormData();
	data.append("opt", 1);
	data.append("action", "ADD");
	data.append("fname", document.getElementById("txt_fname").value);
	data.append("date_from", document.getElementById("txt_date_from").value);
	data.append("date_to", document.getElementById("txt_date_to").value);
	data.append("factoryid", document.getElementById("txt_factoryid").value);
	data.append("dtl", document.getElementById("txt_dtl").value);

	data.append("wdays", document.getElementById("txt_wdays").value);
	
	let fetchRes = fetch("t_wagesperiod_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{

		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}

function fn_wagesperiod_view() 
{
	var data = new FormData();
	data.append("action", "VIEW");
	data.append("opt", 7);
	let fetchRes = fetch("t_wagesperiod_db.php", {method: 'POST',body: data});
	fetchRes.then(res=>res.json()).then(d=>{
		document.getElementById("DIV_RECORDS").innerHTML=d;
	});
}

function fn_wagesperiod_edit(recid)
{
	document.getElementById('txt_rid2').value = recid;
	document.getElementById('txt_fname2').value = document.getElementById('txt_fname_' + recid).value;
	document.getElementById('txt_date_from2').value = document.getElementById('txt_date_from_' + recid).value;
	document.getElementById('txt_date_to2').value = document.getElementById('txt_date_to_' + recid).value;
	document.getElementById('txt_factoryid2').value = document.getElementById('txt_factory_' + recid).value;
	document.getElementById('txt_dtl2').value = document.getElementById('txt_dtl_' + recid).value;
	
	document.getElementById('txt_wdays2').value = document.getElementById('txt_wdays_' + recid).value;
	
	document.getElementById('Window_Modal_Update').style.display='block';
}


function fn_wagesperiod_update() 
{
	var data = new FormData();
	data.append("action", "UPDATE");
	data.append("opt", 2);
	data.append("rid", document.getElementById("txt_rid2").value);
	data.append("fname", document.getElementById("txt_fname2").value);
	data.append("date_from", document.getElementById("txt_date_from2").value);
	data.append("date_to", document.getElementById("txt_date_to2").value);
	data.append("factoryid", document.getElementById("txt_factoryid2").value);
	data.append("dtl", document.getElementById("txt_dtl2").value);

	data.append("wdays", document.getElementById("txt_wdays2").value);
	
	let fetchRes = fetch("t_wagesperiod_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}
		
function fn_wagesperiod_mark(arg_id, arg_field, arg_flag)
{
	var data = new FormData();
	data.append("opt", 3);
	data.append("rid", arg_id);
	data.append("field", arg_field);
	data.append("flag", arg_flag);
	
	let fetchRes = fetch("t_wagesperiod_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}


function fn_wagesperiod_delete(arg_id, arg_tstamp)
{
	if (confirm("Sure to Delete!") == true) 
		null;		
	else 
		return;
	
	
	var data = new FormData();
	data.append("opt", 9);
	data.append("rid", arg_id);
	data.append("tstamp", arg_tstamp);
	
	let fetchRes = fetch("t_wagesperiod_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}



function fn_wagesperiod_lock(arg_id, arg_field, arg_flag)
{
	if (confirm("Sure to Lock the period!") == true) 
	{
		null;
	} 
	else 
	{
		return;
	}			
	
	
	
	var data = new FormData();
	data.append("opt", 33);
	data.append("rid", arg_id);
	data.append("field", arg_field);
	data.append("flag", arg_flag);
	
	let fetchRes = fetch("t_wagesperiod_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}




function fn_PDS_CalculateWages(arg_fieldtype, arg_fieldid)
{
	if (arg_fieldtype == 1)
		var arg_fieldname = "A" + arg_fieldid;
	else if (arg_fieldtype == 2)
		var arg_fieldname = "B" + arg_fieldid;
	else if (arg_fieldtype == 3)
		var arg_fieldname = "C" + arg_fieldid;
	else
		return;

	var employeeid = document.getElementById("emp" + arg_fieldname).value;
	
	if (employeeid > 0)
		null;
	else
	{
		alert("Kindly select the employee name ");
//		alert("Kindly select the employee name " + employeeid + "#emp" + arg_fieldname);
		return;
	}
		
	var subdepartmentid = document.getElementById("subdepartmentid").value;
	var productid = document.getElementById("productid").value;
	var machineid = document.getElementById("machineid").value;
	var processid = document.getElementById("processid").value;

  //	var processwages = $("#processwages").val();
	//var processwages_nou = $("#processwages_nou").val();

	var e = document.getElementById("emp" + arg_fieldname);
//	var value = e.value;
//	var text = e.options[e.selectedIndex].text;
	var processwages = e.options[e.selectedIndex].getAttribute("data-wages");
	processwages = +processwages;
	var processwages_nou = e.options[e.selectedIndex].getAttribute("data-wages-nou");
	processwages_nou = +processwages_nou;

	var nou = document.getElementById("nou" + arg_fieldname).value;
	var amt = (+nou * +processwages) / (+processwages_nou);
	amt = amt.toFixed(2);
	document.getElementById("amt" + arg_fieldname).value = amt;
}




function fn_PDS_SaveWork()
{
	document.getElementById("pb_save").value = "Saving... ";

	var subdepartmentid = document.getElementById("subdepartmentid").value;
	var shiftid = document.getElementById("shiftid").value;
	var productid = document.getElementById("productid").value;
	var machineid = document.getElementById("machineid").value;
	var processid = document.getElementById("processid").value;

	var v_tdate = document.getElementById("tdate").value;

	var records = '';
	var pcounter = 0;
	var rows = document.querySelectorAll("tr.TR_EMPLOYEE_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var x1 =  rows[i].querySelector(".CL_EMP").value; 
		x1 = +x1;

		var y1 =  rows[i].querySelector(".CL_NOU").value; 
		y1 = +y1;

		if (x1 > 0)
		{
			//alert("x1 - " + x1);
			records = myTrim(records) + 'AA'  + '##$##' + x1 + '##$##' + y1 + '##$##' +  'AA' + '$$#$$';
			pcounter++;
		}
	}	
	records = myTrim(records);

	if (pcounter > 0)
	{
		null;
	}
	else
	{
		alert("Atleast one entry is required");
		document.getElementById("pb_save").value = "Save";
		return;
	}

	//alert(records);
	//records = encodeURIComponent(records);
	//alert(records);

	var subdepartmentid = document.getElementById("subdepartmentid").value;
	var productid = document.getElementById("productid").value;
	var machineid = document.getElementById("machineid").value;
	var processid = document.getElementById("processid").value;

	var v_tdate = document.getElementById("tdate").value;



	var data = new FormData();
	data.append("action", "SAVE");
	data.append("subdepartmentid", document.getElementById("subdepartmentid").value);
	data.append("shiftid", document.getElementById("shiftid").value);
	data.append("productid", document.getElementById("productid").value);
	data.append("machineid", document.getElementById("machineid").value);
	data.append("processid", document.getElementById("processid").value);
	data.append("tdate", document.getElementById("tdate").value);
	data.append("records", records);

	let fetchRes = fetch("t_sdept_entry_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
	
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
		document.getElementById("pb_save").value = "Save";
	});

}















var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
	var currentScrollPos = window.pageYOffset;
	if (prevScrollpos > currentScrollPos) 
	{
		document.getElementById("SOWW_FOOTER").style.bottom = "0";
	} 
	else 
	{
		document.getElementById("SOWW_FOOTER").style.bottom = "-50px";
	}
	prevScrollpos = currentScrollPos;
}


var button = document.createElement('input');
button.setAttribute('type', 'button');
button.setAttribute('id', 'btnSrollTop');
button.setAttribute('value', 'Top');
button.setAttribute('onclick', 'fn_goToPageTop()');
button.setAttribute("class", "w3-button w3-small w3-red w3-hover-indigo");
document.body.appendChild(button);


var elem_btnSrollTop = document.getElementById("btnSrollTop");

window.onscroll = function() {fn_pageScrollFunction()};

function fn_pageScrollFunction() 
{
	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) 
	{
		elem_btnSrollTop.style.display = "block";
	} 
	else 
	{
		elem_btnSrollTop.style.display = "none";
	}
}

// When the user clicks on the button, scroll to the top of the document
function fn_goToPageTop() 
{
	document.body.scrollTop = 0;
	document.documentElement.scrollTop = 0;
}



















function fn_initEntryDate()
{
	var date = document.getElementById("tdate").value;
	if ( date.length > 0 )
	{
		tempAlert("Kindly check the Date and Shift");
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = false;
		}
	}
	else
	{
		alert("Kindly enter the date");
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = true;
		}
	}
}

function fn_changeEntryDate()
{
	var date = document.getElementById("tdate").value;
	if ( date.length > 0 )
	{
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = false;
		}
		
		if (document.getElementById("tdate").defaultValue == document.getElementById("tdate").value)	
			null;
		else
		{
			if (confirm("Sure to change Date!  Going to relaod the page") == true) 
			{
				var tdate = document.getElementById("tdate").value;
				var shiftid = document.getElementById("txt_shiftid").value;
				
				document.cookie = "CURRENT_ENTRY_DATE=" + tdate; 
				document.cookie = "CURRENT_ENTRY_SHIFT=" + shiftid; 

			    document.getElementById("tdate2").value = document.getElementById("tdate").value;		
				document.getElementById("shift2").value = shiftid;		
				
				document.getElementById("frm_sdept_entry_view1").submit();
			} 
			else 
			{
				return;
			}			
		}
	}
	else
	{
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = true;
		}
	}
}

function fn_changeEntryShift()
{
	var shiftid = document.getElementById("txt_shiftid").value;
	if ( shiftid > 0 )
	{
		if (confirm("Sure to change Shift!  Going to relaod the page" + shiftid) == true) 
		{
			var tdate = document.getElementById("tdate").value;
			//var shiftid = document.getElementById("txt_shiftid").value;
			
			document.cookie = "CURRENT_ENTRY_DATE=" + tdate; 
			document.cookie = "CURRENT_ENTRY_SHIFT=" + shiftid; 


			document.getElementById("tdate2").value = document.getElementById("tdate").value;		
			document.getElementById("shift2").value = shiftid;		
			
			document.getElementById("frm_sdept_entry_view1").submit();
		} 
	}
}

function fn_link_saveEmployeeSdeptRate(elem, sdept, product, machine, process, employee)
{
	var amount	= elem.value;
	if (amount > 0)
		null;
	else
	{
		return;
	}
	
	var data = new FormData();
	data.append("action", "SAVE");
	data.append("sdept", sdept);
	data.append("product", product);
	data.append("machine", machine);
	data.append("process", process);
	data.append("employee", employee);
	data.append("amount", amount);
	
	let fetchRes = fetch("l_sdept_emp_rate_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			//alert("Success");
			//window.location.reload();
			tempAlert("Saved successfully");
			null;
		}
		else
		{
			alert("Error" + d);
		}
	});
	
}


function fn_link_saveSdeptRate(elem, sdept, product, machine, process)
{
	var amount	= elem.value;
	if (amount > 0)
		null;
	else
	{
		return;
	}
	
	var data = new FormData();
	data.append("action", "SAVE");
	data.append("sdept", sdept);
	data.append("product", product);
	data.append("machine", machine);
	data.append("process", process);
	data.append("amount", amount);
	
	let fetchRes = fetch("l_sdept_rate_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			//alert("Success");
			//window.location.reload();
			tempAlert("Saved successfully");
			null;
		}
		else
		{
			alert("Error" + d);
		}
	});
}


function fn_link_MastersSave(flag, master1, recid1, master2, recid2)
{
	var data = new FormData();
	data.append("action", "SAVE");
	data.append("flag", flag);
	data.append("master1", master1);
	data.append("recid1", recid1);
	data.append("master2", master2);
	data.append("recid2", recid2);
	
	let fetchRes = fetch("l_masters_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			//alert("Success");
			//window.location.reload();
			tempAlert("Saved successfully");
			null;
		}
		else
		{
			alert("Error" + d);
		}
	});
}


function decodeHtml(html) 
{
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}
function tempAlert(msg,duration=2000)
{
     var el = document.createElement("div");
     el.setAttribute("style","position:absolute; bottom:20%; width:100%; min-height:40px; padding:3px; text-align:center; background-color: #cc0000; color: white;");
     el.innerHTML = msg;
     setTimeout(function(){
      el.parentNode.removeChild(el);
     },duration);
     document.body.appendChild(el);
}
function htmlEntities(str) 
{
   return str.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {return '&#'+i.charCodeAt(0)+';';});
}
function nl2br (str, is_xhtml) 
{
    if (typeof str === 'undefined' || str === null) 
    {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
function myTrim(x)
{
    return x.replace(/^\s+|\s+$/gm, '');
}
function pad(num, size) 
{
    var s = "00000" + num;
    return s.substr(s.length-size);
}
function rupees(num)
{
    var thecash = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	return thecash;
}





function fn_link_saveSdeptMaster(flag, sdept, field, recid)
{
	var data = new FormData();
	data.append("action", "SAVE");
	data.append("flag", flag);
	data.append("sdept", sdept);
	data.append("field", field);
	data.append("recid", recid);
	
	let fetchRes = fetch("l_sdept_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			//alert("Success");
			//window.location.reload();
			tempAlert("Saved successfully");
			null;
		}
		else
		{
			alert("Error" + d);
		}
	});
}

function fn_link_sdept_chkMasters()
{
	var e1 = document.getElementById("master1");
	var value1 = e1.value;
	var text1 = e1.options[e1.selectedIndex].text;	

	var e2 = document.getElementById("master2");
	var value2 = e2.value;
	var text2 = e2.options[e2.selectedIndex].text;	

	if (value1.length > 0)
		null;
	else
	{
		document.getElementById("master1").focus();
		return;
	}

	if (value2.length > 0)
		null;
	else
	{
		document.getElementById("master2").focus();
		return;
	}
}


function fn_link_chkMasters()
{
	var e1 = document.getElementById("master1");
	var value1 = e1.value;
	var text1 = e1.options[e1.selectedIndex].text;	

	var e2 = document.getElementById("master2");
	var value2 = e2.value;
	var text2 = e2.options[e2.selectedIndex].text;	

	if (value1 == value2)
	{
		e2.value = "";
		return;
	}	

	if (value1.length > 0)
		null;
	else
	{
		if (value2.length > 0)
			null;
		else
			alert("Kindly select masters");
		
		document.getElementById("master1").focus();
		return;
	}

	if (value2.length > 0)
		null;
	else
	{
		if (value1.length > 0)
			null;
		else
			alert("Kindly select masters");
		
		document.getElementById("master2").focus();
		return;
	}
}


function fn_pdf()
{
	var header, footer;
	header = "<html><head></head><body>"
	footer = "</body></html>"


	if (LS_CUR_PAGE == "BILLLIST")
		var element = document.documentElement;
	else if (LS_CUR_PAGE == "BILLVIEW")
		var element = document.getElementById("PRINT_BILL");
	else
		if (!document.getElementById("dataTable"))
			if (!document.getElementById("TABLE_OUTPUT"))
				var element = document.documentElement;
			else
				var element = document.getElementById("TABLE_OUTPUT");
		else
			var element = document.getElementById("dataTable");
	
//	var element = document.documentElement;

	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	today = yyyy + mm + dd + today.getHours() + today.getMinutes();

	var export_filename = "doc-" + today + ".pdf";

	var opt = {
	  margin:       0,
	  filename:     export_filename,
	  image:        { type: "jpeg", quality: 0.98 },
	  html2canvas:  { scale: 2 },
	  jsPDF:        { unit: "in", format: "a4", orientation: "portrait", margin: "5px" }
	};
	
	html2pdf().set(opt).from(element).save();
}


function fn_jpg()
{
//	var element = document.body;
	if (LS_CUR_PAGE == "BILLLIST")
		var element = document.documentElement;
	else if (LS_CUR_PAGE == "BILLVIEW")
		var element = document.getElementById("PRINT_BILL");
	else
		if (!document.getElementById("dataTable"))
			if (!document.getElementById("TABLE_OUTPUT"))
				var element = document.documentElement;
			else
				var element = document.getElementById("TABLE_OUTPUT");
		else
			var element = document.getElementById("dataTable");
	
	html2canvas(element).then(function(canvas) 
	{
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today.getFullYear();
		today = yyyy + mm + dd + today.getHours() + today.getMinutes();


		var export_filename = "img-" + today + ".jpg";

		var link = document.createElement('a');
		link.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
		link.download = export_filename;
		document.body.appendChild(link); // Required for FF
		link.click();
	});
	
	
}



function fn_csv()
{
	var today = new Date();
	var dd = String(today.getDate()).padStart(2, '0');
	var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
	var yyyy = today.getFullYear();
	today = yyyy + mm + dd;

	var export_filename = "data-" + today + ".csv";

	var counter = 0;
	var csv_data = [];

	var rows = document.querySelectorAll('tr.CL_CSV')	
	for (var i = 0; i < rows.length; i++) 
	{
		// Get each column data
		var cols = rows[i].querySelectorAll('th.CL_CSV');
		// Stores each csv row data
		var csvrow = [];
		for (var j = 0; j < cols.length; j++) 
		{
			// Get the text data of each cell
			// of a row and push it to csvrow
			/*
			var className = cols[j].className;
			if (className == "CL_NOCSV")
				null;
			else
				csvrow.push(cols[j].innerHTML);
			*/

			let text = cols[j].innerHTML;
			let text2 = text.replace('"', "''");

			csvrow.push('"' + text2 + '"');
		}
		// Combine each column value with comma
		csv_data.push(csvrow.join(","));
		counter++;
	}


	// Get each row data
//	var rows = document.getElementsByTagName('tr.CL_CSV');
	var rows = document.querySelectorAll('tr.CL_CSV')	
	for (var i = 0; i < rows.length; i++) 
	{
		// Get each column data
		var cols = rows[i].querySelectorAll('td.CL_CSV');
		// Stores each csv row data
		var csvrow = [];
		var flag = 0;
		for (var j = 0; j < cols.length; j++) 
		{
			// Get the text data of each cell
			// of a row and push it to csvrow
			/*
			var className = cols[j].className;
			if (className == "CL_NOCSV")
				null;
			else
				csvrow.push(cols[j].innerHTML);
*/

			let text = cols[j].innerHTML;
			let text2 = text.replace('"', "''");

			csvrow.push('"' + text2 + '"');

			flag = 1;
		}
		// Combine each column value with comma
		if (flag == 1)
		{
			csv_data.push(csvrow.join(","));
			counter++;
		}
	}



	if (counter > 0)
	{
		csv_data = csv_data.filter(function(entry) { return /\S/.test(entry); });
		
		/*
		for(var i=csv_data.length-1;i>=0;i--)
		{
			if(csv_data[i]=="")
			   csv_data.splice(i,1);
			else
				if(csv_data[i].length > 1)
					null;
				else
				   csv_data.splice(i,1);
		}		
		*/
		
		// Combine each row data with new line character
		csv_data = csv_data.join('\n');
		// Call this function to download csv file 
		downloadCSVFile(csv_data, export_filename);
	}
	else
	{
		alert("Cannot find any table to download in .csv format");
	}

	
}

	

function downloadCSVFile(csv_data, download_filename) 
{

	// Create CSV file object and feed
	// our csv_data into it
	CSVFile = new Blob([csv_data], {
		type: "text/csv"
	});

	// Create to temporary link to initiate
	// download process
	var temp_link = document.createElement('a');

	// Download csv file
	temp_link.download = download_filename + ".csv";
	var url = window.URL.createObjectURL(CSVFile);
	temp_link.href = url;

	// This link should not be displayed
	temp_link.style.display = "none";
	document.body.appendChild(temp_link);

	// Automatically click the link to
	// trigger download
	temp_link.click();
	document.body.removeChild(temp_link);
	
}	








function sortTable(tableid, columnid, fieldtype) 
{
	var table_name = "";
	tableid = +tableid; 
	if (tableid == 1)
		table_name = "Table_Output";
	else
		return;

	var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	table = document.getElementById(table_name);
	switching = true;  //Set the sorting direction to ascending:
	dir = "asc"; 
	/*Make a loop that will continue until  no switching has been done:*/
	while (switching) 
	{
		//start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/*Loop through all table rows (except the   first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) 
		{
			//start by saying there should be no switching:
			shouldSwitch = false;
			/*Get the two elements you want to compare,      one from current row and one from the next:*/
			x = rows[i].getElementsByTagName("TD")[columnid];
			y = rows[i + 1].getElementsByTagName("TD")[columnid];
			/*check if the two rows should switch place,      based on the direction, asc or desc:*/
			if (dir == "asc") 
			{
				if (fieldtype == 0)
				{
					if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) 
					{
						//if so, mark as a switch and break the loop:
						shouldSwitch= true;
						break;
					}
				}
				else if (fieldtype == 1)
				{
					if (Number(x.innerHTML) > Number(y.innerHTML))
					{
						//if so, mark as a switch and break the loop:
						shouldSwitch= true;
						break;
					}
				}
				
			} 
			else if (dir == "desc") 
			{
				if (fieldtype == 0)
				{
					if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) 
					{
						//if so, mark as a switch and break the loop:
						shouldSwitch = true;
						break;
					}
				}
				else if (fieldtype == 1)
				{
					if (Number(x.innerHTML) < Number(y.innerHTML))
					{
						//if so, mark as a switch and break the loop:
						shouldSwitch= true;
						break;
					}
				}
			}
		}
		if (shouldSwitch) 
		{
			/*If a switch has been marked, make the switch      and mark that a switch has been done:*/
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			//Each time a switch is done, increase this count by 1:
			switchcount ++;      
		} 
		else 
		{
			/*If no switching has been done AND the direction is "asc",		set the direction to "desc" and run the while loop again.*/
			if (switchcount == 0 && dir == "asc") 
			{
				dir = "desc";
				switching = true;
			}
		}
	}
}


function fn_FilterRecords(tableid, inputid) 
{
	var table_name = "";
	tableid = +tableid; 
	if (tableid == 1)
		table_name = "Table_Output";
	else
		return;
	
	var input_name = "";
	inputid = +inputid; 
	if (inputid == 1)
		input_name = "txt_filter";
	else
		return;
	
	
	// Declare variables
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById(input_name);
	filter = input.value.toUpperCase();
	table = document.getElementById(table_name);
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) 
	{
		td = tr[i].getElementsByTagName("td")[1];
		if (td) 
		{
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) 
			{
				tr[i].style.display = "";
			} 
			else 
			{
				tr[i].style.display = "none";
			}
		}
	}
}













function fn_active(arg_rid, arg_date)
{

	var data = new FormData();
	data.append("action", "UPDATE");
	data.append("arg_rid", arg_rid);
	data.append("arg_date", arg_date);
	
	let fetchRes = fetch("tentry_flag.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}




function fn_modifyBill()
{
	var products = '';
	var pcounter = 0;
	var rows = document.querySelectorAll("tr.CSS_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var txt_product = rows[i].querySelector(".CSS_PRODUCT").value;
		var txt_amount = rows[i].querySelector(".CSS_AMOUNT").value;

		txt_amount = +txt_amount;
		if (txt_amount > 0)
		{
			if (txt_product.length > 0)
			{
				products = myTrim(products) + 'AA'  + '##$##' + txt_product + '##$##' + txt_amount + '##$##' +  'AA' + '$$#$$';
				pcounter++;
			}
		}
	}	
	 products = myTrim(products);

	if (pcounter > 0)
	{
		null;
	}
	else
	{
		alert("Select atleast one product ");
		return;
	}

	//alert(products);
//	products = encodeURIComponent(products);
	//alert(products);


	var data = new FormData();
	data.append("action", "MODIFY");
	data.append("rid", document.getElementById("rid").value);
	data.append("sdate", document.getElementById("sdate").value);
	data.append("ino", document.getElementById("ino").value);
	data.append("tdate", document.getElementById("tdate").value);
	data.append("party1", document.getElementById("txt_party1").value);
	data.append("party2", document.getElementById("txt_party2").value);
	data.append("party3", document.getElementById("txt_party3").value);
	data.append("balance_amt", document.getElementById("balance_amt").value);
	data.append("txt_dtl", document.getElementById("txt_dtl").value);
	data.append("products", products);

	let fetchRes = fetch("tentry_modify.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}



function fn_updateInvoiceEdit()
{
	var v_tot_amt = 0;

	var rows = document.querySelectorAll("tr.CSS_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var txt_product = rows[i].querySelector(".CSS_PRODUCT").value;
		var txt_amount = rows[i].querySelector(".CSS_AMOUNT").value;

		txt_amount = +txt_amount;
		if (txt_amount > 0)
		{
			if (txt_product.length > 0)
			{
				v_tot_amt = v_tot_amt + txt_amount;
			}
		}
	}	
	v_tot_amt = +v_tot_amt;
	document.getElementById("tot_amt").value = parseFloat(v_tot_amt).toFixed(0);
//	document.getElementById("tot_amt").value = parseFloat(v_tot_amt).toFixed(2);
}




function addRow(tableID)
{
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount-1);
	row.className = "CSS_ROW";
	var colCount = table.rows[1].cells.length;

	for(var i=0; i<colCount; i++)
	{
        var newcell = row.insertCell(i);

		newcell.innerHTML = table.rows[1].cells[i].innerHTML;
		 //$(newcell).addClass("CSS_ROW");
		//alert(newcell.childNodes);
		switch(newcell.childNodes[0].type)
		{
			case "text":
					newcell.childNodes[0].value = "";
					break;
			case "checkbox":
					newcell.childNodes[0].checked = false;
					break;
			case "select-one":
					newcell.childNodes[0].selectedIndex = 0;
					break;
        }
    }
}

function deleteRow(tableID)
{
	try
	{
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;

		for(var i = 1; i < rowCount-2; i++)
		{
			var row = table.rows[i];

			var txt_product = row.cells[0].childNodes[0].value;
			var txt_rate = row.cells[1].childNodes[0].value;
			var txt_qty = row.cells[2].childNodes[0].value;
			var txt_amount = row.cells[3].childNodes[0].value;

			var flag = 0;
			if (txt_qty > 0)
				flag = 1;
				
			if (flag == 0)
				table.deleteRow(i);
		}
	}
	catch(e)
	{
		alert(e);
	}
}


function clearRows(tableID, arg)
{
/* 
0 - Delete all unused product rows
1 - Delete all unused product rows except last one row
*/
	return;
	arg = 2;
	try
	{
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;

		for(var i = 1; i < rowCount-arg; i++)
		{
			var row = table.rows[i];
			var txtbox = row.cells[1].childNodes[0];

			if(null != txtbox && txtbox.value > 0)
			{
				null;
			}
			else
			{
				if(rowCount <= 2)
				{
					alert("Cannot delete all the rows.");
					break;
				}
				table.deleteRow(i);
				rowCount--;
				i--;
			}
		}
	}
	catch(e)
	{
		alert("Error " + e);
	}
}


function rupee(num)
{

    var thecash = num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

	return thecash;
}





function myTrim(x)
{
	return x.replace(/^\s+|\s+$/gm, "");
}



function fn_saveBill()
{
	var products = '';
	var pcounter = 0;
	var rows = document.querySelectorAll("tr.CSS_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var txt_product = rows[i].querySelector(".CSS_PRODUCT").value;
		var txt_amount = rows[i].querySelector(".CSS_AMOUNT").value;

		txt_amount = +txt_amount;
		if (txt_amount > 0)
		{
			if (txt_product.length > 0)
			{
				products = myTrim(products) + 'AA'  + '##$##' + txt_product + '##$##' + txt_amount + '##$##' +  'AA' + '$$#$$';
				pcounter++;
			}
		}
	}	
	 products = myTrim(products);

	if (pcounter > 0)
	{
		null;
	}
	else
	{
		alert("Select atleast one product ");
		return;
	}

	//alert(products);
//	products = encodeURIComponent(products);
	//alert(products);


	var data = new FormData();
	data.append("action", "SAVE");
	data.append("tdate", document.getElementById("tdate").value);
	data.append("party1", document.getElementById("txt_party1").value);
	data.append("party2", document.getElementById("txt_party2").value);
	data.append("party3", document.getElementById("txt_party3").value);
	data.append("balance_amt", document.getElementById("balance_amt").value);
	data.append("txt_dtl", document.getElementById("txt_dtl").value);
	data.append("products", products);
	
	let fetchRes = fetch("tentry_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}



function fn_updateInvoiceNew()
{
	var v_tot_amt = 0;

	var rows = document.querySelectorAll("tr.CSS_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var txt_product = rows[i].querySelector(".CSS_PRODUCT").value;
		var txt_product_id = rows[i].querySelector(".CSS_PRODUCT").getAttribute("data-id");
		var txt_product_rate = rows[i].querySelector(".CSS_PRODUCT").getAttribute("data-rate");
		var txt_rate = rows[i].querySelector(".CSS_RATE").value;
		if (txt_rate > 0)
			null;
		else
			if (txt_product_rate > 0)
			{
				rows[i].querySelector(".CSS_RATE").value = txt_product_rate;
				txt_rate = txt_product_rate;
			}
			else
			{
				txt_rate = 0;
				txt_product_rate = 0;
			}
		
		var txt_qty = rows[i].querySelector(".CSS_QTY").value;
		var txt_amount = rows[i].querySelector(".CSS_AMOUNT").value;

		txt_qty = +txt_qty;
		if (txt_qty > 0)
		{
			if (txt_product.length > 0)
			{
				if (txt_rate > 0)
				{
					txt_amount = txt_rate * txt_qty;
					rows[i].querySelector(".CSS_AMOUNT").value = txt_amount;
					v_tot_amt = v_tot_amt + txt_amount;
				}
			}
		}

		txt_amount = +txt_amount;
		if (txt_amount > 0)
		{
			if (txt_product.length > 0)
			{
				v_tot_amt = v_tot_amt + txt_amount;
			}
		}
	}	
	v_tot_amt = +v_tot_amt;
	document.getElementById("ID_NEW_TXT_TOTAL_AMOUNT").value = parseFloat(v_tot_amt).toFixed(0);
//	document.getElementById("tot_amt").value = parseFloat(v_tot_amt).toFixed(2);
}










function FullScreen() 
{
  if (!document.fullscreenElement) 
  {
	openFullscreen();
  } 
  else if (document.exitFullscreen) 
  {
    closeFullscreen(); 
  }
}



/* View in fullscreen */
function openFullscreen() 
{
	/* Get the documentElement (<html>) to display the page in fullscreen */
	var elem = document.documentElement;

	if (elem.requestFullscreen) 
	{
		elem.requestFullscreen();
	} 
	else if (elem.webkitRequestFullscreen) 
	{ /* Safari */
		elem.webkitRequestFullscreen();
	} 
	else if (elem.msRequestFullscreen) 
	{ /* IE11 */
		elem.msRequestFullscreen();
	}
}

/* Close fullscreen */
function closeFullscreen() 
{
	if (document.exitFullscreen) 
	{
		document.exitFullscreen();
	} 
	else if (document.webkitExitFullscreen) 
	{ /* Safari */
		document.webkitExitFullscreen();
	} 
	else if (document.msExitFullscreen) 
	{ /* IE11 */
		document.msExitFullscreen();
	}
} 









var myIndex = 0;
carousel();

function carousel() 
{
	var i;
	var x = document.getElementsByClassName("mySlides");
	for (i = 0; i < x.length; i++) 
	{
		x[i].style.display = "none";  
	}
	myIndex++;
	if (myIndex > x.length) 
	{
		myIndex = 1
	}    
	if ((typeof x[myIndex-1] !== "undefined") && (x[myIndex-1] !== null) )
		x[myIndex-1].style.display = "block";  
	
	setTimeout(carousel, 9000);    
}

	
		



function fn_MinNavbar() 
{
  var x = document.getElementById("NAVBAR_MOBILE");
  if (x.className.indexOf("w3-show") == -1) 
  {
    x.className += " w3-show";
  } 
  else 
  { 
    x.className = x.className.replace(" w3-show", "");
  }
}

function openLink(evt, animName) 
{
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) 
  {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) 
  {
    tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(animName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}

function fnLogout() 
{
	if (confirm('Are you sure to logout?')) 
		null;
	else 
		return;
		
	deleteCookies();
	deleteLocalStorage();
	
	location.replace("https://diskplay.live/logout.php?logout=1");
}

function deleteCookies() 
{
	document.cookie = "username=sowwdisplayliveorguserceg; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
	
    
}	

function deleteLocalStorage() 
{
	null;
//	localStorage.clear();
}	


function setCookie(cname, cvalue, exdays) 
{
	  const d = new Date();
	  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	  let expires = "expires="+d.toUTCString();
	  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) 
{
	let name = cname + "=";
	let ca = document.cookie.split(';');
	for(let i = 0; i < ca.length; i++) {
	let c = ca[i];
	while (c.charAt(0) == ' ') {
	  c = c.substring(1);
	}
	if (c.indexOf(name) == 0) {
	  return c.substring(name.length, c.length);
	}
	}
	return "";
}

function checkCookie() 
{
	let user = getCookie("username");
	if (user != "") 
	{
		alert("Welcome again " + user);
	} 
	else 
	{
		user = prompt("Please enter your name:", "");
		if (user != "" && user != null) 
		{
			setCookie("username", user, 365);
		}
	}
} 

function fn_app_lang_set(arg_lang)
{
	if (arg_lang == 2)
	{
		localStorage.setItem("LS_APP_LANG", "English");
		setCookie("COOKIE_APP_LANG", "English", 365);
	}
	else if (arg_lang == 1)
	{
		localStorage.setItem("LS_APP_LANG", "Tamil");
		setCookie("COOKIE_APP_LANG", "Tamil", 365);
	}
	else
	{
		localStorage.setItem("LS_APP_LANG", "English");
		setCookie("COOKIE_APP_LANG", "English", 365);
	}
		
	fn_app_lang();		
	
	if (LS_CUR_PAGE == "BILLNEW")
		null;
	else
		 location.reload(); 
}
/*
 * DASHBOARD
 * BILLLIST
 * BILLLISTINACTIVE
 * BILLEDIT
 * BILLNEW
 * BILLVIEW
 * MDSETTINGS
 * ALTERPASS
 * 
*/

function fn_app_lang()
{
	ARR_LANG = [];
	ARR_LANG["English"] = [];
	ARR_LANG["Tamil"] = [];
	
	
	ARR_LANG["English"]["BILL"] = "Bill";
	ARR_LANG["English"]["BILLNEW"] = "New Bill";
	ARR_LANG["English"]["BILLLIST"] = "Bill List";
	ARR_LANG["English"]["SETTINGS"] = "Settings";

	ARR_LANG["English"]["CHANGEPASSWORD"] = "Change Password";
	ARR_LANG["English"]["LOGOUT"] = "Logout";
	ARR_LANG["English"]["IMAGE"] = "Image";
	ARR_LANG["English"]["PDF"] = "PDF";
	ARR_LANG["English"]["EXCEL"] = "Excel";
	ARR_LANG["English"]["SHARE"] = "Share";
	ARR_LANG["English"]["PRINT"] = "Print";
	ARR_LANG["English"]["REFRESH"] = "Refresh";
	ARR_LANG["English"]["PARTY"] = "Party";
	ARR_LANG["English"]["AMOUNT"] = "Amount";
	ARR_LANG["English"]["BALANCE"] = "Balance";
	ARR_LANG["English"]["ACTIVE"] = "Active";
	ARR_LANG["English"]["ACTION"] = "Action";
	ARR_LANG["English"]["CREATENEWBILL"] = "Create new Bill";
	ARR_LANG["English"]["VIEWBILLLIST"] = "View Bill List";

	ARR_LANG["English"]["NEWDTLPRODUCT"] = "Product";
	ARR_LANG["English"]["NEWDTLAMOUNT"] = "Amount[Rs.]";
	ARR_LANG["English"]["NEWPLPRODUCT"] = "Product";
	ARR_LANG["English"]["NEWPLAMOUNT"] = "Amount";
	ARR_LANG["English"]["NEWTTOTAL"] = "Total";
	ARR_LANG["English"]["NEWATOTAL"] = "Total Amount";

	ARR_LANG["English"]["NEWDATE"] = "Transaction date";
	ARR_LANG["English"]["NEWPARTY1"] = "Party name";
	ARR_LANG["English"]["NEWPARTY2"] = "Party address";
	ARR_LANG["English"]["NEWPARTY3"] = "Party Phone";
	ARR_LANG["English"]["NEWBALAMT"] = "Balance Amount";
	ARR_LANG["English"]["NEWDETAILS"] = "Details";
	ARR_LANG["English"]["NEWSAVE"] = "Save";

	ARR_LANG["English"]["LISTDB"] = "Dashboard";
	ARR_LANG["English"]["LISTIBILLS"] = "Inactive List";
	ARR_LANG["English"]["LISTSEARCH"] = "Search...";
	ARR_LANG["English"]["LISTREFRESH"] = "Refresh Records";
	ARR_LANG["English"]["LISTFILTER"] = "Search...";

	ARR_LANG["English"]["LISTTOTAL"] = "TOTAL BILL AMOUNT";



	ARR_LANG["Tamil"]["LISTDB"] = "முகப்பு";
	ARR_LANG["Tamil"]["LISTIBILLS"] = "பழைய  பில்கள்";
	ARR_LANG["Tamil"]["LISTSEARCH"] = "தேடவும்";
	ARR_LANG["Tamil"]["LISTREFRESH"] = "ரீலோடு";
	ARR_LANG["Tamil"]["LISTFILTER"] = "தேடவும்";


	ARR_LANG["Tamil"]["BILL"] = "பில்";
	ARR_LANG["Tamil"]["BILLNEW"] = "புதிய பில்";
	ARR_LANG["Tamil"]["BILLLIST"] = "பில்கள்";
	ARR_LANG["Tamil"]["SETTINGS"] = "செட்டிங்குகள்";


	ARR_LANG["Tamil"]["CHANGEPASSWORD"] = "பாஸ்வேர்டை மாற்ற";
	ARR_LANG["Tamil"]["LOGOUT"] = "வெளியேற";
	ARR_LANG["Tamil"]["IMAGE"] = "படம்";
	ARR_LANG["Tamil"]["PDF"] = "பிடிஎப்";
	ARR_LANG["Tamil"]["EXCEL"] = "எக்ஸெல்";
	ARR_LANG["Tamil"]["SHARE"] = "ஷேர்";
	ARR_LANG["Tamil"]["PRINT"] = "பிரிண்ட்";
	ARR_LANG["Tamil"]["REFRESH"] = "ரீலோடு";
	ARR_LANG["Tamil"]["PARTY"] = "வாடிக்கையாளர்";
	ARR_LANG["Tamil"]["AMOUNT"] = "ரூபாய்";
	ARR_LANG["Tamil"]["BALANCE"] = "பாக்கி";
	ARR_LANG["Tamil"]["ACTIVE"] = "நிலை";
	ARR_LANG["Tamil"]["ACTION"] = "செயல்";
	ARR_LANG["Tamil"]["CREATENEWBILL"] = "புதிய பில்";
	ARR_LANG["Tamil"]["VIEWBILLLIST"] = "பில்கள்";

	ARR_LANG["Tamil"]["NEWDTLPRODUCT"] = "பொருள்";
	ARR_LANG["Tamil"]["NEWDTLAMOUNT"] = "ரூபாய்";
	ARR_LANG["Tamil"]["NEWPLPRODUCT"] = "பொருள்";
	ARR_LANG["Tamil"]["NEWPLAMOUNT"] = "ரூபாய்";
	ARR_LANG["Tamil"]["NEWTTOTAL"] = "மொத்தம்";
	ARR_LANG["Tamil"]["NEWATOTAL"] = "மொத்தம் ரூபாய்";

	ARR_LANG["Tamil"]["NEWDATE"] = "தேதி";
	ARR_LANG["Tamil"]["NEWPARTY1"] = "வாடிக்கையாளர்";
	ARR_LANG["Tamil"]["NEWPARTY2"] = "முகவரி";
	ARR_LANG["Tamil"]["NEWPARTY3"] = "போன்";
	ARR_LANG["Tamil"]["NEWBALAMT"] = "மீதி ரூபாய்";
	ARR_LANG["Tamil"]["NEWDETAILS"] = "விவரம்";
	ARR_LANG["Tamil"]["NEWSAVE"] = "சேமிக்கவும்";

	ARR_LANG["Tamil"]["LISTTOTAL"] = "மொத்தம் ரூபாய்";

	if ((typeof localStorage.getItem("LS_APP_LANG") !== "undefined") && (localStorage.getItem("LS_APP_LANG") !== null) )
		null;
	else
		localStorage.setItem("LS_APP_LANG", "English");


	var APP_LANG = localStorage.getItem("LS_APP_LANG");
	

/*
//	document.getElementById("ID_XCODE_NAVBAR_HOME_NEWBILL").innerHTML = ARR_LANG[APP_LANG]["BILLNEW"];
//	document.getElementById("ID_XCODE_NAVBAR_HOME_BILLLIST").innerHTML = ARR_LANG[APP_LANG]["BILLLIST"];
	document.getElementById("ID_XCODE_NAVBAR_HOME_SETTINGS").innerHTML = ARR_LANG[APP_LANG]["SETTINGS"];
	document.getElementById("ID_XCODE_NAVBAR_HOME_CHANGE_PASSWORD").innerHTML = ARR_LANG[APP_LANG]["CHANGEPASSWORD"];
	document.getElementById("ID_XCODE_NAVBAR_HOME_LOGOUT").innerHTML =  ARR_LANG[APP_LANG]["LOGOUT"];
	document.getElementById("ID_XCODE_NAVBAR_HOME_BILL").innerHTML = ARR_LANG[APP_LANG]["BILL"];



	document.getElementById("ID_XCODE_NAVBAR_MENU_NEWBILL").innerHTML = ARR_LANG[APP_LANG]["BILLNEW"];
//	document.getElementById("ID_XCODE_NAVBAR_MENU_BILLLIST").innerHTML = ARR_LANG[APP_LANG]["BILLIST"];
	document.getElementById("ID_XCODE_NAVBAR_MENU_SETTINGS").innerHTML = ARR_LANG[APP_LANG]["SETTINGS"];
	document.getElementById("ID_XCODE_NAVBAR_MENU_CHANGE_PASSWORD").innerHTML = ARR_LANG[APP_LANG]["CHANGEPASSWORD"];
	document.getElementById("ID_XCODE_NAVBAR_MENU_LOGOUT").innerHTML = ARR_LANG[APP_LANG]["LOGOUT"];
	document.getElementById("ID_XCODE_NAVBAR_MENU_BILL").innerHTML = ARR_LANG[APP_LANG]["BILL"];

	document.getElementById("ID_XCODE_FOOTER_IMAGE").innerHTML = ARR_LANG[APP_LANG]["IMAGE"];
	document.getElementById("ID_XCODE_FOOTER_PDF").innerHTML = ARR_LANG[APP_LANG]["PDF"];
	document.getElementById("ID_XCODE_FOOTER_CSV").innerHTML = ARR_LANG[APP_LANG]["EXCEL"];
	document.getElementById("ID_XCODE_FOOTER_SHARE").innerHTML = ARR_LANG[APP_LANG]["SHARE"];
	document.getElementById("ID_XCODE_FOOTER_PRINT").innerHTML = ARR_LANG[APP_LANG]["PRINT"];
	document.getElementById("ID_XCODE_FOOTER_REFRESH").innerHTML = ARR_LANG[APP_LANG]["REFRESH"];

	if ((LS_CUR_PAGE == "BILLLIST") || (LS_CUR_PAGE == "BILLLISTINACTIVE"))
	{
		document.getElementById("ID_LIST_TABLE_BILL").innerHTML = ARR_LANG[APP_LANG]["BILL"];
		document.getElementById("ID_LIST_TABLE_PARTY").innerHTML = ARR_LANG[APP_LANG]["PARTY"];
		document.getElementById("ID_LIST_TABLE_AMOUNT").innerHTML = ARR_LANG[APP_LANG]["AMOUNT"];
		document.getElementById("ID_LIST_TABLE_BALANCE").innerHTML = ARR_LANG[APP_LANG]["BALANCE"];
		document.getElementById("ID_LIST_TABLE_ACTIVE").innerHTML = ARR_LANG[APP_LANG]["ACTIVE"];
		document.getElementById("ID_LIST_TABLE_ACTION").innerHTML = ARR_LANG[APP_LANG]["ACTION"];

		document.getElementById("ID_LIST_DASHBOARD").innerHTML = ARR_LANG[APP_LANG]["LISTDB"];
		document.getElementById("ID_LIST_NEWBILL").innerHTML = ARR_LANG[APP_LANG]["BILLNEW"];
		document.getElementById("content_like").placeholder = ARR_LANG[APP_LANG]["LISTSEARCH"];
		document.getElementById("ID_LIST_REFRESH").value = ARR_LANG[APP_LANG]["LISTREFRESH"];
		document.getElementById("txt_filter").placeholder = ARR_LANG[APP_LANG]["LISTFILTER"];
		document.getElementById("ID_LIST_TOTAL").innerHTML = ARR_LANG[APP_LANG]["LISTTOTAL"];
	}


	if (LS_CUR_PAGE == "BILLLIST")
	{
		document.getElementById("ID_LIST_IBILLS").innerHTML = ARR_LANG[APP_LANG]["LISTIBILLS"];
	}

	if (LS_CUR_PAGE == "BILLLISTINACTIVE")
	{
		document.getElementById("ID_LIST_ABILLS").innerHTML = ARR_LANG[APP_LANG]["BILLLIST"];
	}
	
	if (LS_CUR_PAGE == "DASHBOARD")
	{
		document.getElementById("ID_HOME_LINK_BILLNEW").innerHTML = ARR_LANG[APP_LANG]["CREATENEWBILL"];
		document.getElementById("ID_HOME_LINK_BILLLIST").innerHTML = ARR_LANG[APP_LANG]["VIEWBILLLIST"];
	}

	if (LS_CUR_PAGE == "BILLNEW")
	{
		document.getElementById("ID_NEW_PARTICULARS_PRODUCT").innerHTML = ARR_LANG[APP_LANG]["NEWDTLPRODUCT"];
		document.getElementById("ID_NEW_PARTICULARS_AMOUNT").innerHTML = ARR_LANG[APP_LANG]["NEWDTLAMOUNT"];
		document.getElementById("ID_NEW_TXT_PL_PRODUCT").innerHTML = ARR_LANG[APP_LANG]["NEWPLPRODUCT"];
		document.getElementById("ID_NEW_TXT_PL_AMOUNT").innerHTML = ARR_LANG[APP_LANG]["NEWPLAMOUNT"];
		document.getElementById("ID_NEW_TXT_TOTAL").innerHTML = ARR_LANG[APP_LANG]["NEWTTOTAL"];
		document.getElementById("ID_NEW_TXT_TOTAL_AMOUNT").innerHTML = ARR_LANG[APP_LANG]["NEWATOTAL"];
		
		document.getElementById("ID_NEW_BILL_LINK_LIST").innerHTML = ARR_LANG[APP_LANG]["BILLLIST"];
		document.getElementById("ID_NEW_BILL_HEADING").innerHTML = ARR_LANG[APP_LANG]["BILLNEW"];
		document.getElementById("tdate").title = ARR_LANG[APP_LANG]["NEWDATE"];
		document.getElementById("txt_party1").placeholder = ARR_LANG[APP_LANG]["NEWPARTY1"];
		document.getElementById("txt_party2").placeholder = ARR_LANG[APP_LANG]["NEWPARTY2"];
		document.getElementById("txt_party3").placeholder = ARR_LANG[APP_LANG]["NEWPARTY3"];
		document.getElementById("balance_amt").placeholder = ARR_LANG[APP_LANG]["NEWBALAMT"];
		document.getElementById("txt_dtl").placeholder = ARR_LANG[APP_LANG]["NEWDETAILS"];

		document.getElementById("ID_NEW_PB_SAVE").innerHTML = ARR_LANG[APP_LANG]["NEWSAVE"];

		
		var x, i;
		x = document.getElementsByClassName("CSS_PRODUCT");
		for(i = 0; i < x.length; i++) 
		{ 
			x[i].placeholder = ARR_LANG[APP_LANG]["NEWDTLPRODUCT"];
		}  
		x = document.getElementsByClassName("CSS_AMOUNT");
		for(i = 0; i < x.length; i++) 
		{ 
			x[i].placeholder = ARR_LANG[APP_LANG]["NEWDTLAMOUNT"];
		}  

	}
*/ 	
}

fn_app_lang();






function fnSaveRate()
{
	var products = '';
	var pcounter = 0;
	var rows = document.querySelectorAll("tr.CSS_ROW")	
	for (var i = 0; i < rows.length; i++) 
	{
		var txt_product = rows[i].querySelector(".CSS_PRODUCT").value;
		var txt_rate = rows[i].querySelector(".CSS_RATE").value;

		txt_rate = +txt_rate;
		if (txt_rate > 0)
		{
			if (txt_product.length > 0)
			{
				products = myTrim(products) + 'AA'  + '##$##' + txt_product + '##$##' + txt_rate + '##$##' +  'AA' + '$$#$$';
				pcounter++;
			}
		}
	}	
	 products = myTrim(products);

	if (pcounter > 0)
	{
		null;
	}
	else
	{
		alert("Select atleast one product ");
		return;
	}

	//alert(products);
//	products = encodeURIComponent(products);
	//alert(products);


	var data = new FormData();
	data.append("action", "SAVE");
	data.append("rate_id", document.getElementById("m_rate_id").value);
	data.append("products", products);
	
	//alert("rate - " + document.getElementById("m_rate_id").value);
	
	let fetchRes = fetch("l_rate_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			alert("Success " + d);
			window.location.reload();
		}
		else
		{
			alert("Error" + d);
		}
		
	});
}




function fn_FilterTableRecords(filter_name, table_name) 
{
	var ARR_ROW = new Array();
	var input, filter, table, tr, td, i, txtValue;
	
	input = document.getElementById(filter_name);
	filter = input.value.toUpperCase();
	table = document.getElementById(table_name);
	tr = table.getElementsByTagName("tr");

	// INIT ARRAY WITH ZERO
	for (i = 0; i < tr.length; i++) 
	{
		ARR_ROW[i] = 0;
	}

	for (i = 0; i < tr.length; i++) 
	{
		std = tr[i].getElementsByTagName("td");
		for (j = 0; j < std.length; j++) 
		{
			td = std[j];
			if (td) 
			{
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) 
				{
					ARR_ROW[i] = 1;
				} 

//				txtValue = td.getAttribute('data-filter');
//				txtValue = td.getAttribute('title');
				txtValue = td.title;
				if (txtValue.toUpperCase().indexOf(filter) > -1) 
				{
					ARR_ROW[i] = 1;
				} 
			}
		}
	}

	// DISPLAY MATCHING TABLE ROW  ENTRIES 
	for (i = 1; i < tr.length; i++) 
	{
		if (ARR_ROW[i] == 1) 
		{
			tr[i].style.display = "";
		} 
		else 
		{
			tr[i].style.display = "none";
		}
	}
}


function RND2(value)
{
	return parseFloat(value).toFixed(2);
}





function sfn_minmax(inputElement) 
{
	const inputValue = parseFloat(inputElement.value);

	if (isNaN(inputValue)) 
		return 0; 
	else if (inputValue < parseFloat(inputElement.min) || inputValue > parseFloat(inputElement.max)) 
		if (inputValue < parseFloat(inputElement.min)) 
			return inputElement.min; 
		else
			return inputElement.max; 
	else 
		return inputValue; 
}


