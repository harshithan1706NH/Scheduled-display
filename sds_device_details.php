<?php
include('protect.php');

$device_name = "Diskplay.Live";
$url = "";

//$device_id = $_GET['device_id'];
$device_id = isset($_GET['device_id'])?$_GET['device_id']:'0';        

if ($device_id > 0)
{
	$servername = "localhost";
	$username = "u443307521_diskplay_us";
	$password = "DiskPlay.Live12#July#2024Code";
	$dbname = "u443307521_diskplay_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM sds_m_device WHERE d_id= " . $device_id . " ";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{
	  // output data of each row
	 
	  while($row = $result->fetch_assoc())
	   {
		   $device_name = $row["d_name"];
		}
	  
	  
	}
	
	  $HTML="";
	$sql = "SELECT id, url, start_time, end_time
				FROM sds_t_device_display_schedule 
					WHERE deviceid= " . $device_id . " 
						ORDER BY start_time,id";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{
	  // output data of each row
	 
	  while($row = $result->fetch_assoc())
	   {
		   $url = $row["url"];
		   
		   $HTML.= "<br><button  class='w3-btn w3-red' onclick='fn_delete_image(1, " . $row["id"] . ");'>Delete</button>";
		   $HTML.= '<br>From : ' . $row["start_time"] . ' <br>To : '. $row["end_time"] ;
		   $HTML.='<br><img src="' . $url . '"; style="width:80%; height:auto;padding:20px" />';
		
		   
		}
	}
	
	
	
	
	
	$sql = "SELECT id, url FROM sds_t_device_display WHERE deviceid= " . $device_id . " ";
	unset($result);
	$result = $conn->query($sql);

	if ($result->num_rows > 0) 
	{
	  // output data of each row
	 
	  while($row = $result->fetch_assoc())
	   {
		   $HTML.= "<br><button  class='w3-btn w3-red' onclick='fn_delete_image(2, " . $row["id"] . ");'>Delete</button>";
		   $url = $row["url"];
		   $HTML.='<br><img src="' . $url . '"; style="width:80%; height:auto;padding:20px" />';
		   
		   
		}
	}
	


	$conn->close();
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Diskplay</title>
</head>

<body>
<div>
	
	
	
	
	
	
	<?php echo $HTML ; ?>
	
	
	
	
</div>

<script>

function fn_delete_image(tableid, id)
{
	alert('id' + id);
	var data = new FormData();
	
	data.append("option", 9);
	data.append("id", id);
	data.append("tableid",tableid);
	
	
	let fetchRes = fetch("sds_t_delete_image.php", {method: 'POST',body: data});				
	fetchRes.then(res=>res.text()).then(d=>{

		alert(d);
		location.reload();
		
	});
}



</script>


</body>
</html>
