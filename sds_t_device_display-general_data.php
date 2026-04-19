<?php
include('protect.php');
$servername = "localhost";
$username = "u443307521_diskplay_us";
$password = "DiskPlay.Live12#July#2024Code";
$dbname = "u443307521_diskplay_db";

	



$option = $_POST['option'];



if($option == 1)
{
	$url = $_POST['url'];
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO sds_t_device_display_general (url) VALUES ('" . $url. "')";

	if ($conn->query($sql) === TRUE)
	{
		  echo "New record created successfully";
	} 
	else
	{
		  echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
	

}
else if($option == 2)
{
	$id = $_POST['id'];
	$url = $_POST['url'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	// sql to delete a record
	$sql = "UPDATE sds_t_device_display_general SET url = '" . $url . "' WHERE d_id=" . $id . "";

	if ($conn->query($sql) === TRUE)
	{
		echo "Record modified successfully";
	} 
	else 
	{
		echo "Error modifying record: " . $conn->error;
	}

	$conn->close();
	
	
	
	
	
}
else if($option == 9)
{
	$id = $_POST['id'];
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}

	// sql to delete a record
	$sql = "DELETE FROM sds_t_device_display_general WHERE d_id=" . $id . "";

	if ($conn->query($sql) === TRUE)
	{
		echo "Record deleted successfully";
	} 
	else 
	{
		echo "Error deleting record: " . $conn->error;
	}

	$conn->close();
	
	
	
	
	
}
else
{
	null;
}

?>
