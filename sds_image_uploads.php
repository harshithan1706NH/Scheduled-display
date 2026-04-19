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






$target_dir = __DIR__ . "/sds_image_uploads/"; 

// Create folder automatically if not exists
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);


$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


$new_server_file = "sds_image_uploads/img_" . date("Ymdhis") . round(microtime(true) * 1000) . "." . $imageFileType;

// Check if form is submitted
if (isset($_POST["submit"])) 
{

    // Check if file is a real image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) 
    {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } 
    else 
    {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($new_server_file)) 
    {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }

    // Check file size (optional)
    if ($_FILES["fileToUpload"]["size"] > 5000000) 
    {
        echo "Sorry, your file is too large.<br>";
        $uploadOk = 0;
    }

    // Allow certain formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") 
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }

    // Upload if everything is ok
    if ($uploadOk == 0) 
    {
        echo "Sorry, your file was not uploaded.<br>";
    } 
    else 
    {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_server_file)) 
        {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.<br>";
            echo "<br><img src='" . $new_server_file . "' style='width:250px; height: auto;'>";
            
            
            
            
						
			$servername = "localhost";
			$username = "u443307521_diskplay_us";
			$password = "DiskPlay.Live12#July#2024Code";
			$dbname = "u443307521_diskplay_db";



			$device_id = $_POST['device_id'];



			if($device_id > 0)
			{
				echo "<br>' Please wait..'";
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
				  die("Connection failed: " . $conn->connect_error);
				}

				$sql = "INSERT INTO sds_t_device_display (deviceid, url) VALUES (" . $device_id . ", '" . $new_server_file . "')";

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
						
            
            
        } 
        else 
        {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
?>

