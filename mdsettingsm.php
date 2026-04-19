<?php
	ob_start();
	session_start();
	require_once('sowhall.php'); 
	require_once('xcode.php'); 
	require_once('url.php'); 	

	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];

    $action = isset($_POST['action'])?$_POST['action']:'NULL';        
    $id = isset($_POST['arg_id'])?$_POST['arg_id']:'NULL';        
    $scode = isset($_POST['arg_scode'])?$_POST['arg_scode']:'NULL';        
    $tvalue1 = isset($_POST['arg_tvalue1'])?$_POST['arg_tvalue1']:'NULL';        

    if (($action == "NULL") OR ($id == "NULL") OR ($scode == "NULL")) 
    {
			echo json_encode(array("ERROR", "FALSE", "Error - Invalid Entry"));
            exit;
    }        
    if (!($action == "UPDATE"))
    {
			echo json_encode(array("ERROR", "FALSE", "Error - Invalid Entry 2"));
            exit;
    }        
    if ($stmt2 = $mysqli2->prepare("UPDATE sys_self SET tvalue1 = ? WHERE id  = ?  AND lid = ? AND lcode = ? AND ulogid = ?"))
    {
            $stmt2->bind_param("sdddd", $tvalue1, $id, $global_lid, $global_lcode, $ulogid); 
            if ($stmt2->execute())
            {
				echo json_encode(array("SUCCESS", "TRUE", "OK"));
				exit;
		    }
		    else
		    {
				echo json_encode(array("ERROR", "FALSE", "Error - 7" . $mysqli2->error));
				$stmt2->close();
				exit;
		    }
				
    }
    else
    {
		echo json_encode(array("ERROR", "FALSE", "Error - 10"));
		exit;
    }

	echo json_encode(array("ERROR", "FALSE", "Error - 99"));
?>

