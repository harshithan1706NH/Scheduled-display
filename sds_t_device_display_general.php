<?php
include('protect.php');


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
$HTML = "";

if ($result->num_rows > 0) {
  // output data of each row
  $HTML .= "<select name='device_id' id='device_id'>";
  while($row = $result->fetch_assoc())
   {
 
		  
		  
	$HTML .= "<option  value='"  . $row["d_id"] . "'>"  . $row["d_name"] . " </option>";
	 
		  
		  
  }
  $HTML .= "</select>";
}
?>


<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
	</head>
<body>
	<center>
	<h2 style="font-family:verdana" "font-size:30px">GENERAL UPLOAD</h2>
	</center>
	<div style="text-align: center;">
		  <input type="button" class="w3-btn w3-yellow" value="Add Device" onclick="location.href='sds_m_device.php'"> 
		   <input type="button" class="w3-btn w3-yellow" value="General Upload" onclick="location.href='sds_t_device_display_general.php'"> 
		   <input type="button" class="w3-btn w3-yellow"  value="Schedule Upload" onclick="location.href='sds_t_device_display_schedule.php'"> <br><br>
	</div>
<form action="sds_image_uploads.php" method="post" enctype="multipart/form-data" 
      style="width: 380px; margin: 100px auto; padding: 30px; 
             background-color: #f8f9fa; border: 1px solid #ccc; 
             border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);
             font-family: Verdana, sans-serif; text-align: center;">




<?php

	echo $HTML;
	
?>

  <h2 style="font-size: 22px; color: #333; margin-bottom: 25px;">
    Select Image to Upload
  </h2>

  <input type="file" name="fileToUpload" id="fileToUpload"
         style="display: block; margin: 0 auto 25px auto; 
                border: 1px solid #bbb; border-radius: 6px; 
                padding: 8px; width: 90%; font-size: 14px;">

  <input type="submit" value="Upload Image" name="submit"
         style="background-color: #007bff; color: white; 
                padding: 10px 20px; border: none; border-radius: 6px; 
                font-size: 15px; cursor: pointer; transition: 0.3s;">

  <p style="font-size: 12px; color: #555; margin-top: 15px;">
    Allowed: JPG, JPEG, PNG, GIF (max 500KB)
  </p>
</form>







</body>
</html>

