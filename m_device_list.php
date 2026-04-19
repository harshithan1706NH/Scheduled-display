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

<body onload="fn_device_view();">

<?php echo $navbar; ?>

<h2>Device Master</h2> 

<button onclick="document.getElementById('Window_Modal_Add').style.display='block'" class="w3-button w3-green w3-hover-indigo noPrint">Add Record</button>
<input type="text" id="txt_filter" onkeyup="fn_FilterTableRecords('txt_filter', 'TABLE_OUTPUT') " placeholder="Search.."  class="noPrint">

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
						<tr><td><input placeholder="Details" type="text"  style="display:table-cell; width:100%" name="txt_dtl" id="txt_dtl" value="" ></td></tr>
						<tr><td><input placeholder="Rank" type="text"  style="display:table-cell; width:100%" name="txt_rank" id="txt_rank" value="" ></td></tr>
					</table>
				</form>
			</div>

			<footer class="w3-container w3-green">
				<p class="w3-rest w3-right-align">
					<button type="button" class="w3-button w3-indigo w3-hover-blue" onclick="fn_device_add('ADD');">Save</button>
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
						<tr><td><input placeholder="Details" type="text"  style="display:table-cell; width:100%" name="txt_dtl2" id="txt_dtl2" value="" ></td></tr>
						<tr><td><input placeholder="Rank" type="text"  style="display:table-cell; width:100%" name="txt_rank2" id="txt_rank2" value="" ></td></tr>
					</table>
				</form>
			</div>

			<footer class="w3-container w3-blue">
				<p class="w3-rest w3-right-align">
					<button type="button" class="w3-button w3-indigo w3-hover-blue" onclick="fn_device_update('UPDATE');">Save</button>
				</p>
			</footer>
		</div> 		  

      </p>
    </div>
  </div>
</div>
<!-- UPDATE - The Modal - END -->


<?php echo $footer2; ?>
			
<?php echo $bottomlink; ?>
<?php echo $bottomlink2; ?>


<script type="text/javascript"> 


function fn_device_add() 
{
	var data = new FormData();
	data.append("opt", 1);
	data.append("ucode", document.getElementById("txt_ucode").value);
	data.append("fname", document.getElementById("txt_fname").value);
	data.append("dtl", document.getElementById("txt_dtl").value);
	data.append("rank", document.getElementById("txt_rank").value);
	
	let fetchRes = fetch("m_device_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{

		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}

function fn_device_view() 
{
	var data = new FormData();
	data.append("opt", 7);
	let fetchRes = fetch("m_device_db.php", {method: 'POST',body: data});
	fetchRes.then(res=>res.json()).then(d=>{
		document.getElementById("DIV_RECORDS").innerHTML=d;
	});
}

function fn_device_edit(recid)
{
	document.getElementById('txt_rid2').value = recid;
	document.getElementById('txt_ucode2').value = document.getElementById('txt_ucode_' + recid).value;
	document.getElementById('txt_fname2').value = document.getElementById('txt_fname_' + recid).value;
	document.getElementById('txt_dtl2').value = document.getElementById('txt_dtl_' + recid).value;
	document.getElementById('txt_rank2').value = document.getElementById('txt_rank_' + recid).value;
	document.getElementById('Window_Modal_Update').style.display='block';
}


function fn_device_update() 
{
	var data = new FormData();
	data.append("opt", 2);
	data.append("rid", document.getElementById("txt_rid2").value);
	data.append("ucode", document.getElementById("txt_ucode2").value);
	data.append("fname", document.getElementById("txt_fname2").value);
	data.append("dtl", document.getElementById("txt_dtl2").value);
	data.append("rank", document.getElementById("txt_rank2").value);
	
	let fetchRes = fetch("m_device_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}
		
function fn_device_mark(arg_id, arg_field, arg_flag)
{
	var data = new FormData();
	data.append("opt", 3);
	data.append("rid", arg_id);
	data.append("field", arg_field);
	data.append("flag", arg_flag);
	
	let fetchRes = fetch("m_device_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}


function fn_device_delete(arg_id, arg_tstamp)
{
	var data = new FormData();
	data.append("opt", 9);
	data.append("rid", arg_id);
	data.append("tstamp", arg_tstamp);
	
	let fetchRes = fetch("m_device_db.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
		
		var result = d;
		if (result[0] == "SUCCESS")
			window.location.reload();
		else
			alert("Error" + d);
		
	});
}


</script>



</body>
</html>
