<?php
	ob_start();
	session_start();
	require_once('sowhall.php');  
	require_once('xcode.php'); 
	require_once('url.php'); 	

	$ulogid = $GLOBALS['ulogid']; 
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];

    $factoryid = isset($_POST['factoryid'])?$_POST['factoryid']:'0';        
    $subdepartmentid = isset($_POST['subdepartmentid'])?$_POST['subdepartmentid']:'0';        
	$tdate = isset($_POST['tdate']) ? $_POST['tdate'] : 'NULL';
	$records = isset($_POST['records']) ? $_POST['records'] : 'NULL';
	$action = isset($_POST['action']) ? $_POST['action'] : 'NULL';
    $shiftid = isset($_POST['shiftid'])?$_POST['shiftid']:'0';        

	if (($action == "NULL") OR ( $records == "NULL"))
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid Entry A"));
		exit;
	}
	if (!($action == "SAVE"))
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid Entry B"));
		exit;
	}

	if (($subdepartmentid > 0))
		null;
	else
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid Entry C"));
		exit;
	}		
	
	
	
	
    $subdepartmentid2 = 0;        
	if ($result1 = $mysqli->query("SELECT id FROM m_subdepartment  WHERE flag_addon = 1 AND id = '" . $subdepartmentid . "' AND  lid = '" . $global_lid . "'"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$subdepartmentid2 = $obj1->id;
			}
			unset($result1);
		} 
	}
    if ($subdepartmentid2 == 0)
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid sub department"));
		exit;
	}


    $shiftidx = 0;        
	if ($result1 = $mysqli->query("SELECT id, fname FROM m_shift  WHERE id = '" . $shiftid . "' AND  lid = '" . $global_lid . "'"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$shiftidx = $obj1->id;
				$shift_name = $obj1->fname;
			}
			unset($result1);
		} 
	}
    if ($shiftidx == 0)
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid shift"));
		exit;
	}



				$unitid = 0;
				$sectionid = 0;


	if ($result1 = $mysqli->query("SELECT id, ucode, fname FROM m_addon  WHERE lid = '" . $global_lid . "'"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_ADDON[$obj1->id] =  $obj1->fname;
				$ARR_ADDON_CODE[$obj1->id] =  $obj1->ucode;


				$ARR_ADDON_RATE[$obj1->id] = 1;
				$ARR_MASTER_RATE[$obj1->id] = 1;
				$ARR_MASTER_FLAG[$obj1->id] =  1;

				$ARR_ADDON_FLAG[$obj1->id] =  1;


			}
			unset($result1);
		} 
	}



	$sql_check = "SELECT employeeid, addonid FROM t_daily_addon WHERE  subdepartmentid = '" . $subdepartmentid  . "' AND tdate = '" . $tdate . "'  AND lid = '" . $global_lid . "'";
	if ($result1 = $mysqli->query($sql_check))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_EMPLOYEE_CHECK[$obj1->employeeid][$obj1->addonid] = 1;

			}
			$result1->close();
		} 
	} 


	if ($result1 = $mysqli->query("SELECT * FROM m_employee"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_EMPLOYEE[$obj1->id] = $obj1->fname;
				$ARR_EMPLOYEE_FLAG[$obj1->id] = 0;
			}
			$result1->close();
		} 
	} 



//	$sql_delete = "DELETE FROM t_daily_addon WHERE tdate = ? AND shiftid = ? AND subdepartmentid = ? AND productid = ? AND machineid = ? AND addonid = ? AND employeeid = ? AND lid = ?";
	$sql_delete = "DELETE FROM t_daily_addon WHERE tdate = ? AND shiftid = ? AND subdepartmentid = ? AND addonid = ? AND employeeid = ? AND lid = ?";
    if ($stmt_delete = $mysqli->prepare($sql_delete))
    {
		$stmt_delete->bind_param("sddddd", $tdate, $shiftid, $subdepartmentid, $addonid, $employeeid, $global_lid); 
	}
	else
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid Data C"));
		exit;
	}		





 


	$periodidx = 0;
	unset($result1);
	$sqlx1 = "SELECT * FROM t_wagesperiod WHERE  lid = '" . $global_lid . "'  AND  date_from <= '" . $tdate . "'  AND  date_to >= '" . $tdate . "'   AND flag_locked = '0' ORDER BY id ASC LIMIT 1 ";
	if ($result1 = $mysqli1->query($sqlx1))
	{
		while ($obj1 = $result1->fetch_object())
		{
			$periodidx = $obj1->id;
			$factoryid = $obj1->factoryid;
			$date_from = $obj1->date_from;
			$date_to = $obj1->date_to;
		}
		$result1->close();
	}
	unset($result1);







		

	$factoryid = 1;

	$sql = "INSERT INTO t_daily_addon (factoryid, tdate, subdepartmentid, shiftid, addonid, employeeid, nou, wages, unitid, wages_nou, amt, dtl, periodid, lid, ulogid)
			VALUES (?, ?, ?,  ?, ?, ?,  ?, ?, ?,  ?, ?, ?,  ?, ?, ?)
			ON DUPLICATE KEY UPDATE	nou = ?, wages = ?, unitid = ?, wages_nou = ?, amt = ?, dtl = ?";

	
    if ($stmt2 = $mysqli2->prepare($sql))
    {
		$stmt2->bind_param("dsdddddddddsdddddddds", $factoryid, $tdate, $subdepartmentid, $shiftid, $addonid, $employeeid, $nou, $wages, $unitid, $wages_nou, $amt, $dtl, $periodid, $global_lid, $ulogid, $nou, $wages, $unitid, $wages_nou, $amt, $dtl); 
		
		$counter = 0;
		$ERR_TEXT = "";
		
		$RecordsArray = explode('$$#$$', $records);
		foreach($RecordsArray as $Record) 
		{
			$RecordValues = explode('##$##', $Record);
			if ( ! isset($RecordValues[1])) { $RecordValues[1] = 0;}
			if ( ! isset($RecordValues[2])) { $RecordValues[2] = 0;}

			if ( ! isset($RecordValues[3])) { $RecordValues[3] = 0;}
			if ( ! isset($RecordValues[4])) { $RecordValues[4] = 0;}
			if ( ! isset($RecordValues[5])) { $RecordValues[5] = 0;}

			if ( ! isset($RecordValues[6])) { $RecordValues[6] = 0;}
			if ( ! isset($RecordValues[7])) { $RecordValues[7] = 0;}

			$employeeid = $RecordValues[1];
			$nou = $RecordValues[2];

			$productid = $RecordValues[3];
			$machineid = $RecordValues[4];
			$addonid = $RecordValues[5];

			$enou = $RecordValues[6];
			$periodid = $RecordValues[7];
			
			if ($periodid == 0)
				$periodid = $periodidx;

			$employeeid = $employeeid + 0;
			$nou = $nou + 0;

			$addonid = $addonid + 0;

			$enou = $enou + 0;
			$periodid = $periodid + 0;

			if (($employeeid > 0) && ($nou > 0)  && ($ARR_EMPLOYEE_FLAG[$employeeid] >= 0))
			{
				$wages_nou = 1;
				$wages = 0;
				
				if ($ARR_ADDON_RATE[$addonid] > 0)
					$wages = $ARR_ADDON_RATE[$addonid] + 0;

				$ADDON_RATE = $wages;

				//$wagesxx = $wages;
				$wagesxx = $ADDON_RATE + 0;

				if ($ARR_ADDON_EMPLOYEE_RATE[$employeeid][$addonid] > 0)
					$wages = $ARR_ADDON_EMPLOYEE_RATE[$employeeid][$addonid] + 0;

				$EMPLOYEE_RATE = $wages;


				$wages = $wages + 0;
				$wages_nou = $wages_nou + 0;
				
				if ($wages > 0)
				{
					$amt = ($nou * $wages) / ($wages_nou);

					$amt = $amt + 0;

					$dtl = "-";

					if ($stmt2->execute())
						$counter++;
					else
						$ERR_TEXT .= " - " . $stmt2->error;
				}
				else
				{
					$ERR_TEXT .= "[Wages rate not found - " . $ARR_EMPLOYEE[$employeeid] . " - " . $employeeid . " - Product : "  . $ARR_PRODUCT[$productid] . " - " . $productid . " - Machine : " . $ARR_MACHINE[$machineid] . " - " . $machineid . " - Addon : " . $ARR_ADDON[$addonid] . " - " . $addonid . " - " . $wages .  " - " . $ADDON_RATE .  " - " . $EMPLOYEE_RATE . "]";
				}
			}
			else
			{
//				if (($employeeid > 0) && ($ARR_EMPLOYEE_CHECK[$employeeid] > 0))
				if (($employeeid > 0) && ($ARR_EMPLOYEE_CHECK[$employeeid][$addonid] > 0))
					if ($stmt_delete->execute())
						$counter++;
					else
						$ERR_TEXT .= " - " . $stmt_delete->error;
				else
					$ERR_TEXT .= " - " . $employeeid . " - " . $nou . " - " . $ARR_EMPLOYEE[$employeeid];
			}
			
		}
				
		
		if ($counter > 0)
		{
			echo json_encode(array("SUCCESS", "TRUE", "OK", $ERR_TEXT, $sql_check));
			exit;
		}
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 11 " . $ERR_TEXT));
			exit;
		}
	}
    else
    {
		echo json_encode(array("ERROR", "FALSE", "Error - 10" . $mysqli2->error));
		exit;
    }


	echo json_encode(array("ERROR", "FALSE", "Error - 99"));
?>
