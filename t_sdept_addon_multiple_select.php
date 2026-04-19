<?php
	ob_start();
	session_start();
	require_once('sowhall.php');  
	require_once('xcode.php'); 
	require_once('url.php'); 	

	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode']; 
	
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $toplink; ?>
	<?php echo $toplink2; ?>
	<title>Addon Data Entry - Select Sub-Department</title>	
</head>

<body>

<?php echo $navbar; ?>

	<h2>Addon Data Entry - Select Sub-Department</h2> 
	<input type="text" id="txt_filter" onkeyup="fn_FilterTableRecords('txt_filter', 'TABLE_OUTPUT') " placeholder="Search.."  class="noPrint">
	<div id="DIV_UPLOAD_RESULT"></div>
	

	<div class="w3-row w3-padding">
		<table  id="TABLE_OUTPUT"  class="w3-table-all CL_TABLE_BORDERED">
			<thead>
				<tr class="CL_ROW_CENTERED" style="background-color:red; color:white; padding:15px;">
					<th>Department</th>
					<th>Sub-Department</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php					
	if ($result1 = $mysqli->query("SELECT id, fname FROM m_department  WHERE  lid = '" . $global_lid . "' order by id"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_DEPT[$obj1->id] =  $obj1->fname;
			}
			unset($result1);
		} 
	}


	// AND id IN (" . $SDEPT_IN . ")

	if ($result1 = $mysqli->query("SELECT * FROM m_subdepartment WHERE flag_addon = 1 AND lid = '" . $global_lid . "' order by id"))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$ARR_SUBDEPARTMENT_FLAG[$obj1->id] = 1;
			}
			unset($result1);
		} 
	}
	
	$sql = "SELECT id, ucode, fname, deptid FROM m_subdepartment  
				WHERE   flag_addon = 1 
					AND lid = '" . $global_lid . "' 
					AND active = '1'  
				order by deptid, nrank1, fname, id";
	
//	$sql = "SELECT id, fname, deptid FROM m_subdepartment  WHERE  lid = '" . $global_lid . "' AND active = '1' order by deptid, nrank1, fname, id";
//	echo $sql;
	if ($result1 = $mysqli->query($sql))
	{
		if ($result1->num_rows > 0)
		{
			while ($obj1 = $result1->fetch_object())
			{
				$name = str_pad($obj1->ucode,8," ",STR_PAD_LEFT) . " - " . $obj1->fname;
				
				echo '<tr><td class="w3-animate-zoom">' . $ARR_DEPT[$obj1->deptid] . '</td><td class="w3-animate-zoom">' . $name .'</td><td><a href="t_sdept_addon_multiple_view.php?subdept=' .  $obj1->id . '" class="w3-animate-zoom w3-button w3-indigo">Go...</button></td></tr>';
			}
			unset($result1);
		} 
	}
?>					
			</tbody>
		</table>					
	</div>					
					
	


<?php echo $footer2; ?>
			
<?php echo $bottomlink; ?>
<?php echo $bottomlink2; ?>

</body>
</html>
