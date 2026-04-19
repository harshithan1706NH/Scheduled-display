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
		$mobile = isset($_POST['mobile'])?$_POST['mobile']:'NULL';        
		$dtl = isset($_POST['dtl'])?$_POST['dtl']:'NULL';        
		$nrank1 = isset($_POST['rank'])?$_POST['rank']:'0';        


		if ($stmt2 = $mysqli->prepare("INSERT into m_user (ucode, fname, mobile, dtl, nrank1, ulogid, lid, lcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"))
		{
				$rcode = $fname;
				$stmt2->bind_param("ssdsidds", $ucode, $fname, $mobile, $dtl, $nrank1, $ulogid, $global_lid, $global_lcode); 
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
		$mobile = isset($_POST['mobile'])?$_POST['mobile']:'NULL';        
		$dtl = isset($_POST['dtl'])?$_POST['dtl']:'NULL';        
		$nrank1 = isset($_POST['rank'])?$_POST['rank']:'0';        

		if (strlen($password) > 4)
			$sql_update = "UPDATE m_user  SET ucode = ?, fname = ?, mobile = ?, dtl = ?, nrank1 = ?  WHERE id = ?  AND lid = '" . $global_lid . "' ";
		else
			$sql_update = "UPDATE m_user  SET ucode = ?, fname = ?, mobile = ?, dtl = ?, nrank1 = ?  WHERE id = ?  AND lid = '" . $global_lid . "'  ";

		if ($stmt2 = $mysqli->prepare($sql_update))
		{
				$rcode = $rname;
				if (strlen($password) > 4)
					$stmt2->bind_param("ssdsid", $ucode, $fname, $mobile, $dtl, $nrank1, $id); 
				else
					$stmt2->bind_param("ssdsid", $ucode, $fname, $mobile, $dtl, $nrank1, $id); 
				
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



		$sql = "SELECT * FROM m_user WHERE id = '" . $id . "' AND lid = '" . $global_lid . "' ORDER BY id ";
		$id2 = 0;
		if ($result = $mysqli->query($sql)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$id2 = $obj->id;

				$role_system = $obj->role_system; 
				$role_primary = $obj->role_primary; 
				$role_admin = $obj->role_admin; 
				$role_manager = $obj->role_manager; 
				$role_office = $obj->role_office; 
				$role_staff = $obj->role_staff; 

			}
		}
		if ($id2 > 0)
			null;
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10. Invalid record"));
			exit;
		}
		
		
		if ($role_system == 1)
		{
			echo json_encode(array("ERROR", "FALSE", "Error - UNKNOWN??."));
			exit;
		}
		if ($role_primary == 1)
		{
			echo json_encode(array("ERROR", "FALSE", "Error - UNKNOWN."));
			exit;
		}
		

		
		if ($field == 1)
			$sql = "UPDATE m_user SET active = ?  WHERE id = ?  AND lid = '" . $global_lid . "'  ";
		else if ($field == 2)
			$sql = "UPDATE m_user SET role_admin = ?  WHERE id = ?  AND lid = '" . $global_lid . "'  ";
		else if ($field == 3)
			$sql = "UPDATE m_user SET role_manager = ?  WHERE id = ?  AND lid = '" . $global_lid . "'  ";
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
    else if ($opt == 6) /* RESET PASSWORD */
    {
		$id = isset($_POST['rid'])?$_POST['rid']:'NULL';        
		$sysdate1 = isset($_POST['tstamp'])?$_POST['tstamp']:'NULL';        
		$lpassword = isset($_POST['ucode'])?$_POST['ucode']:'NULL';        

		$sql = "SELECT * FROM m_user WHERE id = '" . $id . "' AND sysdate1 = '" . $sysdate1 . "' AND lid = '" . $global_lid . "' ORDER BY id ";
		$id2 = 0;
		if ($result = $mysqli->query($sql)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$id2 = $obj->id;

				$role_system = $obj->role_system; 
				$role_primary = $obj->role_primary; 
				$role_admin = $obj->role_admin; 
				$role_manager = $obj->role_manager; 
				$role_office = $obj->role_office; 
				$role_staff = $obj->role_staff; 

			}
		}
		if ($id2 > 0)
			null;
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10. Invalid record"));
			exit;
		}
		
		
		if ($role_system == 1)
		{
			echo json_encode(array("ERROR", "FALSE", "Error - UNKNOWN??."));
			exit;
		}
		if ($role_primary == 1)
		{
			echo json_encode(array("ERROR", "FALSE", "Error - UNKNOWN."));
			exit;
		}
		
		if (strlen($lpassword) > 4)
			$sql_update = "UPDATE m_user  SET lpassword = ? WHERE id = ?  AND lid = '" . $global_lid . "' ";
		else
			$sql_update = "UPDATE m_user  SET lpassword = ? WHERE id = ?  AND lid = '" . $global_lid . "'  ";

		if ($stmt2 = $mysqli->prepare($sql_update))
		{
				$rcode = $rname;
				if (strlen($password) > 4)
					$stmt2->bind_param("sd", $lpassword, $id); 
				else
					$stmt2->bind_param("sd", $lpassword, $id); 
				
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
    else if ($opt == 7) /* VIEW */
    {


		unset($result1);
		if ($result1 = $mysqli->query("SELECT id, scode, tvalue1 FROM sys_self  WHERE active = '1' AND rstat = '1' ORDER BY id"))
		{
			while ($obj1 = $result1->fetch_object())
			{
				$id = $obj1->id;
				$scode = TRIM($obj1->scode);
				$tvalue1 = TRIM($obj1->tvalue1);
				$self[$scode] = $tvalue1;
			}
			$result1->close();
		}
		unset($result1);
		$MAX_USERS = $self["MAX_USERS"];

		$HTML = "";


		$sql = "SELECT id, ucode, fname, dtl FROM m_user ORDER BY fname";
		$sql = "SELECT * FROM m_user WHERE  lid = '" . $global_lid . "' ORDER BY active DESC, role_primary DESC, role_admin DESC, role_manager DESC, role_office DESC, nrank1, fname, id ";
		//$HTML .= $sql . '<br><br>';
		if ($result = $mysqli->query($sql)) 
		{
			$HTML .= '<table id="TABLE_OUTPUT" class="w3-table-all w3_bordered w3-centered">';
			$HTML .= '<thead>';
			$HTML .= '<tr class="CL_CSV" style="background-color:red; color: white;">
							<th class="CL_CSV">Code</th>
							<th class="CL_CSV">Name</th>
							<th class="CL_CSV">Mobile<br>User name</th>
							<th class="CL_CSV">Details</th>
							<th class="CL_NOCSV noPrint">Display Rank</th>

							<th class="CL_NOCSV noPrint">Admin</th>
							<th class="CL_NOCSV noPrint">Manager</th>

							<th class="CL_NOCSV noPrint">Active</th>
							<th class="CL_NOCSV noPrint">Delete</th>
							<th class="CL_NOCSV noPrint">Edit</th>

							<th class="CL_NOCSV noPrint">Department<br>Links</th>

							<th class="CL_NOCSV noPrint">Menu<br>Links</th>

							<th class="CL_NOCSV noPrint">Reset<br>Password</th>

						</tr>';
			$HTML .= '</thead>';
			$HTML .= '<tbody>';



			$active2 = 2;
	

			while ($obj = $result->fetch_object()) 
			{
				$id = $obj->id;
				$sysdate1 = $obj->sysdate1;

				$mobile = $obj->mobile;
				
				$active = $obj->active; /* Field - 1 */
				$flag_demo = $obj->flag_demo; /* Field - 2 */
				
				$role_system = $obj->role_system; 
				$role_primary = $obj->role_primary; 
				$role_admin = $obj->role_admin; 
				$role_manager = $obj->role_manager; 
				$role_office = $obj->role_office; 
				$role_staff = $obj->role_staff; 
				
				if ($role_system == 1)
					continue;



				if ($active2 == $active)
				{
					null;		
				}
				else
				{
					$active2 = $active;
					
					if ($active == 1)
						$HTML .= 
							"
							<tr style='vertical-align: middle; background-color:red; color:white; text-align:center;'>
								<td colspan='13'>Active Users (Maximum " . ($MAX_USERS - 1) . " users)</td>
							</tr>";
					else
						$HTML .= 
						 "
							<tr style='vertical-align: middle; background-color:red; color:white; text-align:center;'>
								<td colspan='13'>Inactive Users</td>
							</tr>";
					
				}


				$HTML_ACTIVE = "";
				if ($role_primary == 1)
					$HTML_ADMIN = "<span style='color:blue;'></span>";
				else
					if ($active == 0)
						$HTML_ACTIVE = "<input type='checkbox' onclick='fn_user_mark(" . $id . ", 1, 1);'>";
					else
						$HTML_ACTIVE = "<input type='checkbox' CHECKED onclick='fn_user_mark(" . $id . ", 1, 0);'>";


				$HTML_ADMIN = "";
				if ($role_primary == 1)
					$HTML_ADMIN = "<span style='color:blue;'></span>";
				else
					if ($role_admin == 0)
						$HTML_ADMIN = "<input type='checkbox' onclick='fn_user_mark(" . $id . ", 2, 1);'>";
					else
						$HTML_ADMIN = "<input type='checkbox' CHECKED onclick='fn_user_mark(" . $id . ", 2, 0);'>";


				$HTML_MANAGER = "";
				if ($role_primary == 1)
					$HTML_MANAGER = "<span style='color:blue;'></span>";
				else
					if ($role_manager == 0)
						$HTML_MANAGER = "<input type='checkbox' onclick='fn_user_mark(" . $id . ", 3, 1);'>";
					else
						$HTML_MANAGER = "<input type='checkbox' CHECKED onclick='fn_user_mark(" . $id . ", 3, 0);'>";

/*
				$HTML_OFFICE = "";
				if ($role_primary == 1)
					$HTML_OFFICE = "<span style='color:blue;'></span>";
				else
					if ($role_admin == 0)
						$HTML_OFFICE = "<input type='checkbox' onclick='fn_user_mark(" . $id . ", 4, 1);'>";
					else
						$HTML_OFFICE = "<input type='checkbox' CHECKED onclick='fn_user_mark(" . $id . ", 4, 0);'>";
*/
				
				
				$HTML .= '<tr class="CL_CSV">';
				$HTML .= '	<td class="CL_CSV w3-left-align">' . $obj->ucode. '</td>';
				$HTML .= '	<td class="CL_CSV w3-left-align">' . $obj->fname. '</td>';
				
				$HTML .= '	<td class="CL_CSV w3-left-align">' . $mobile . '</td>';
				
				
				$HTML .= '	<td class="CL_CSV w3-left-align">' . $obj->dtl. '</td>';

				$HTML .= '	<td class="CL_NOCSV noPrint w3-center-align">' . $obj->nrank1. '</td>';

			
				$HTML .= '	<td class="CL_NOCSV noPrint" title="Admin/Not">' . $HTML_ADMIN . '</td>';

				$HTML .= '	<td class="CL_NOCSV noPrint" title="Manager/Not">' . $HTML_MANAGER . '</td>';

				$HTML .= '	<td class="CL_NOCSV noPrint" title="Activate/Deactivate">' . $HTML_ACTIVE . '</td>';

				if ($role_primary == 1)
					$HTML .= '	<td class="CL_NOCSV noPrint">Super<br>Admin</td>';
				else
					$HTML .= '	<td  class="CL_NOCSV noPrint" title="Delete"><button class="w3-button w3-red" type="button" onclick="fn_user_delete(' . $id . ',\'' . $sysdate1 . '\');">Delete</button></td>';

				$HTML .= '	<td class="CL_NOCSV noPrint">';
				$HTML .= '		<button class="w3-button w3-blue" type="button" onclick="fn_user_edit(' . $id . ');">Edit</button>';
				$HTML .= '		<input type="hidden" id="txt_id_' . $id . '" value="' . $obj->lid . '" >';
				$HTML .= '		<input type="hidden" id="txt_ucode_' . $id . '" value="' . $obj->ucode . '" >';
				$HTML .= '		<input type="hidden" id="txt_fname_' . $id . '" value="' . $obj->fname . '" >';
				$HTML .= '		<input type="hidden" id="txt_dtl_' . $id . '" value="' . $obj->dtl . '" >';
				$HTML .= '		<input type="hidden" id="txt_rank_' . $id . '" value="' . $obj->nrank1 . '" >';
				$HTML .= '		<input type="hidden" id="txt_mobile_' . $id . '" value="' . $mobile . '" >';
				
				$HTML .= '	</td>';

				$HTML .= '	<td class="CL_NOCSV noPrint">';
				$HTML .= '		<button class="w3-button w3-indigo" type="button" onclick="fn_user_dept_links_edit(' . $id . ');">Dept Links</button>';
				$HTML .= '	</td>';


				$HTML .= '	<td class="CL_NOCSV noPrint">';
				$HTML .= '		<button class="w3-button w3-indigo" type="button" onclick="fn_user_menu_links_edit(' . $id . ');">Menu Links</button>';
				$HTML .= '	</td>';

/*
				if ($role_primary == 1)
					$HTML .= '	<td class="CL_NOCSV noPrint"></td>';
				else
					$HTML .= '	<td  class="CL_NOCSV noPrint" title="Delete"><button class="w3-button w3-grey" type="button" onclick="fn_Reset(' . $id . ',\'' . $sysdate1 . '\');">Reset Password</button></td>';
*/

				$HTML .= '	<td  class="CL_NOCSV noPrint" title="Delete"><button class="w3-button w3-grey" type="button" onclick="fn_Reset_Password(' . $id . ',\'' . $sysdate1 . '\');">Reset Password</button></td>';

				$HTML .= '</tr>';
			}
			$HTML .= '<tbody>';
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

		$sql = "SELECT * FROM m_user WHERE id = '" . $id . "' AND sysdate1 = '" . $sysdate1 . "' AND lid = '" . $global_lid . "' ORDER BY id ";
		$id2 = 0;
		if ($result = $mysqli->query($sql)) 
		{
			while ($obj = $result->fetch_object()) 
			{
				$id2 = $obj->id;

				$role_system = $obj->role_system; 
				$role_primary = $obj->role_primary; 
				$role_admin = $obj->role_admin; 
				$role_manager = $obj->role_manager; 
				$role_office = $obj->role_office; 
				$role_staff = $obj->role_staff; 

			}
		}
		if ($id2 > 0)
			null;
		else
		{
			echo json_encode(array("ERROR", "FALSE", "Error - 10. Invalid record"));
			exit;
		}
		
		
		if ($role_system == 1)
		{
			echo json_encode(array("ERROR", "FALSE", "Error - UNKNOWN??."));
			exit;
		}
		if ($role_primary == 1)
		{
			echo json_encode(array("ERROR", "FALSE", "Error - UNKNOWN."));
			exit;
		}
		
		
		
		
		$sql = "DELETE FROM m_user WHERE id = ? AND sysdate1 = ? AND lid = '" . $global_lid . "' ";
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
    else if ($opt == 11) /* UPLOAD */
    {
		if (isset($_FILES['userfile']))
		{
			$csv_file = $_FILES['userfile']['tmp_name'];
			if (!is_file($csv_file))
			{
				echo "Error in uploading file";
				exit;
			}
			else
			{
				$sql = "INSERT into m_user (ucode, fname, dtl, nrank1, ulogid, lid) VALUES (?, ?, ?, ?, ?, ?)";
				if ($stmt = $mysqli->prepare($sql))
				{
					$stmt->bind_param("sssidd", $ucode, $fname, $dtl, $nrank1, $ulogid, $global_lid); 
					
					if (($handle = fopen($csv_file, "r")) !== FALSE)
					{
						$counter = 0;
						while (($data2 = fgetcsv($handle)) !== FALSE)
						{
							$counter++;
						}
						$flag = 0;
						$counter2 = 0; /* NOT TO PRINT LAST RECRD ERROR MESSAGE IN CSV FILE */
						$counter3 = 0; /* CHECK FOR UNKNOWN INPUT FILE */

						$HTML = "-" ;
						$nrank1 = 1;
						
						rewind($handle);
						while (($data = fgetcsv($handle)) !== FALSE)
						{
							$counter2++;
							if ($flag == 0)
							{
								$flag = 1;
								$counter3++;
								continue;
							}
							
							$txt = $data[0]; 
							$txt = trim($txt); // code 
							$ucode = $txt;
							$fname = $txt;
							$dtl = $txt;
							
							//$fname = preg_replace('/[^\w#& @]/', '', $txt);

							$stmt->execute();
							
							$HTML .= $stmt->error;
						}
						fclose($handle);
						
						
						
						
					}
					$stmt->close();
					
					echo json_encode(array("SUCCESS", "TRUE", "OK", "Uploaded Successfully"));
					//echo "Completed " . $counter . " / " . $counter2 . " / " . $counter3 . " records. " . $HTML;
					exit;
				}
				else
				{
					echo json_encode(array("ERROR", "FALSE", $mysqli->error));
					exit;
				}
			}
		}   
		echo json_encode(array("ERROR", "FALSE", "Error - Upload"));
		exit;
	}
	else
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Else"));
		exit;
	}

echo json_encode(array("ERROR", "FALSE", "Error - END"));
exit;
?>
