<?php
	include('protect.php');
?>




<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
</head>
<body>
<center>
<h2 "font-family:verdana" "font-size:30px">DEVICE</h2>
</center>

<form action="/action_page.php">
	
	<div style="text-align: center;">
		  <input type="button" class="w3-btn w3-yellow" value="Add Device" onclick="location.href='sds_m_device.php'"> 
		   <input type="button" class="w3-btn w3-yellow" value="General Upload" onclick="location.href='sds_t_device_display_general.php'"> 
		   <input type="button" class="w3-btn w3-yellow"  value="Schedule Upload" onclick="location.href='sds_t_device_display_schedule.php'"> <br><br>
	</div>
	
  <label for="fname">NAME:</label><br>
  <input type="text" id="txt_fname" name="fname" value=""><br>
  
  <input type="button"  class="w3-btn w3-green" value="ADD" onclick=fn_device_add();>
</form> 









<?php
$servername = "localhost";
$username = "u443307521_diskplay_us";
$password = "DiskPlay.Live12#July#2024Code";
$dbname = "u443307521_diskplay_db";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM sds_m_device";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
  // output data of each row
  echo "<table class='w3-table-all'>";
  while($row = $result->fetch_assoc())
   {
  
	echo "<tr class='TR_ROW'><td><input class='CL_NAME' type='text' value='"  . $row["d_name"] . "'> [ '"  . $row["d_id"] . "'] </td>".
	 " <td>- SYS1: " .  $row["d_time1"] . "</td>".
	 
	 "<td><a href='sds_device_details.php?device_id=" . $row["d_id"] . "' target='_blank' class='w3-btn w3-pink'>Details</a></td>" .
	 "<td><a href='index.html?device_id=" . $row["d_id"] . "' target='_blank' class='w3-btn w3-green'>Link</a></td>" .
	  "<td><button  class='w3-btn w3-blue' onclick='fn_device_modify(this, " .  $row["d_id"] . ");'>Modify</button></td>" .
	  "<td><button  class='w3-btn w3-red' onclick='fn_device_delete(" . $row["d_id"] . ");'>Delete</button></td>" .  "</tr>";
		  
		  
  }
  echo "</table>";
}



else
{
  echo "0 results";
}
$conn->close();
?>







<script>
function fn_device_add() 
{
	alert(`HI`);
	var data = new FormData();
	
	data.append("option", 1);
	data.append("fname", document.getElementById("txt_fname").value);
	
	
	let fetchRes = fetch("sds_m_device_data.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.text()).then(d=>{

		alert(d);
		location.reload();
		
	});
}

function fn_device_delete(id)
{
	alert(`HI`);
	var data = new FormData();
	
	data.append("option", 9);
	data.append("id", id);
	
	
	let fetchRes = fetch("sds_m_device_data.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.text()).then(d=>{

		alert(d);
		location.reload();
		
	});
}

function fn_device_modify(btn, id)
{
	//alert(btn.closest('.TR_ROW').querySelector('.CL_NAME').value);
	
	alert(`HI`);
	var data = new FormData();
	var fname = btn.closest('.TR_ROW').querySelector('.CL_NAME').value;
	
	data.append("option", 2);
	data.append("id", id);
	data.append("fname", fname);
	
	
	let fetchRes = fetch("sds_m_device_data.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.text()).then(d=>{

		alert(d);
		location.reload();
		
	});
	
}
	
	
</script>


</body>
</html>

