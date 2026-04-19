<?php
	ob_start();
	session_start();
	require_once('sowhall.php'); 
	require_once('xcode.php'); 
	require_once('url.php'); 	

	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];

	$action = isset($_POST['action']) ? $_POST['action'] : 'NULL';

	$SQL_WHERE = "  WHERE  (lid = '" . $global_lid . "') AND (lcode = '" . $global_lcode . "')   AND (ulogid = '" . $ulogid . "')  ";
	
	if ($action == "SELECT")
	{
		$content_like = isset($_POST['content_like']) ? $_POST['content_like'] : 'NULL';


		if (($content_like == "Content Like") || ($content_like == "NULL") || ($content_like == ""))
		{
			$SQL_WHERE = "  WHERE  (lid = '" . $global_lid . "') AND (lcode = '" . $global_lcode . "')   AND (ulogid = '" . $ulogid . "')  ";
		} 
		else
		{
			$SQL_WHERE = "  WHERE  (lid = '" . $global_lid . "') AND (lcode = '" . $global_lcode . "')   AND (ulogid = '" . $ulogid . "')  AND (( scode LIKE '%" . $content_like . "%' ) OR ( tvalue1 LIKE '%" . $content_like . "%' ) )";
		}
	}


	if (isset($content_like))
		null;
	else
		$content_like = '';
		
		

	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];

	$sql = "INSERT IGNORE INTO sys_self 
				(lid, lcode, ulogid, scode, tvalue1) 
				SELECT '" . $global_lid . "' AS lid, '" . $global_lcode . "' AS lcode, '"  . $ulogid . "' AS ulogid, scode, tvalue1 
				FROM sys_self_model";
						

	$MSG = "HAI";
	if ( $stmt2 = $mysqli->prepare($sql) )
	{
		if ( $stmt2->execute() )
		{
			$stmt2->close();
			$MSG = "HAI 2";
		}
		else
			$MSG = "HAI 3";
		
	}
	else
		$MSG = "HAI 4 <br>" . $mysqli->error . "<br>" . $sql;
				

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/png" href="favicon.png" />
	<title>Smartoffice</title>
	
	<?php 
		echo $toplink; 
		echo $toplink2; 
	?>

	<style>
		.no-spin::-webkit-inner-spin-button, .no-spin::-webkit-outer-spin-button {
			-webkit-appearance: none !important;
			margin: 0 !important;
			-moz-appearance:textfield !important;
		}        
		input.no-spin[type=number] {
			-moz-appearance:textfield;
		}	
	</style>

	<script>
		
		function updateDSettings(action)
		{
			var data = new FormData();
			data.append("action", action);
			data.append("arg_id", document.getElementById("udsettings_id").value);
			data.append("arg_scode", document.getElementById("udsettings_scode").value);
			data.append("arg_tvalue1", document.getElementById("udsettings_tvalue1").value);
			
			let fetchRes = fetch("mdsettingsm.php", {method: 'POST',body: data});				
			fetchRes.then(res=>res.json()).then(d=>{
				
				var result = d;
				if (result[0] == "SUCCESS")
					window.location.reload();
				else
					alert("Error" + d);
				
			});
		}


		function fnFillForm(recid)
		{
			document.getElementById('udsettings_id').value = recid;
			document.getElementById('udsettings_scode').value = document.getElementById('TD_SCODE_' + recid).value;
			document.getElementById('udsettings_tvalue1').value = document.getElementById('TD_TVALUE1_' + recid).value;
			document.getElementById('Window_Modal_Update').style.display='block';
			
			if (document.getElementById('TD_FTYPE_' + recid).value == "font")
			{
				document.getElementById('udsettings_tvalue1').type = "text";
				document.getElementById('udsettings_tvalue1').setAttribute('list','FontList');
			}
			else
			{
				document.getElementById('udsettings_tvalue1').type = document.getElementById('TD_FTYPE_' + recid).value;
			}
			    
		}

		var LS_CUR_PAGE = "MDSETTINGS";

		
	</script>

</head>
<body>
	<?php echo $navbar; ?>
	<form  class="form-inline" role="form" action="mdsettings.php" method="POST"  class="CL_CSV CL_NO_PRINT">
		<input type="hidden" id = "action" name="action" value="SELECT">
			<table class="table borderless CL_CSV CL_NO_PRINT">
				<tr>
					<td><a href="index.php" class="w3-button w3-blue-grey  w3-hover-deep-orange">Dashboard</a></td>
					<td><a href="tentry_list.php" class="w3-button  w3-blue-grey  w3-hover-deep-orange">Bill List</a></td>
					<td><input type="text" class="form-control" id="content_like" name="content_like" placeholder="Search" title="Narrow your records with title or content looks like this text" value="<?php echo $content_like; ?>"></td>
					<td><input type="submit" class="w3-button w3-blue" value="Refresh Records"/></td>
				</tr>
			</table>
	</form>
	


	<!-- UPDATE - The Modal - START -->
	<div id="Window_Modal_Update" class="w3-modal noPrint">
	  <div class="w3-modal-content">
		<div class="w3-container">
		  <span onclick="document.getElementById('Window_Modal_Update').style.display='none'"  class="w3-button w3-display-topright">&times;</span>
		  <p>
			<form id="UpdateForm">
				<input type="hidden" name="udsettings_id" id="udsettings_id" value="">
				<table class="table borderless CL_CSV CL_NO_PRINT">
					<tr><td><input  disabled placeholder="Name" type="text"  style="display:table-cell; width:100%" name="udsettings_scode" id="udsettings_scode" value=""></td></tr>
					<tr><td>
						<input type="text" placeholder="Details"  style="display:table-cell; width:100%" name="udsettings_tvalue1" id="udsettings_tvalue1">
						
<datalist id="FontList">
    <option value="Times New Roman, Times, serif">
    <option value="Georgia, serif">
    <option value="Garamond, serif">
    <option value="Arial, Helvetica, sans-serif">
    <option value="Trebuchet MS, Helvetica, sans-serif">
    <option value="Geneva, Verdana, sans-serif">
    <option value="Courier New, Courier, monospace">
    <option value="Brush Script MT, cursive">
</datalist>						
					</td></tr>
					<tr><td><button type="button" class="w3-button w3-green" onclick="updateDSettings('UPDATE');">UPDATE</button></td></tr>
				</table>
			</form>
		  </p>
		</div>
	  </div>
	</div>
	<!-- UPDATE - The Modal - END -->


	<table id='TABLE_DSETTINGS' class='w3-table-all TABLE_DSETTINGS'>
	
<?php	
	$sql = "SELECT * FROM m_ftype WHERE 1 ORDER BY id ";
	if ($result = $mysqli->query($sql)) 
	{
		while ($obj = $result->fetch_object()) 
		{
			$ARR_FTYPE[$obj->id] = $obj->ucode;
		}
	}


	$sql = "SELECT * FROM sys_self_model WHERE 1 ORDER BY id ";
	if ($result = $mysqli->query($sql)) 
	{
		while ($obj = $result->fetch_object()) 
		{
			$ARR_FTYPE_CODE[$obj->scode] = $obj->ftype;
			$ARR_FTYPE_ID[$obj->id] = $obj->ftype;
		}
	}


	$ROW = "<thead>
				<tr style='vertical-align: middle; background-color:red; color:white; text-align:center;'>
					<th>Name</th>
					<th>Details</th>
					<th>Action</th>
				</tr>
			</thead>";
	echo $ROW;


	$slno = 1;
	echo "<tbody>";


	$sql = "SELECT  id, scode, tvalue1 FROM sys_self " . $SQL_WHERE . " ORDER BY scode, id";
	if ($result = $mysqli->query($sql))
	{
		if ($result->num_rows > 0)
		{
			while ($row = $result->fetch_object())
			{
				$dsettingsid = $row->id;
				$scode = $row->scode;
				$tvalue1 = $row->tvalue1;

				$ROW = "<tr class='TR_ROW'>";

				$ROW .= "<td>". $scode . "</td>";

				$ROW .= "<td>". $tvalue1 . "</td>";
				
                
				$ROW .= "<td  style='white-space:nowrap;'>
							<button type='button' class='w3-button w3-green'  data-toggle='modal' data-target='#Window_DSettings_Update' onclick='fnFillForm(" . $dsettingsid . ");'>Edit</button>
							<input type='hidden'  id='TD_SCODE_" . $dsettingsid . "' value='" . $scode . "'>
							<input type='hidden'  id='TD_TVALUE1_" . $dsettingsid . "' value='" . $tvalue1 . "'>
							<input type='hidden'  id='TD_FTYPE_" . $dsettingsid . "' value='" . $ARR_FTYPE[$ARR_FTYPE_CODE[$scode]] . "'>
							<input type='hidden'  id='TD_FTYPE1_" . $dsettingsid . "' value='" . $ARR_FTYPE_CODE[$scode] . "'>
							<input type='hidden'  id='TD_FTYPE2_" . $dsettingsid . "' value='" . $scode . "'>
						</td>";
						
						
				$ROW .= "</tr>";
				echo $ROW;
				
				
            }
        }
        else
		{
			printf("No settings found");
		}
    }
    
    
	echo "</tbody>";
	echo "</table>";
	echo '</div>';
	$mysqli->close();
	

//echo $MSG;		

	

echo $footer2; 

echo $bottomlink; 
echo $bottomlink2; 

?>

	</div>                       				
	
</body>
</html>

        
        
        
