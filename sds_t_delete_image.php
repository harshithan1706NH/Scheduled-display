<?php
include('protect.php');
$servername = "localhost";
$username = "u443307521_diskplay_us";
$password = "DiskPlay.Live12#July#2024Code";
$dbname = "u443307521_diskplay_db";



$option = $_POST['option'];
$tableid = $_POST['tableid'];
$id = $_POST['id'];




if($option == 9)
{
	
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	}
	
	
	
	// sql to delete a record
	
	
	
	
	
	if ($tableid == 1)
	{
		$sql = "DELETE FROM sds_t_device_display_schedule WHERE id=" . $id . "";
		$sql2 = "SELECT url FROM sds_t_device_display_schedule WHERE id= " . $id . " ";
		
	}
	else if($tableid==2)
	{
		$sql = "DELETE FROM sds_t_device_display WHERE id=" . $id . "";
		$sql2 = "SELECT url FROM sds_t_device_display WHERE id= " . $id . " ";
	}
	else
	{
		echo "Error table name: ";
		null;
	}
	
	echo $sql . "<br>" . $sql2;
	
	
	$result2 = $conn->query($sql2);

	if ($result2->num_rows > 0) 
	{
	  // output data of each row
	 
	  while($row2 = $result2->fetch_assoc())
	   {
		   $url = $row2["url"];
		   unlink($url);
		   
		}
		
	}
	
	
	
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
