<?php
	ob_start();
	session_start();

	require_once('sowhall.php'); 
	require_once('xcode.php'); 
	require_once('url.php'); 	
	
	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];

	if ($ulogid > 0) null; else $ulogid = 0;
	if ($global_lid > 0) null; else $global_lid = 0;


	$action = isset($_POST['action']) ? $_POST['action'] : 'NULL';
	$rate_id = isset($_POST['rate_id']) ? $_POST['rate_id'] : '0';
	$products = isset($_POST['products']) ? $_POST['products'] : 'NULL';

	if (($action == "NULL") OR ( $rate_id == "NULL") OR ( $products == "NULL"))
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid Entry"));
		exit;
	}
	if (!($action == "SAVE"))
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid Entry"));
		exit;
	}

	//$name = mysql_real_escape_string($name);     //$packing = mysql_real_escape_string($packing);


	date_default_timezone_set("Asia/Kolkata");
	$curr_timestamp = date("Y-m-d H:i:s");
	$MSG = "";
	
	$sql2 = "UPDATE l_supply_rate SET rate = ? WHERE supplyid = ? AND rateid = ?";
	if ($stmt2 = $mysqli2->prepare($sql2))
	{
		$stmt2->bind_param("ddd", $rate, $supplyid, $rate_id);
		$counter = 0;
		$ProductArray = explode('$$#$$', $products);
		foreach($ProductArray as $Product) 
		{
			$ProductValues = explode('##$##', $Product);
			if ( ! isset($ProductValues[1])) { $ProductValues[1] = 0;}
			if ( ! isset($ProductValues[2])) { $ProductValues[2] = 0;}

			$product = $ProductValues[1];
			$product = $product + 0;
			$supplyid  = $product + 0;

			if ($product > 0)
			{
				$rate = $ProductValues[2];
				$rate = $rate + 0;
				if ($rate > 0)
				{
					$stmt2->execute();
					$counter++;
				}
			}
			else
			{
				$MSG .= $product . " | " ;
			}
		}
		$stmt2->close();

		if ($counter > 0)
		{
			echo json_encode(array("SUCCESS", "TRUE", "-", $counter . " entries updated successfully"));
			exit;
		}
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - No valid entries found - " . $MSG . " - " . $counter));
			exit;
		}
		
	} 
	else
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Process failed 21 " . $mysqli2->error));
		exit;
	}
	unset($result3);
	unset($result2);

	echo json_encode(array("ERROR", "FALSE", "ERROR - END"));
	exit;
?>

