<?php
	ob_start();
	session_start();
	require_once('sowhall.php'); 
	require_once('xcode.php'); 
	require_once('url.php'); 	

	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];

    $opt = isset($_GET['opt'])?$_GET['opt']:'0';        
    $opt = $opt + 0;

	$id2 = 0;
	unset($result1);
	if ($result1 = $mysqli->query("SELECT id, fname  FROM m_rate WHERE id = '" . $opt . "'")) 
	{
		while($obj1 = $result1->fetch_object())
		{
			$id2 = $obj1->id;
			$RATEMASTER = $obj1->fname;
		}
		$result1->close();
	}

	if ($id2 > 0)
		null;
	else
	{
		echo "Error";
		exit;
	}

	unset($result1);
	if ($result1 = $mysqli->query("SELECT id, fname  FROM m_supply WHERE id = '" . $opt . "'")) 
	{
		while($obj1 = $result1->fetch_object())
		{
			$ARR_SUPPLY[$obj1->id] = $obj1->fname;
		}
		$result1->close();
	}
	


	$sql = "INSERT IGNORE INTO l_supply_rate (supplyid, rateid) SELECT S.id, R.id FROM m_supply S, m_rate R WHERE R.id = '" . $id2 . "'";
	if ($result1 = $mysqli->query($sql))
	{
		null;
	} 
	else
	{
		printf("Connect failed B : %s\n", $mysqli->error);
		exit();
	}
	unset($result1);

	$sql = "SELECT supplyid, rate FROM l_supply_rate WHERE  rateid = '" . $id2 . "'  ORDER BY supplyid ";
	if ($result = $mysqli->query($sql)) 
	{
		while ($obj1 = $result->fetch_object()) 
		{
			$ARR_RATE[$obj1->supplyid] = $obj1->rate;
		}
		$result->close();
	}
	unset($result);
			

	$HTML = "";

	$sql = "SELECT * FROM m_supply WHERE  lid = '" . $global_lid . "' AND lcode = '" . $global_lcode . "'  ORDER BY active DESC, nrank1, fname, id ";
	//$HTML .= $sql . '<br><br>';
	if ($result = $mysqli->query($sql)) 
	{
		$HTML .= '<table id="TABLE_OUTPUT" class="w3-table-all w3_bordered w3-centered">';
		$HTML .= '<tr style="background-color:red; color: white;">
						<th>Name</th>
						<th>Rate</th>
					</tr>';

		while ($obj = $result->fetch_object()) 
		{
			$id = $obj->id;
			$sysdate1 = $obj->sysdate1;
			
			$HTML .= '<tr class="CSS_ROW">';
			$HTML .= '	<td class="w3-left-align">' . $obj->fname. '</td>';

			$HTML .= '	<td class="noPrint">';
			$HTML .= '		<input class="CSS_PRODUCT" type="hidden" id="txt_id_' . $id . '" value="' . $obj->id . '" >';
			$HTML .= '		<input class="CSS_RATE" type="number" id="txt_rate_' . $id . '" value="' . $ARR_RATE[$obj->id] . '" >';
			$HTML .= '	</td>';

			$HTML .= '</tr>';
		}
		$HTML .= '</table>';
		$result -> free_result();
	}
	$mysqli -> close();
	
	
	$HTML .= '		<input type="hidden" id="m_rate_id" value="' . $opt . '" >';
	
//	echo $HTML;
?>

<!DOCTYPE html>
<html>
<head>
	<?php echo $toplink; ?>
	<?php echo $toplink2; ?>
	<title>Link Records</title>	
</head>

<body>

<?php echo $navbar; ?>

<h2>Update <?php echo $RATEMASTER; ?> Rate Master</h2> 

<div class="w3-bar">

<?php echo $HTML; ?>

</div>	
	

<?php echo $footer2; ?>
			
<?php echo $bottomlink; ?>
<?php echo $bottomlink2; ?>



<div   style="position: fixed; left: 10px; bottom: 100px;" class="noPrint">
	<button  id="ID_NEW_PB_SAVE" class="w3-button w3-green  w3-xlarge  w3-padding-large" onclick="fnSaveRate();">Save</button>
</div>



</body>
</html>

