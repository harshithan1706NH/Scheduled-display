<?php
    session_start();
    ob_start();

	$website = "https://diskplay.live";

	// User will be redirected to this page after logout
	define('LOGOUT_URL', $website);
	
	if(isset($_GET['logout'])) 
	{
	  setcookie("passwordprotectcookie", '', '10', '/'); // clear password;

	  session_unset();
	  session_destroy(); 
	  
	  
	  header('Location: ' . LOGOUT_URL);
	  
	  exit();
	}
	
?>
