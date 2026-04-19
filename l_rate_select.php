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
	<title>Link Records</title>	
</head>

<body>

<?php echo $navbar; ?>

<h2>Select Rate Master</h2> 

<div class="w3-bar">
<?php	

$sql = "SELECT * FROM m_rate ORDER BY nrank1, fname, id";
if ($result = $mysqli->query($sql)) 
{
	while ($obj = $result->fetch_object()) 
	{
		echo "<a href='l_rate_list.php?opt=" . $obj->id. "' class='w3-button w3-blue' style='margin:20px;'>" . $obj->fname. "</a>";
	}
}
?>
</div>	
	

<?php echo $footer2; ?>
			
<?php echo $bottomlink; ?>
<?php echo $bottomlink2; ?>



</body>
</html>
