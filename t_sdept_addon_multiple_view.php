<?php
	ob_start(); 
	session_start();
	require_once('sowhall.php');  
	require_once('xcode.php'); 
	require_once('url.php'); 	
 
	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];
	
//subdept=" .  $subdepartmentid . "&product=" . $product_id . "&machine=" . $machine_id . "&addon=" . $addon_id . "' class='w3-animate-zoom w3-button w3-indigo'>Go...</a>
	


    $shiftid = isset($_GET['shift'])?$_GET['shift']:'1';        
    $shiftid = isset($_GET['shift2'])?$_GET['shift2']:'1';        
    $tdate = isset($_GET['tdate2'])?$_GET['tdate2']:'0';        
    
//    echo "<br><br><br><br>" . $shiftid;
    
    if (strlen($tdate) < 5)
		if (strlen($_COOKIE['CURRENT_ENTRY_DATE']) < 5)
			$tdate = date("Y-m-d");
		else
			$tdate = $_COOKIE['CURRENT_ENTRY_DATE'];

	if (validateDate($tdate, 'Y-m-d'))
		null;
	else
		$tdate = date("Y-m-d");
		
	$lock_counter = 0;	
	$sql = "SELECT COUNT(*) AS counter FROM t_wagesperiod 
				WHERE  lid = '" . $global_lid . "'  
					AND date_from <=  '" . $tdate . "'  
					AND date_to >=  '" . $tdate . "'  
					AND flag_locked = 0 ";
	//$HTML .= $sql . '<br><br>';
	//echo $sql;
	if ($result = $mysqli->query($sql)) 
	{

		while ($obj = $result->fetch_object()) 
		{
			$lock_counter = $obj->counter;
		}
	}
	if ($lock_counter > 0)
		null;
	else
		$tdate = date("Y-m-d");
			
	
		
		
		
	setcookie("CURRENT_ENTRY_DATE", $tdate);

	if ($shiftid == 0)
	{
		if ($_COOKIE['CURRENT_ENTRY_SHIFT'] > 0)
			$shiftid = $_COOKIE['CURRENT_ENTRY_SHIFT'];
		else
			$shiftid = 1;
	}

	setcookie("CURRENT_ENTRY_SHIFT", $shiftid);
    


	list($year, $month, $date) = sscanf($tdate, "%d-%d-%d");
	$itdate = "$date/$month/$year";

	
	$sdept = isset($_GET['subdept']) ? $_GET['subdept'] : 'NULL';
	
    $sdept2 = 0;        
	if ($result1 = $mysqli->query("SELECT id, fname, ucode FROM m_subdepartment  WHERE flag_addon = 1 AND id = '" . $sdept . "' AND  lid = '" . $global_lid . "'"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$sdept2 = $obj1->id;
				$subdepartmentid = $obj1->id;
				$subdepartmentid2 = $obj1->id;
				$subdepartment_name = $obj1->fname;
				$subdepartment_code = $obj1->ucode;
				$SDEPT_NAME = str_pad($obj1->ucode,8," ",STR_PAD_LEFT) . " - " . $obj1->fname;
			}
			unset($result1);
		} 
	}
    if ($sdept2 == 0)
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid sub department"));
		exit;
	}








	if ($result1 = $mysqli->query("SELECT id, ucode, fname FROM m_addon  WHERE lid = '" . $global_lid . "'"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_ADDON[$obj1->id] =  $obj1->fname;
				$ARR_ADDON_CODE[$obj1->id] =  $obj1->ucode;
				
				$ARR_ADDON_RATE[$obj1->id] =  1;
				$ARR_MASTER_RATE[$obj1->id] =  1;
				$ARR_MASTER_FLAG[$obj1->id] =  1;

				$ARR_ADDON_FLAG[$obj1->id] =  1;
			}
			unset($result1);
		} 
	}


	/*--------------------------*/
	foreach($ARR_ADDON_FLAG as $key => $entry) 
	{
		if(isset($entry[1]) && $entry[1] === 0) 
		{
			unset($ARR_ADDON_FLAG[$key]);
		}
	}
	$ARR_ADDON_FLAG = array_filter($ARR_ADDON_FLAG);
	/*--------------------------*/
/****** REMOVE ZERO VALUES - END ******/



/****** CREATE WHERE IN - START ******/
	/*--------------------------*/
	$ADDON_IN = "";
	foreach($ARR_ADDON_FLAG as $key => $entry) 
	{
		$ADDON_IN .= $key . ",";
	}
	$ADDON_IN = rtrim($ADDON_IN, ',');
	/*--------------------------*/
/****** CREATE WHERE IN - END ******/



	
    $shiftidx = 0;        
	if ($result1 = $mysqli->query("SELECT * FROM m_shift  WHERE id = '" . $shiftid . "' AND  lid = '" . $global_lid . "'"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$shiftidx = $obj1->id;
				$shift_name = $obj1->fname;
				$shift_ttimef = $obj1->ttimef;
				$shift_ttimef1 = $obj1->ttimef1;
				$shift_ttimef2 = $obj1->ttimef2;
				$shift_ttimet = $obj1->ttimet;
				$shift_ttimet1 = $obj1->ttimet1;
				$shift_ttimet2 = $obj1->ttimet2;
				$shift_hours = $obj1->hours;
				$shift_span_next_day = $obj1->span_next_day;
				$shift_category_id =  $obj1->shift_category_id;        
			}
			unset($result1);
		} 
	}
    if ($shiftidx == 0)
	{
		echo json_encode(array("ERROR", "FALSE", "Error - Invalid shift"));
		exit;
	}

	$tdatef = $tdate;
	$tdatet = $tdate;
	if ($shift_span_next_day > 0)
	{
		$datez=date_create($tdate);
		date_add($datez,date_interval_create_from_date_string($shift_span_next_day . " days"));
		$tdatet = date_format($datez,"Y-m-d");		
	}
	
	









	if ($result1 = $mysqli->query("SELECT id, ucode, fname FROM m_employee  WHERE  lid = '" . $global_lid . "'"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_EMPLOYEE_DTL[$obj1->id] = $obj1->ucode . " - " . $obj1->fname;
			}
			unset($result1);
		} 
	}





//	$LIST_SHIFT =  'Shift <select id="txt_shiftid" name="txt_shiftid"   change="fn_changeEntryMultipleShift();" >';
	$LIST_SHIFT =  'Shift <select id="txt_shiftid" name="txt_shiftid"   onchange="fn_changeMultipleAddonShift();" >';
	$LIST =  '';
	$LIST .=  '<option value="0" selected>-</option>';
	/* Select queries return a resultset */
	$slno = 0;
	
	
	$sql = "
			SELECT id, ucode, fname FROM m_shift 
			WHERE id IN 
			( 
				SELECT recid2 FROM l_masters WHERE master1 = 102 AND master2 = 107 AND recid1 = '" . $subdepartmentid2 . "'
					UNION
				SELECT recid1 FROM l_masters WHERE master1 = 107 AND master2 = 102 AND recid2 = '" . $subdepartmentid2  . "'
			) 
			AND active = '1' order by nrank1, fname, id
			";
	
	
	//echo $sql;
	
	
	if ($result1 = $mysqli->query($sql))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$shiftid2 = $obj1->id;
				$shiftfname = $obj1->fname;
				$shiftcode = $obj1->ucode;
				
//				$shiftname = $shiftcode . " - " . $shiftfname;
				$shiftname = $shiftcode;
				
				if ($shiftid == $shiftid2)
					$LIST .=  '<option SELECTED value="' . $shiftid2 . '">' . $shiftname .'</option>';
				else
					$LIST .=  '<option value="' . $shiftid2 . '">' . $shiftname .'</option>';

				$ARR_SHIFT[$shiftid2] = $shiftname;
			}
			$result1->close();
		} 
		else
		{
			$LIST .=  '<option value="0">NO RECORDS FOUND</option>';
		}
	} 
	else
	{
		$LIST .=  '<option value="0">NO RECORDS FOUND</option>';
	}
	$LIST .= '</select>';
	unset($result1);

	$LIST_SHIFT .=  $LIST;
	$LIST =  '';




	$sql = "
			SELECT id, ucode, fname FROM m_shift_category 
			WHERE id IN 
			( 
				SELECT recid2 FROM l_masters WHERE master1 = 102 AND master2 = 108 AND recid1 = '" . $subdepartmentid2 . "'
					UNION
				SELECT recid1 FROM l_masters WHERE master1 = 108 AND master2 = 102 AND recid2 = '" . $subdepartmentid2  . "'
			) 
			AND active = '1' order by nrank1, fname, id
			";
	$PAGE_SHIFT_CATEGORY_IN = "";
	if ($result1 = $mysqli->query($sql))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$shift_category_id2 = $obj1->id;
				$shift_category_fname = $obj1->fname;
				$shift_category_code = $obj1->ucode;
				
//				$shiftname = $shiftcode . " - " . $shiftfname;
				$shift_category_name = $shift_category_code;

				$ARR_SHIFT_CATEGORY[$shift_category_id2] = $shift_category_name;

				if ($PAGE_SHIFT_CATEGORY_IN == "")
					null;
				else
					$PAGE_SHIFT_CATEGORY_IN .= ",";

				$PAGE_SHIFT_CATEGORY_IN .= $obj1->id;
				
			}
			$result1->close();
		} 
	} 
	unset($result1);


//echo '<pre>'; print_r($ARR_EMPLOYEE_WAGES); echo '</pre>';
	
?>
<!DOCTYPE html>
<html>
<style>
	.SMART_LOADER 
	{
	  position: fixed;
	  background-color: #FFF;
	  opacity: 1;
	  height: 100%;
	  width: 100%;
	  top: 0;
	  left: 0;
	  z-index: 10;
	}
</style>	
<div class="SMART_LOADER">
	<span style="position: fixed;  top: 50%;  left: 50%;  transform: translate(-50%, -50%);">Contacting Server...</span>
	<img style="width:200px; height: auto; position: fixed;  top: 50%;  left: 50%;  transform: translate(-50%, -50%);" src='data:image/gif;base64,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'/>
</div>
<head>
	<?php echo $toplink; ?>
	<?php echo $toplink2; ?>
	<title>Sub Department - Addon Data Entry</title>	

<style>
#dataTable
{
	border-collapse:collapse !important;
}

#dataTable th
{
	background-color:red !important;
	color: white !important;
	box-shadow: 0 0px 0.5px 1px gray !important;
}
#dataTable td
{
	border: 1px solid grey !important;
	box-shadow: 0 0px 0.5px 1px gray !important;
}

	
	
	
</style>	
	
</head>

<body onload="fn_initMultipleAddonDate();">

<?php echo $navbar; ?>


<?php
	echo "<div class='table-responsive'>
			<table class='table table-hover'>	
				<tr style='border:1px solid black;'>
					<td>" . $subdepartment_name . " > </td>
					<td><input  id='tdate' name='tdate' type='date' value = '" . $tdate . "' onchange='fn_changeMultipleAddonDate();'  placeholder='Select Date'></td>
					<td>" . $LIST_SHIFT . "</td>
					<!--<td><input type='text' id='txt_filter' onkeyup='fn_FilterTableRecords(\"txt_filter\", \"dataTable\");' placeholder='Search..'  class='noPrint'></td>-->
				</tr>
			</table>
		 </div>";
?>


<?php

//					<!--<td>" . $addonwages . " for " . $addonwages_nou . " " . $unitname . "</td>-->

	echo "<form id='frm_sdept_addon_multiple_view1' name='frm_sdept_addon_multiple_view1' action='t_sdept_addon_multiple_view.php' method='GET'>";
	echo "	<input  id='tdate2' name='tdate2' type='hidden' value = '" . $tdate . "'>";
	echo "	<input  id='shift2' name='shift2' type='hidden' value = '" . $shiftid . "'>";
	echo "	<input  id='subdepartmentid' name='subdepartmentid' type='hidden' value = '" . $subdepartmentid . "'>";
	echo "	<input  id='shiftid' name='shiftid' type='hidden' value = '" . $shiftid . "'>";


	echo "	<input  id='subdept' name='subdept' type='hidden' value = '" . $subdepartmentid . "'>";
	echo "	<input  id='shift' name='shift' type='hidden' value = '" . $shiftid . "'>";

	echo "</form>";

?>




<?php

	$addonwages_nou = 1;



	$HEADER_ROW1 = "	
			<tr style='text-align:center; background-color:#f2f2f2;'>
				<th></th>";
				
	$HEADER_ROW2 = "	
			<tr style='text-align:center; background-color:#f2f2f2;'>
				<th></th>";
				
	$HEADER_ROW3 = "	
			<tr style='text-align:center; background-color:#f2f2f2;'>
				<th>Employee</th>";
				

	$HEADER_ROW = "	
			<tr style='text-align:center; background-color:#f2f2f2;'>
				<th>Employee</th>";
				


	if ($result_addon = $mysqli->query("SELECT id FROM m_addon  WHERE  id IN (" . $ADDON_IN . ") AND lid = '" . $global_lid . "' ORDER BY nrank1, id"))
	{
		if ($result_addon->num_rows > 0)
		{
			while ($obj_addon = $result_addon->fetch_object())
			{
				$addonid =  $obj_addon->id;
				
				if ($ARR_MASTER_FLAG[$addonid] ==  1)
				{
					$ARR_ADDON_RATE[$addonid] = 0;
					if ($ARR_MASTER_RATE[$addonid] > 0)
						$ARR_ADDON_RATE[$addonid] = $ARR_MASTER_RATE[$addonid];
					
					
					$addonwages_txt = "";
					if ($ARR_MASTER_RATE[$addonid] > 0)
						$addonwages_txt =  "<br><span style='font-size:70%;'>[Rs. " . $ARR_MASTER_RATE[$addonid] . "]</span>";

					$HEADER_ROW1 .= "<th></th>";
					$HEADER_ROW2 .= "<th></th>";
					$HEADER_ROW3 .= "<th style='white-space: nowrap;'>" 
										. $ARR_ADDON[$addonid] . $addonwages_txt . 
									"</th>";


					$HEADER_ROW .= "<th style='white-space: nowrap;'>" .
										"<br>" . $ARR_ADDON[$addonid] . $addonwages_txt . 
									"</th>";

				}
			}
			unset($result_addon);
		} 
	}
	$HEADER_ROW1 .= "</tr>";
	$HEADER_ROW2 .= "</tr>";
	$HEADER_ROW3 .= "</tr>";








	$TR_BLOCK1 = "";

//    $sql = "SELECT id, fname, ucode, ucode2 FROM m_employee  WHERE sectionid = '" . $sectionid . "' AND active = '1' AND rstat = '1' ORDER BY rank";
//    $sql = "SELECT DISTINCT employeeid AS employeeid FROM t_daily_addon  WHERE tdate = '" . $tdate . "' AND   subdepartmentid = '" . $subdepartmentid  . "' AND  productid = '" . $productid  . "' AND machineid  = '" . $machineid  . "' AND  addonid = '" . $addonid  . "'  AND  lid = '" . $global_lid . "' AND active = '1' AND rstat = '1' ORDER BY nrank1, ucode, id ";
//    $sql = "SELECT DISTINCT employeeid AS employeeid FROM t_daily_addon  A JOIN m_employee B ON A.employeeid = B.id WHERE A.tdate = '" . $tdate . "' AND   A.shiftid = '" . $shiftid  . "'  AND   A.subdepartmentid = '" . $subdepartmentid  . "' AND  A.productid = '" . $productid  . "' AND A.machineid  = '" . $machineid  . "' AND  A.addonid = '" . $addonid  . "'  AND  A.lid = '" . $global_lid . "' AND A.active = '1' AND A.rstat = '1' ORDER BY B.nrank1, B.ucode, B.id ";
    $sql = "SELECT DISTINCT employeeid AS employeeid 
					FROM t_daily_addon  A 
					JOIN m_employee B ON A.employeeid = B.id 
				WHERE A.tdate = '" . $tdate . "' AND   A.shiftid = '" . $shiftid  . "'  
					AND   A.subdepartmentid = '" . $subdepartmentid  . "' AND  A.lid = '" . $global_lid . "' 
					AND A.active = '1' AND A.rstat = '1' 
				ORDER BY B.nrank1, cast(B.ucode as unsigned), B.id ";
//    echo $sql;
    if ($result = $mysqli1->query($sql))
    {
		if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_object())
            {
				$employeeid = $row->employeeid;

				if ($ARR_EMPLOYEE_FLAG[$employeeid] > 0)
				{
					null;
				}
				else
				{
					$ARR_EMPLOYEE_FLAG[$employeeid] = 1;

					$ERR = "";
					$employee_dtl = $ARR_EMPLOYEE_DTL[$employeeid] . $ERR;
					
					$EMPLOYEE1_HTML = '';
					$EMPLOYEE1_HTML .= "<select CLASS='CL_EMP' name='emp" . $arg_fieldname . "'  id='emp" . $arg_fieldname . "'>";
					$EMPLOYEE1_HTML .= "<option SELECTED value='" . $employeeid . "'>" . $employee_dtl . "</option>";
					$EMPLOYEE1_HTML .= "</select>";

//					$sql2 = "SELECT id, tdate, nou, amt FROM t_daily_addon  WHERE  tdate = '" . $tdate . "' AND   employeeid = '" . $employeeid . "' AND  factoryid = '" . $factoryid . "' AND addonid = '" . $addonid . "' AND active = '1' AND rstat = '1' ORDER BY tdate";
					$sql2 = "SELECT id, nou, amt, addonid, periodid FROM t_daily_addon  WHERE  tdate = '" . $tdate . "' AND   shiftid = '" . $shiftid  . "'  AND   employeeid = '" . $employeeid . "'  AND   subdepartmentid = '" . $subdepartmentid  . "' AND  lid = '" . $global_lid . "' AND active = '1' AND rstat = '1'  ORDER BY tdate";
					if ($result2 = $mysqli2->query($sql2))
					{
						if ($result2->num_rows > 0)
						{
							while ($row2 = $result2->fetch_object())
							{
								$nou = $row2->nou;
								$addonid = $row2->addonid;

								$ARR_EMP_EXISTING_NOU[$employeeid][$addonid] = $nou;

								$periodid = $row2->periodid;
								$ARR_EMP_EXISTING_PERIOD[$employeeid][$addonid] = $periodid;
							}
						}
					}
					
					$TR_BLOCK1 .= "<tr class='TR_EMPLOYEE_ROW' style='text-align:right; background-color:#ffffcc;'>
							<th style='  text-align:left;'>" . $EMPLOYEE1_HTML . "</th>";


					foreach($ARR_ADDON_RATE as $addonid=>$addonwages)
					{

						$arg_fieldtype = 1;
						$arg_fieldid = $employeeid;
						$arg_fieldname = "A" . $employeeid . "P" . $addonid;	

						$enou = 0;
						$enou_txt = "";
						if ($ARR_EMP_EXISTING_NOU[$employeeid][$addonid] > 0)
						{
							$enou_txt = $ARR_EMP_EXISTING_NOU[$employeeid][$addonid];
							$enou =  $ARR_EMP_EXISTING_NOU[$employeeid][$addonid];
						}

						$periodid = 0;
						if ($ARR_EMP_EXISTING_PERIOD[$employeeid][$addonid] > 0)
							$periodid =  $ARR_EMP_EXISTING_PERIOD[$employeeid][$addonid];


						
						$TR_BLOCK1 .=  "<td>
									<input  id='nou" . $arg_fieldname . "' class='CL_NOU' type='number' name='nou'  min='0' value = '" . $enou_txt . "' data-employeeid='" . $employeeid . "' data-enou='" . $enou . "' data-productid='" . $productid . "' data-machineid='" . $machineid . "' data-addonid='" . $addonid . "'  data-periodid='" . $periodid . "' style='width:100%;'>
							  </td>";
						
					}

					$TR_BLOCK1 .=  "</tr>";
				}
							

							
            }
        }
    }
	unset($result);








	$FILE_EMPLOYEE_IN = "";


	if ($shift_span_next_day == 0)
	{
		$sql = "SELECT employeeid FROM t_daily_attendance 
				WHERE tdatef = '" . $tdatef . "' 
					AND ttimef >= '" . $shift_ttimef1 . "'   
					AND ttimef <= '" . $shift_ttimet1 . "'   
					AND subdepartmentid = '" . $subdepartmentid . "'   
					AND  lid = '" . $global_lid . "' AND active = '1' AND rstat = '1' ORDER BY tdatef, ttimef, id ";
	}
	else
	{
		$sql = "SELECT employeeid FROM t_daily_attendance 
				WHERE 
					( (tdatef = '" . $tdatef . "' AND ttimef >= '" . $shift_ttimef1 . "')   OR
					  (tdatef = '" . $tdatet . "' AND ttimef <= '" . $shift_ttimet1 . "')  ) 
					AND subdepartmentid = '" . $subdepartmentid . "'   
					AND  lid = '" . $global_lid . "' AND active = '1' AND rstat = '1' ORDER BY tdatef, ttimef, id ";
	}




		
    //echo $sql; 
    if ($result = $mysqli1->query($sql))
    {
		if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_object())
            {
				$employeeid = $row->employeeid;
				if ($employeeid > 0)
				{
					if ($FILE_EMPLOYEE_IN == "")
						null;
					else
						$FILE_EMPLOYEE_IN .= ",";

					$FILE_EMPLOYEE_IN .= $employeeid;
				}
			}
		}
	}
	unset($result);




	$TR_BLOCK2 = "";


    $sql = "SELECT id, fname, ucode FROM m_employee  WHERE   shift_category_id = '" . $shift_category_id . "'  AND subdeptid = '" . $subdepartmentid . "' AND id IN (" . $FILE_EMPLOYEE_IN . ") AND active = '1' AND rstat = '1' ORDER BY nrank1, cast(ucode as unsigned), id";
//    echo $sql;
    if ($result = $mysqli1->query($sql))
    {
		if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_object())
            {
				$employeeid = $row->id;

				if ($ARR_EMPLOYEE_FLAG[$employeeid] > 0)
				{
					null;
				}
				else
				{
					$ARR_EMPLOYEE_FLAG[$employeeid] = 1;
				

					$employee_fname = $row->fname;
					$ucode = $row->ucode;
					$ucode2 = $row->ucode;

					//$employee_dtl = $employee_fname . "<br>[" .  $ecode  . " - " .  $ecode2  . "]";
					$employee_dtl = $ucode . " - " . $employee_fname . $ERR;
					
					$EMPLOYEE2_HTML = '';
					$EMPLOYEE2_HTML .= "<select CLASS='CL_EMP' name='emp" . $arg_fieldname . "'  id='emp" . $arg_fieldname . "'>";
					$EMPLOYEE2_HTML .= "<option SELECTED value='" . $employeeid . "'  data-wages='" . $data_addonwages . "'  data-wages-nou='" . $data_addonwages_nou . "'>" . $employee_dtl . "</option>";
					$EMPLOYEE2_HTML .= "</select>";
					
					
					$TR_BLOCK2 .=  "<tr class='TR_EMPLOYEE_ROW' style='text-align:right; background-color:#ccffff;'>
							<th style='  text-align:left;'>" . $EMPLOYEE2_HTML . "</th>";


					foreach($ARR_ADDON_RATE as $addonid=>$addonwages)
					{

						$arg_fieldtype = 1;
						$arg_fieldid = $employeeid;
						$arg_fieldname = "B" . $employeeid . "P" . $addonid;	

						$enou = 0;
						$enou_txt = "";

						$periodid = 0;

						$TR_BLOCK2 .=   "<td>
									<input  id='nou" . $arg_fieldname . "' class='CL_NOU' type='number' name='nou'  min='0' value = '" . $enou_txt . "' data-employeeid='" . $employeeid . "'  data-enou='" . $enou . "'  data-productid='" . $productid . "' data-machineid='" . $machineid . "' data-addonid='" . $addonid . "'  data-periodid='" . $periodid . "' style='width:100%;'>
							  </td>";
						
					}

					$TR_BLOCK2 .=   "</tr>";
					
				}
            }
        }
    }



    $sql = "SELECT id, fname, ucode FROM m_employee  WHERE  subdeptid = '" . $subdepartmentid . "' AND id IN (" . $FILE_EMPLOYEE_IN . ") AND active = '1' AND rstat = '1' ORDER BY nrank1, cast(ucode as unsigned), id";
//    echo $sql;
    if ($result = $mysqli1->query($sql))
    {
		if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_object())
            {
				$employeeid = $row->id;

				if ($ARR_EMPLOYEE_FLAG[$employeeid] > 0)
				{
					null;
				}
				else
				{
					$ARR_EMPLOYEE_FLAG[$employeeid] = 1;
				

					$employee_fname = $row->fname;
					$ucode = $row->ucode;
					$ucode2 = $row->ucode;

					//$employee_dtl = $employee_fname . "<br>[" .  $ecode  . " - " .  $ecode2  . "]";
					$employee_dtl = $ucode . " - " . $employee_fname . $ERR;
					
					$EMPLOYEE2_HTML = '';
					$EMPLOYEE2_HTML .= "<select CLASS='CL_EMP' name='emp" . $arg_fieldname . "'  id='emp" . $arg_fieldname . "'>";
					$EMPLOYEE2_HTML .= "<option SELECTED value='" . $employeeid . "'  data-wages='" . $data_addonwages . "'  data-wages-nou='" . $data_addonwages_nou . "'>" . $employee_dtl . "</option>";
					$EMPLOYEE2_HTML .= "</select>";
					
					
					$TR_BLOCK2 .=  "<tr class='TR_EMPLOYEE_ROW' style='text-align:right; background-color:#ff8080;'>
							<th style='  text-align:left;'>" . $EMPLOYEE2_HTML . "</th>";


					foreach($ARR_ADDON_RATE as $addonid=>$addonwages)
					{

						$arg_fieldtype = 1;
						$arg_fieldid = $employeeid;
						$arg_fieldname = "B" . $employeeid . "P" . $addonid;	

						$enou = 0;
						$enou_txt = "";

						$periodid = 0;

						$TR_BLOCK2 .=   "<td>
									<input  id='nou" . $arg_fieldname . "' class='CL_NOU' type='number' name='nou'  min='0' value = '" . $enou_txt . "' data-employeeid='" . $employeeid . "'  data-enou='" . $enou . "'  data-productid='" . $productid . "' data-machineid='" . $machineid . "' data-addonid='" . $addonid . "'  data-periodid='" . $periodid . "' style='width:100%;'>
							  </td>";
						
					}

					$TR_BLOCK2 .=   "</tr>";
					
				}
            }
        }
    }




	echo "<div class='DIV_TABLE_SCROLL'>";
	echo "<table id='dataTable' class='TABLE_SCROLL  CL_TABLE_BORDERED  CL_ROW_CENTERED'>";
	echo "<thead>";

	echo $HEADER_ROW;

	echo "</thead>
		  <tbody>";

	echo $TR_BLOCK1;
	echo $TR_BLOCK2;
	
	echo "</tbody>
		</table>";

	echo "<br><br>";
	echo "</div>";
	echo "<br><br>";
	
	$mysqli1->close();
	$mysqli2->close();

//echo '<pre>'; print_r($ARR_PRODUCT_FLAG); echo '</pre>';
?>
	

<?php echo $footer2; ?>
			
<?php echo $bottomlink; ?>
<?php echo $bottomlink2; ?>



<div style="position: fixed; height: 120px; width: 200px; z-index: 1812; bottom: 10px; left: 50px;" id="DIV_PB_SAVE">
	<input id="pb_save" class="w3-button  w3-green w3-hover-purple w3-xlarge" type="button" title="Save" value="Save" onclick="fn_Addon_Multiple_SaveWork()"/>
</div>



<script>
	
	

function fn_initMultipleAddonDate()
{
	var date = document.getElementById("tdate").value;
	if ( date.length > 0 )
	{
		tempAlert("Kindly check the Date and Shift");
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = false;
		}
	}
	else
	{
		alert("Kindly enter the date");
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = true;
		}
	}
}

	




	
	
function fn_Addon_Multiple_SaveWork()
{
	document.getElementById("pb_save").value = "Saving... ";

	var subdepartmentid = document.getElementById("subdepartmentid").value;
	var shiftid = document.getElementById("shiftid").value;

	var v_tdate = document.getElementById("tdate").value;

	var records = '';
	var pcounter = 0;
	var rows = document.getElementsByClassName("CL_NOU")	
	for (var i = 0; i < rows.length; i++) 
	{
		var x1 =   rows[i].getAttribute("data-employeeid");
		x1 = +x1;

		//alert("employeeid " + x1);
		var enou =   rows[i].getAttribute("data-enou");
		enou = +enou;
		
		var periodid =   rows[i].getAttribute("data-periodid");
		periodid = +periodid;
		
		
		var y1 =  rows[i].value; 
		y1 = +y1;

		var productid =  0;
		var machineid =  0;

		var addonid =  rows[i].getAttribute("data-addonid");
		addonid = +addonid;

		if (x1 > 0)
		{
			//alert("x1 - " + x1);
			if (y1 > 0)
			{
				records = myTrim(records) + 'AA'  + '##$##' + x1 + '##$##' + y1  + '##$##' + productid  + '##$##' + machineid  + '##$##' + addonid  + '##$##' + enou + '##$##' + periodid + '##$##'  + "---------------" + '##$##' +  'AA' + '$$#$$';
				pcounter++;
			}
			else
			{
				if (enou > 0)
				{
					records = myTrim(records) + 'AA'  + '##$##' + x1 + '##$##' + y1  + '##$##' + productid  + '##$##' + machineid  + '##$##' + addonid  + '##$##' + enou + '##$##' + periodid + '##$##'  + "---------------" + '##$##' +  'AA' + '$$#$$';
					pcounter++;
				}
			}
		}
	}	
	records = myTrim(records);

	//alert(records);

	if (pcounter > 0)
	{
		null;
	}
	else
	{
		alert("Atleast one entry is required");
		document.getElementById("pb_save").value = "Save";
		return;
	}

//	alert(records);
	//records = encodeURIComponent(records);
	//alert(records);

	var subdepartmentid = document.getElementById("subdepartmentid").value;
	var v_tdate = document.getElementById("tdate").value;



	var data = new FormData();
	data.append("action", "SAVE");
	data.append("subdepartmentid", document.getElementById("subdepartmentid").value);
	data.append("shiftid", document.getElementById("shiftid").value);
	data.append("tdate", document.getElementById("tdate").value);
	data.append("records", records);

	let fetchRes = fetch("t_sdept_addon_multiple_save.php", {method: "POST",body: data});				
	fetchRes.then(res=>res.json()).then(d=>{
	
		var result = d;
		if (result[0] == "SUCCESS")
		{
			//alert("Success" + d);
			window.location.reload();
		}
		else
			alert("Error" + d);
		
		document.getElementById("pb_save").value = "Save";
	});
}


sessionStorage.setItem("SHOWCONFIRM", "TRUE");

function fn_changeMultipleAddonDate()
{
	var date = document.getElementById("tdate").value;
	if ( date.length > 0 )
	{
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = false;
		}
		
		if (document.getElementById("tdate").defaultValue == document.getElementById("tdate").value)	
			null;
		else
		{
			if (sessionStorage.getItem("SHOWCONFIRM") == "TRUE")	
			{
				if (confirm("Sure to change Date!  Going to relaod the page") == true) 
				{
					sessionStorage.setItem("SHOWCONFIRM", "FALSE");

					var tdate = document.getElementById("tdate").value;
					var shiftid = document.getElementById("txt_shiftid").value;

					document.getElementById("shift2").value = shiftid;		
					
					document.cookie = "CURRENT_ENTRY_DATE=" + tdate; 
					document.cookie = "CURRENT_ENTRY_SHIFT=" + shiftid; 

					document.getElementById("tdate2").value = tdate;		



					document.querySelectorAll(".SMART_LOADER").forEach(el=>el.style.opacity="1");
					document.getElementById("frm_sdept_addon_multiple_view1").submit();
				} 
				else 
				{
					return;
				}			
			}			
			else 
			{
				return;
			}			
		}
	}
	else
	{
		var cells = document.getElementsByClassName("CL_NOU"); 
		for (var i = 0; i < cells.length; i++) 
		{
			cells[i].disabled = true;
		}
	}
}



function fn_changeMultipleAddonShift()
{
	var shiftid = document.getElementById("txt_shiftid").value;
	if ( shiftid > 0 )
	{
		if (sessionStorage.getItem("SHOWCONFIRM") == "TRUE")	
		{
			if (confirm("Sure to change Shift!  Going to relaod the page" + shiftid) == true) 
			{
				sessionStorage.setItem("SHOWCONFIRM", "FALSE");

				document.getElementById("tdate2").value = document.getElementById("tdate").value;		
				document.getElementById("shift2").value = shiftid;		
				
				document.cookie = "CURRENT_ENTRY_DATE=" + tdate; 
				document.cookie = "CURRENT_ENTRY_SHIFT=" + shiftid; 

				document.querySelectorAll(".SMART_LOADER").forEach(el=>el.style.opacity="1");
				document.getElementById("frm_sdept_addon_multiple_view1").submit();
			} 
			else 
			{
				return;
			}			
		}			
		else 
		{
			return;
		}			
	}
}







	
</script>

</body>
<style>
.SMART_LOADER 
{
    -webkit-animation: load-out 1s;
    animation: load-out 1s;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

@-webkit-keyframes load-out 
{
    from {
        top: 0;
        opacity: 1;
    }

    to {
        top: 100%;
        opacity: 0;
    }
}

@keyframes load-out 
{
    from {
        top: 0;
        opacity: 1;
    }

    to {
        top: 100%;
        opacity: 0;
    }
}
</style>
</html>
