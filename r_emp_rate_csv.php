<?php
	ob_start(); 
	session_start();
	require_once('sowhall.php'); 
	require_once('xcode.php'); 
	require_once('url.php'); 	
 
	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];
	
	if ($result1 = $mysqli->query("SELECT id, ucode, fname FROM m_product WHERE  lid = '" . $global_lid . "' AND active = '1' order by id"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_PRODUCT[$obj1->id] =  $obj1->fname;
				$ARR_PRODUCT_CODE[$obj1->id] =  $obj1->ucode;
			}
			unset($result1);
		} 
	}

	if ($result1 = $mysqli->query("SELECT id, ucode, fname FROM m_process WHERE  lid = '" . $global_lid . "' AND active = '1' order by id"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_PROCESS[$obj1->id] =  $obj1->fname;
				$ARR_PROCESS_CODE[$obj1->id] =  $obj1->ucode;
			}
			unset($result1);
		} 
	}

	if ($result1 = $mysqli->query("SELECT id, ucode, fname FROM m_machine WHERE  lid = '" . $global_lid . "' AND active = '1' order by id"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_MACHINE[$obj1->id] =  $obj1->fname;
				$ARR_MACHINE_CODE[$obj1->id] =  $obj1->ucode;
			}
			unset($result1);
		} 
	}
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $toplink; ?>
	<?php echo $toplink2; ?>
	<title>Sub Department - Employee Rate Master</title>	
</head>

<body>

<?php echo $navbar; ?>


<?php

echo "<h1 style='color:blue;'>Employee Rate Master</h1>"; 

	$HTML_RECORDS = "";

	$sql = "SELECT id, ucode, fname FROM m_subdepartment  WHERE lid = '" . $global_lid . "' AND id IN (" . $GLO_SDEPT_IN . ") ORDER BY fname";
//	$sql = "SELECT id, fname FROM m_subdepartment";
//	echo $sql;
	if ($result_subdepartment = $mysqli->query($sql))
	{
		if ($result_subdepartment->num_rows > 0)
		{
			while ($obj_subdepartment = $result_subdepartment->fetch_object())
			{
				$subdepartmentid = $obj_subdepartment->id;
				$subdepartment_name = $obj_subdepartment->fname;
				$subdepartment_code = $obj_subdepartment->ucode;

				$flag_sdept = 0;
				$counter = 0;
			
				$HTML = "";

				$HTML .= "<tr class='w3-padding CL_ROW_CENTERED' style='background-color:red; color:white;'>
							<td colspan='10'>
								<h2>" . $subdepartment_name . " - Employee Rate Master</h2>
							</td>
						  </tr>";

				$HTML .= "<tr class='w3-padding CL_ROW_CENTERED' style='background-color:red; color:white;'>
							<td>Sub Department</td>
							<td>Code</td>
							<td>Employee</td>
							<td>Product Code</td>
							<td>Product Name</td>
							<td>Machine Code</td>
							<td>Machine Name</td>
							<td>Process Code</td>
							<td>Process Name</td>
							<td>Wages</td>
						  </tr>";

				$sql = "SELECT id, ucode, fname FROM m_employee WHERE  lid = '" . $global_lid . "' AND subdeptid = '" . $subdepartmentid .  "' AND active = '1' ORDER BY  ucode, nrank1, fname, id";
				//echo "<br><br>" . $sql;
				$MSG = "<br><br>" . $sql;
				if ($result_employee = $mysqli->query($sql))
				{
					if ($result_employee->num_rows > 0)
					{
						while ($obj_employee = $result_employee->fetch_object())
						{
							$employeeid = $obj_employee->id;
							$employee_id = $obj_employee->id;
							$employee_name = $obj_employee->fname;
							$employee_code = $obj_employee->ucode;
							
							$flag = 0;
							$Details = "";
							
							$sql = "SELECT id, productid, machineid, processid, wages FROM t_sdept_epmp WHERE lid = '" . $global_lid . "' AND employeeid = '" . $employee_id . "' order by id";
							//echo $sql;
							if ($result1 = $mysqli->query($sql))
							{
								if ($result1->num_rows > 0)
								{
									while ($obj1 = $result1->fetch_object())
									{
										if ($obj1->wages > 0)
										{
											$flag = 1;

											$HTML .= "<tr class='CL_CSV w3-padding'>
													<td class='CL_CSV'>" . $subdepartment_code . "</td>
													<td class='CL_CSV'>" . $employee_code . "</td>
													<td class='CL_CSV'>" . $employee_name . "</td>
													<td class='CL_CSV'>" . $ARR_PRODUCT_CODE[$obj1->productid] . "</td>
													<td class='CL_CSV'>" . $ARR_PRODUCT[$obj1->productid] . "</td>
													<td class='CL_CSV'>" . $ARR_MACHINE_CODE[$obj1->machineid] . "</td>
													<td class='CL_CSV'>" . $ARR_MACHINE[$obj1->machineid] . "</td>
													<td class='CL_CSV'>" . $ARR_PROCESS_CODE[$obj1->processid] . "</td>
													<td class='CL_CSV'>" . $ARR_PROCESS[$obj1->processid] . "</td>
													<td class='CL_CSV'>" . $obj1->wages . "</td>
												  </tr>";
										}
									}
									unset($result1);
								} 
							}
							if ($flag == 1)
							{
								$flag_sdept = 1;
							}
						}
					}
				}

			//	echo $MSG;
				
				if ($flag_sdept == 1)
					$HTML_RECORDS .= $HTML;
			}
			unset($result_subdepartment);
		} 
	}
		
		
	echo "<table class='CL_TABLE_BORDERED w3-table-all w3-card-4 w3-margin' style='max-width:800px;'>";
	echo $HTML_RECORDS;
	echo "</table>";

		


//echo '<pre>'; print_r($ARR_EMPLOYEE_MASTER_RATE); echo '</pre>';

	
?>
	

<?php echo $footer2; ?>
			
<?php echo $bottomlink; ?>
<?php echo $bottomlink2; ?>


</body>
</html>
