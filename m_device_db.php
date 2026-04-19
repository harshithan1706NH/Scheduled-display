<?php
	ob_start();
	session_start();
	require_once('sowhall.php'); 
	require_once('xcode.php'); 
	require_once('url.php'); 	

	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];


    $opt = isset($_POST['opt'])?$_POST['opt']:'0';        
    
    if ($opt == 1) /* ADD */
    {
		$ucode = isset($_POST['ucode'])?$_POST['ucode']:'NULL';        
		$fname = isset($_POST['fname'])?$_POST['fname']:'NULL';        
		$dtl = isset($_POST['dtl'])?$_POST['dtl']:'NULL';        
		$nrank1 = isset($_POST['rank'])?$_POST['rank']:'0';        


		if ($stmt2 = $mysqli->prepare("INSERT into m_device (ucode, fname, dtl, nrank1, ulogid, lid) VALUES (?, ?, ?, ?, ?, ?)"))
		{
				$rcode = $fname;
				$stmt2->bind_param("sssidd", $ucode, $fname, $dtl, $nrank1, $ulogid, $global_lid); 
				if ($stmt2->execute())
				{
					$stmt2->close();
					
					echo json_encode(array("SUCCESS", "TRUE", "OK", "Added Successfully"));
					exit;
				}
				else
				{
					$stmt2->close();
//					echo json_encode(array("ERROR", "FALSE", "Error - 7" . $mysqli->error));
					echo json_encode(array("ERROR", "Duplicate, Already exists"));
					exit;
				}
		}
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10".  $mysqli->error));
			exit;
		}
	}
    else if ($opt == 2) /* UPDATE */
    {
		$id = isset($_POST['rid'])?$_POST['rid']:'NULL';        
		$ucode = isset($_POST['ucode'])?$_POST['ucode']:'NULL';        
		$fname = isset($_POST['fname'])?$_POST['fname']:'NULL';        
		$dtl = isset($_POST['dtl'])?$_POST['dtl']:'NULL';        
		$nrank1 = isset($_POST['rank'])?$_POST['rank']:'0';        

		$sql_update = "UPDATE m_device  SET ucode = ?, fname = ?, dtl = ?, nrank1 = ?  WHERE id = ?  AND lid = '" . $global_lid . "'  ";

		if ($stmt2 = $mysqli->prepare($sql_update))
		{
				$rcode = $rname;
				$stmt2->bind_param("sssid", $ucode, $fname, $dtl, $nrank1, $id); 
				
				if ($stmt2->execute())
				{
					$stmt2->close();
					echo json_encode(array("SUCCESS", "TRUE", "OK", "Updated Successfully"));
					exit;
				}
				else
				{
					$stmt2->close();
//					echo json_encode(array("ERROR", "FALSE", "Error - 7" . $mysqli->error));
					echo json_encode(array("ERROR", "Duplicate, Already exists"));
					exit;
				}
		}
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10".  $mysqli->error));
			exit;
		}
	}
    else if ($opt == 3) /* FLAG */
    {
		$id = isset($_POST['rid'])?$_POST['rid']:'NULL';        
		$field = isset($_POST['field'])?$_POST['field']:'NULL';        
		$flag = isset($_POST['flag'])?$_POST['flag']:'0';        
		
		if (($flag == 0) OR ($flag == 1))
			null;
		else
		{
			echo json_encode(array("ERROR", "INVALID DATA"));
			exit;
		}
		
		if ($field == 1)
			$sql = "UPDATE m_device SET active = ?  WHERE id = ?  AND lid = '" . $global_lid . "'  ";
		else
		{
			echo json_encode(array("ERROR", "INVALID OPTION"));
			exit;
		}
			
			
		if ($stmt2 = $mysqli->prepare($sql))
		{
				$stmt2->bind_param("id", $flag, $id); 
				if ($stmt2->execute())
				{
					$stmt2->close();
					echo json_encode(array("SUCCESS", "TRUE", "OK", "Updated Successfully"));
					exit;
				}
				else
				{
					$stmt2->close();
					echo json_encode(array("ERROR", "FALSE", "Error - 7" . $mysqli->error));
					exit;
				}
		}
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10".  $mysqli->error));
			exit;
		}
		
	}
    else if ($opt == 7) /* VIEW */
    {
		$HTML = "";

		/*
		$sql = "SELECT DISTINCT deviceid FROM t_device_display ORDER BY deviceid";
		if ($result = $mysqli->query($sql)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$ARR_SHOW_FLAG[$obj->deviceid] =	1;
			}
		}
		UNSET($result);
		*/ 

		$sql = "SELECT * FROM m_device WHERE  lid = '" . $global_lid . "'   ORDER BY active DESC, nrank1, fname, id ";
		//$HTML .= $sql . '<br><br>';
		if ($result = $mysqli->query($sql)) 
		{
			$HTML .= '<table id="TABLE_OUTPUT" class="w3-table-all w3_bordered w3-centered">';
			$HTML .= '<tr style="background-color:red; color: white;">
							<th>Code</th>
							<th>Name</th>
							<th>Details</th>
							<th class="noPrint">Active</th>
							<th class="noPrint">Delete</th>
							<th class="noPrint">Edit</th>
						</tr>';

			while ($obj = $result->fetch_object()) 
			{
				$id = $obj->id;
				$sysdate1 = $obj->sysdate1;
				
				$active = $obj->active; /* Field - 1 */

				$HTML_ACTIVE = "";
				if ($active == 0)
					$HTML_ACTIVE = "<input type='checkbox' onclick='fn_device_mark(" . $id . ", 1, 1);'>";
				else
					$HTML_ACTIVE = "<input type='checkbox' CHECKED onclick='fn_device_mark(" . $id . ", 1, 0);'>";

				$HTML .= '<tr>';
				$HTML .= '	<td class="w3-left-align">' . $obj->ucode. '</td>';
				$HTML .= '	<td class="w3-left-align">' . $obj->fname. '</td>';
				$HTML .= '	<td class="w3-left-align">' . $obj->dtl. '</td>';

				$HTML .= '	<td title="Activate/Deactivate">' . $HTML_ACTIVE . '</td>';

				if ($ARR_SHOW_FLAG[$id] ==	0)
					$HTML .= '	<td title="Delete"><button class="w3-button w3-red" type="button" onclick="fn_device_delete(' . $id . ',\'' . $sysdate1 . '\');">Delete</button></td>';
				else
					$HTML .= '	<td></td>';

				$HTML .= '	<td class="noPrint">';
				$HTML .= '		<button class="w3-button w3-blue" type="button" onclick="fn_device_edit(' . $id . ');">Edit</button>';
				$HTML .= '		<input type="hidden" id="txt_id_' . $id . '" value="' . $obj->lid . '" >';
				$HTML .= '		<input type="hidden" id="txt_ucode_' . $id . '" value="' . $obj->ucode . '" >';
				$HTML .= '		<input type="hidden" id="txt_fname_' . $id . '" value="' . $obj->fname . '" >';
				$HTML .= '		<input type="hidden" id="txt_dtl_' . $id . '" value="' . $obj->dtl . '" >';
				$HTML .= '		<input type="hidden" id="txt_rank_' . $id . '" value="' . $obj->nrank1 . '" >';
				$HTML .= '	</td>';

				$HTML .= '</tr>';
			}
			$HTML .= '</table>';
			$result -> free_result();
		}
		$mysqli -> close();
		
		
		echo json_encode(array($HTML));
		exit;
	}
    else if ($opt == 9) /* DELETE */
    {
		$id = isset($_POST['rid'])?$_POST['rid']:'NULL';        
		$sysdate1 = isset($_POST['tstamp'])?$_POST['tstamp']:'NULL';        

		$sql = "SELECT id FROM m_device WHERE id = '" . $id . "' AND sysdate1 = '" . $sysdate1 . "' AND lid = '" . $global_lid . "'  ORDER BY id ";
		$id2 = 0;
		if ($result = $mysqli->query($sql)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$id2 = $obj->id;
			}
		}
		if ($id2 > 0)
			null;
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10. Invalid record"));
			exit;
		}
		$sql = "DELETE FROM m_device WHERE id = ? AND sysdate1 = ? AND lid = '" . $global_lid . "' ";
		if ($stmt2 = $mysqli->prepare($sql))
		{
				$stmt2->bind_param("ds", $id, $sysdate1); 
				if ($stmt2->execute())
				{
					$stmt2->close();
					echo json_encode(array("SUCCESS", "TRUE", "OK", "Deleted Successfully"));
					exit;
				}
				else
				{
					$stmt2->close();
					echo json_encode(array("ERROR", "FALSE", "Error - 7" . $mysqli->error));
					exit;
				}
		}
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10".  $mysqli->error));
			exit;
		}
	}
	else
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Else"));
		exit;
	}

echo json_encode(array("ERROR", "FALSE", "Error - END"));
exit;
?>
