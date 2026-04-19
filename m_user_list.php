<?php
	ob_start();
	session_start();
	require_once('sowhall.php'); 
	require_once('xcode.php'); 
	require_once('url.php'); 	

	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $toplink; ?>
	<?php echo $toplink2; ?>
	<title>Master Records</title>	
</head>

<body onload="fn_user_view();">

<?php echo $navbar; ?>

<h2>User Master</h2> 

<button onclick="document.getElementById('Window_Modal_Add').style.display='block'" class="w3-button w3-green w3-hover-indigo noPrint">Add Record</button>
<!--<button onclick="document.getElementById('Window_Modal_Upload').style.display='block'" class="w3-button w3-teal w3-hover-indigo noPrint">Upload Records</button>-->

<br>
Password: <input type="text" id="txt_ucode_reset" name="txt_ucode_reset" value=""  onkeypress="return IsAlphaNumeric(event);" ondrop="return false;"  onpaste="return false;" placeholder="Reset Password(Min 4 chararcters)">


<div id="DIV_RECORDS"></div>

	

<!-- ADD - The Modal - START -->
<div id="Window_Modal_Add" class="w3-modal noPrint">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('Window_Modal_Add').style.display='none'"  class="w3-button w3-display-topright">&times;</span>
      <p>


		<div class="w3-card-4">
			<header class="w3-container w3-green">
				<h1>Add</h1>
			</header>

			<div class="w3-container">
				<form id="AddForm">
					<table class="table table-striped table-bordered table-hover">
						<tr><td><input placeholder="Code" type="text"  style="display:table-cell; width:100%" name="txt_ucode" id="txt_ucode" value="" ></td></tr>
						<tr><td><input placeholder="Name" type="text"  style="display:table-cell; width:100%" name="txt_fname" id="txt_fname" value="" ></td></tr>
						<tr><td><input placeholder="Mobile" type="number"  style="display:table-cell; width:100%" name="txt_mobile" id="txt_mobile" value="" ></td></tr>
						<tr><td><input placeholder="Details" type="text"  style="display:table-cell; width:100%" name="txt_dtl" id="txt_dtl" value="" ></td></tr>
						<tr><td><input placeholder="Rank" type="text"  style="display:table-cell; width:100%" name="txt_rank" id="txt_rank" value="" ></td></tr>
					</table>
				</form>
			</div>

			<footer class="w3-container w3-green">
				<p class="w3-rest w3-right-align">
					<button type="button" class="w3-button w3-indigo w3-hover-blue" onclick="fn_user_add('ADD');">Save</button>
				</p>
			</footer>
		</div> 		  



      </p>
    </div>
  </div>
</div>
<!-- ADD - The Modal - END -->


<!-- UPDATE - The Modal - START -->
<div id="Window_Modal_Update" class="w3-modal noPrint">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('Window_Modal_Update').style.display='none'"  class="w3-button w3-display-topright">&times;</span>
      <p>

		<div class="w3-card-4">
			<header class="w3-container w3-blue">
				<h1>Modify</h1>
			</header>

			<div class="w3-container">
				<form id="UpdateForm">
					<input type="hidden" name="txt_rid2" id="txt_rid2" value="">
					<table class="table table-striped table-bordered table-hover">
						<tr><td><input placeholder="Code" type="text"  style="display:table-cell; width:100%" name="txt_ucode2" id="txt_ucode2" value="" ></td></tr>
						<tr><td><input placeholder="Name" type="text"  style="display:table-cell; width:100%" name="txt_fname2" id="txt_fname2" value="" ></td></tr>
						<tr><td><input placeholder="Mobile" type="number"  style="display:table-cell; width:100%" name="txt_mobile2" id="txt_mobile2" value="" ></td></tr>
						<tr><td><input placeholder="Details" type="text"  style="display:table-cell; width:100%" name="txt_dtl2" id="txt_dtl2" value="" ></td></tr>
						<tr><td><input placeholder="Rank" type="text"  style="display:table-cell; width:100%" name="txt_rank2" id="txt_rank2" value="" ></td></tr>
					</table>
				</form>
			</div>

			<footer class="w3-container w3-blue">
				<p class="w3-rest w3-right-align">
					<button type="button" class="w3-button w3-indigo w3-hover-blue" onclick="fn_user_update('UPDATE');">Save</button>
				</p>
			</footer>
		</div> 		  

      </p>
    </div>
  </div>
</div>
<!-- UPDATE - The Modal - END -->

<!-- UPLOAD - The Modal - START -->
<div id="Window_Modal_Upload" class="w3-modal noPrint">
  <div class="w3-modal-content">
    <div class="w3-container w3-card w3-sand">
      <span onclick="document.getElementById('Window_Modal_Upload').style.display='none'"  class="w3-button w3-display-topright">&times;</span>
      <p>
			  
			  
		<div class="w3-card-4">
			<header class="w3-container w3-teal">
				<h1>Upload .csv File Data</h1>
			</header>

			<div class="w3-container">
				<br><br>
				<form id="UploadForm" enctype="multipart/form-data" data-form="DF_UploadForm">
					<table class="table table-hover table-borderless" style="width:100%;">
						<tr class="w3-padding-64">
							<td>Select File</td>
							<td>
								<input id="userfile" name="userfile" type="file"  form="UploadForm"  accept="text/csv" ><br>
								<input id="opt" name="opt" type="hidden" value="11" ><br>
							</td>
						</tr>
						<tr>
							<td><br><br></td>
							<td><br><br></td>
						</tr>
						<tr class="w3-padding-64">
							<td></td>
							<td><input type="button" class="w3-button w3-teal"  onclick="fn_upload_user();" value="Upload File"  form="UploadForm"><br></td>
						</tr>
					</table>
				</form>
				<br><br>
			</div>

			<footer class="w3-container w3-teal">
				<p class="w3-rest w3-right-align">
					<a href="m_upload_model.php?master=SKILL"  target="_blank" class="w3-button w3-orange" role="button">Download Model Excel Sheet</a>		
				</p>
			</footer>
		</div> 		  
		  
		  
      </p>
    </div>
  </div>
</div>
<!-- UPLOAD - The Modal - END -->



<!-- LINKS - The Modal - START -->
<div id="Window_Modal_Dept_Links" class="w3-modal noPrint">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('Window_Modal_Dept_Links').style.display='none'"  class="w3-button w3-display-topright">&times;</span>
      <p>

		<div class="w3-card-4">
			<header class="w3-container w3-blue">
				<h1 id="H1_USER_DEPT_LINKS">Links</h1>
			</header>

			<div class="w3-container">
				<form id="LinksForm">
					<input type="hidden" name="txt_rid3" id="txt_rid3" value="">
					<div id="DIV_USER_DEPT_LINKS"></div>
				</form>
			</div>

			<footer class="w3-container w3-blue">
				<p class="w3-rest w3-right-align">
					<button type="button" class="w3-button w3-indigo w3-hover-blue" onclick="fn_user_dept_link_save('UPDATE');">Save</button>
				</p>
			</footer>
		</div> 		  

      </p>
    </div>
  </div>
</div>
<!-- LINKS - The Modal - END -->


<!-- LINKS - The Modal - START -->
<div id="Window_Modal_Menu_Links" class="w3-modal noPrint">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('Window_Modal_Menu_Links').style.display='none'"  class="w3-button w3-display-topright">&times;</span>
      <p>

		<div class="w3-card-4">
			<header class="w3-container w3-blue">
				<h1 id="H1_USER_MENU_LINKS">Links</h1>
			</header>

			<div class="w3-container">
				<form id="LinksForm">
					<input type="hidden" name="txt_rid4" id="txt_rid4" value="">
					<div id="DIV_USER_MENU_LINKS"></div>
				</form>
			</div>

			<footer class="w3-container w3-blue">
				<p class="w3-rest w3-right-align">
					<button type="button" class="w3-button w3-indigo w3-hover-blue" onclick="fn_user_menu_link_save('UPDATE');">Save</button>
				</p>
			</footer>
		</div> 		  

      </p>
    </div>
  </div>
</div>
<!-- LINKS - The Modal - END -->


	

<?php echo $footer2; ?>
			
<?php echo $bottomlink; ?>
<?php echo $bottomlink2; ?>


<script type="text/javascript"> 


function fn_user_add() 
{
	var data = new FormData();
	data.append("opt", 1);
	data.append("ucode", document.getElementById("txt_ucode").value);
	data.append("fname", document.getElementById("txt_fname").value);
	data.append("mobile", document.getElementById("txt_mobile").value);
	data.append("dtl", document.getElementById("txt_dtl").value);
	data.append("rank", document.getElementById("txt_rank").value);
	
	let fetchRes = fetch("m_user_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{

		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}

function fn_user_view() 
{
	var data = new FormData();
	data.append("opt", 7);
	let fetchRes = fetch("m_user_db.php", {method: 'POST',body: data});
	fetchRes.then(res=>res.json()).then(d=>{
		document.getElementById("DIV_RECORDS").innerHTML=d;
	});
}

function fn_user_edit(recid)
{
	document.getElementById('txt_rid2').value = recid;
	document.getElementById('txt_ucode2').value = document.getElementById('txt_ucode_' + recid).value;
	document.getElementById('txt_fname2').value = document.getElementById('txt_fname_' + recid).value;
	document.getElementById('txt_mobile2').value = document.getElementById('txt_mobile_' + recid).value;
	document.getElementById('txt_dtl2').value = document.getElementById('txt_dtl_' + recid).value;
	document.getElementById('txt_rank2').value = document.getElementById('txt_rank_' + recid).value;
	document.getElementById('Window_Modal_Update').style.display='block';
}


function fn_user_update() 
{
	var data = new FormData();
	data.append("opt", 2);
	data.append("rid", document.getElementById("txt_rid2").value);
	data.append("ucode", document.getElementById("txt_ucode2").value);
	data.append("fname", document.getElementById("txt_fname2").value);
	data.append("mobile", document.getElementById("txt_mobile2").value);
	data.append("dtl", document.getElementById("txt_dtl2").value);
	data.append("rank", document.getElementById("txt_rank2").value);
	
	let fetchRes = fetch("m_user_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}
		
function fn_user_mark(arg_id, arg_field, arg_flag)
{
	var data = new FormData();
	data.append("opt", 3);
	data.append("rid", arg_id);
	data.append("field", arg_field);
	data.append("flag", arg_flag);
	
	let fetchRes = fetch("m_user_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}


function fn_user_delete(arg_id, arg_tstamp)
{
	if (confirm("Sure to Delete!") == true) 
		null;		
	else 
		return;
	
	var data = new FormData();
	data.append("opt", 9);
	data.append("rid", arg_id);
	data.append("tstamp", arg_tstamp);
	
	let fetchRes = fetch("m_user_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}

function fn_upload_user()
{
	var formData = new FormData(document.querySelector('form[data-form="DF_UploadForm"]')); 
	let fetchRes = fetch("m_user_db.php", {method: 'POST',body: formData});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
	});
}


function fn_Reset_Password(arg_id, arg_tstamp)
{
	var arg_ucode = document.getElementById('txt_ucode_reset').value;

	var data = new FormData();
	data.append("opt", 6);
	data.append("rid", arg_id);
	data.append("tstamp", arg_tstamp);
	data.append("ucode", arg_ucode);

	let fetchRes = fetch("m_user_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			alert("Password reset as " + result[3]);
		else
			alert("Error" + d);
		
	});
}
		

function fn_user_dept_links_edit(recid)
{
	var data = new FormData();
	data.append("opt", 99);
	data.append("rid", recid);
	let fetchRes = fetch("m_user_sdept_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			document.getElementById('txt_rid3').value = recid;
			document.getElementById('H1_USER_DEPT_LINKS').innerHTML = nl2br(result[1]);
			document.getElementById('DIV_USER_DEPT_LINKS').innerHTML = nl2br(result[2]);
		}
		else
			alert("Error" + d);
		
	});
	document.getElementById('Window_Modal_Dept_Links').style.display='block';
}



function fn_user_dept_link_save() 
{
	var pcounter = 0;
	var records = '';
	var QSA_SubDepartments = document.querySelectorAll(".CL_LINK_SUBDEPARTMENT");
	QSA_SubDepartments.forEach(function(element) 
	{
		if (element.checked == true)
		{
			var x1 = element.value;
			records = myTrim(records) + 'AA'  + '##$##' + x1 + '##$##' + 'AA' + '##$##' + 'AA' + '$$#$$';
			pcounter++;
		}
	});
	
	var data = new FormData();
	data.append("opt", 2);
	data.append("rid", document.getElementById("txt_rid3").value);
	data.append("records", records);

	let fetchRes = fetch("m_user_sdept_save.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			//window.location.reload();
			alert("Saved successfully");
			document.getElementById('Window_Modal_Dept_Links').style.display='none';
		}
		else
			alert("Error" + d);
		
	});
}



function fn_select_department(deptid)
{
	var QSA_SubDepartments = document.querySelectorAll(".CB" + deptid);

	if (document.getElementById("CB_DEPARTMENT" + deptid).checked == true)
	{
		QSA_SubDepartments.forEach(function(element) 
		{
			element.checked = true;
		});
	}
	else
	{
		QSA_SubDepartments.forEach(function(element) 
		{
			element.checked = false;
		});
	}
}












function fn_user_menu_links_edit(recid)
{
	var data = new FormData();
	data.append("opt", 99);
	data.append("rid", recid);
	let fetchRes = fetch("m_user_menu_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			document.getElementById('txt_rid4').value = recid;
			document.getElementById('H1_USER_MENU_LINKS').innerHTML = nl2br(result[1]);
			document.getElementById('DIV_USER_MENU_LINKS').innerHTML = nl2br(result[2]);
		}
		else
			alert("Error" + d);
		
	});
	document.getElementById('Window_Modal_Menu_Links').style.display='block';
}



function fn_user_menu_link_save() 
{
	var pcounter = 0;
	var records = '';
	var QSA_Modules = document.querySelectorAll(".CL_LINK_MENU");
	QSA_Modules.forEach(function(element) 
	{
		if (element.checked == true)
		{
			var x1 = element.value;
			records = myTrim(records) + 'AA'  + '##$##' + x1 + '##$##' + 'AA' + '##$##' + 'AA' + '$$#$$';
			pcounter++;
		}
	});
	
	var data = new FormData();
	data.append("opt", 2);
	data.append("rid", document.getElementById("txt_rid4").value);
	data.append("records", records);

	let fetchRes = fetch("m_user_menu_save.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
		{
			//window.location.reload();
			alert("Saved successfully");
			document.getElementById('Window_Modal_Menu_Links').style.display='none';
		}
		else
			alert("Error" + d);
		
	});
}



function fn_select_group(groupid)
{
	var QSA_Modules = document.querySelectorAll(".CB" + groupid);

	if (document.getElementById("CB_GROUP" + groupid).checked == true)
	{
		QSA_Modules.forEach(function(element) 
		{
			element.checked = true;
		});
	}
	else
	{
		QSA_Modules.forEach(function(element) 
		{
			element.checked = false;
		});
	}
}





</script>



</body>
</html>
