<?php
	ob_start();
	session_start();
	require_once('url.php'); 	

	$next_include = "connect-db";
	require_once('connect-db.php');

	if ($result1 = $xmysqli->query("SELECT id, lid, lcode, mobile, lpassword FROM m_user WHERE active = 1 ORDER BY id"))
	{
		while ($obj1 = $result1->fetch_object())
		{
			$id = $obj1->id;
			$value = $obj1->lpassword;
			$key = $obj1->mobile;
			$org = $obj1->lcode;
			$orgid = $obj1->lid;

			$LOGIN_INFORMATION[$key] = $value;
			$ID_INFORMATION[$key] = $id;
			$ORG_INFORMATION[$key] = $org;
			$ORGID_INFORMATION[$key] = $orgid;
		}
		$result1->close();
	}
	unset($result1);

	define('USE_USERNAME', true);
	define('EXIT_URL', 'index.php');
	define('TIMEOUT_MINUTES', 1);
	define('TIMEOUT_CHECK_ACTIVITY', true);

	
	$timeout = (TIMEOUT_MINUTES == 0 ? 0 : time() + TIMEOUT_MINUTES * 60);

	if(!function_exists('showForm')) 
	{

		function showLoginPasswordProtect($error_msg) 
		{
			?>
			<html>
			<head>
				<title>Login</title>
				<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
				<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
				<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

			</head>
			<body>
				
				<div class="w3-container">
					<div class="w3-display-middle">
						<div class="w3-animate-top">
							
							<div class="w3-card-4">
								<div class="w3-container w3-dary-gray">
								  <div style="width:100%; text-align:center;">
									  <h2 style="color:#002080;">CEG DiskPlay</h2>
								  </div>
								</div>				

											
							
								<form class="w3-container w3-card-4"  method="post">

									<font color="red"><?php echo $error_msg; ?></font><br />

									<p>
										<input class="w3-input" type="text" style="width:90%"   name="access_login" placeholder="User Name" required>
									</p>

									<p>
										<input class="w3-input" type="password" style="width:90%"  name="access_password"  placeholder="Password" required>
									</p>

									<p>
										<button class="w3-button w3-section w3-blue w3-ripple"> Log in </button>
									</p>

								</form>
								<!--
								<div class="w3-display-bottomright">
									<a href="< ?php echo $global_url; ?>/forgot_password.php">Forgot Password</a>
								</div>
								-->

							</div>	
						</div>	
					</div>	
				</div>	


				
			</body>
			</html>
			<?php
			  die();
		}
	}



	if (isset($_POST['access_password'])) 
	{
	  $login = isset($_POST['access_login']) ? $_POST['access_login'] : '';
	  $login = trim($login); 
	  $pass = $_POST['access_password'];
	  $pass = trim($pass); 
	  
//	  if (!USE_USERNAME && !in_array($pass, $LOGIN_INFORMATION) || (USE_USERNAME && ( !array_key_exists($login, $LOGIN_INFORMATION) || $LOGIN_INFORMATION[$login] != $pass ) )  ) 
	  if (!USE_USERNAME && !in_array($pass, $LOGIN_INFORMATION) || (USE_USERNAME && ( !array_key_exists($login, $LOGIN_INFORMATION) || $LOGIN_INFORMATION[$login] != $pass ) )   ) 
	  {
		showLoginPasswordProtect("Incorrect name/password.");
	  }
	  else 
	  {
        $id = $ID_INFORMATION[$login];
		$GLOBALS['ulogid'] = $id;
        
		$orgid = $ORGID_INFORMATION[$login];
		$GLOBALS['lid'] = $orgid;

		$org = $ORG_INFORMATION[$login];
		$GLOBALS['lcode'] = $org;
		
		setcookie("passwordprotectcookie", md5($login.'%'.$pass), $timeout, '/');
                

		unset($_POST['access_login']);
		unset($_POST['access_password']);
		unset($_POST['Submit']);
		
		unset($result1);
		if ($result1 = $mysqli->query("SELECT id, scode, tvalue1 FROM sys_self  WHERE active = '1' AND rstat = '1' ORDER BY id"))
		{
			while ($obj1 = $result1->fetch_object())
			{
				$id = $obj1->id;
				$scode = TRIM($obj1->scode);
				$tvalue1 = TRIM($obj1->tvalue1);
				$SELF[$scode] = $tvalue1;
			}
			$result1->close();
		}
		unset($result1);

		if ($result1 = $xmysqli->query("SELECT * FROM m_user WHERE id = '" . $GLOBALS['ulogid'] . "' AND lid = '" . $GLOBALS['lid'] . "' AND lcode = '" . $GLOBALS['lcode'] . "' AND active = 1 ORDER BY id"))
		{
			while ($obj1 = $result1->fetch_object())
			{
				$GLOBALS['planid'] = $obj1->planid;
				$GLOBALS['flagdemo'] = $obj1->flag_demo;
			}
			$result1->close();
		}
		unset($result1);
		
	
		$GLO_ROLE_SYSTEM = 0;
		$GLO_ROLE_ADMIN = 0;
		$sql = "SELECT * FROM m_user WHERE id = '" . $GLOBALS['ulogid'] . "'  AND lid = '" . $GLOBALS['lid'] . "'";
		if ($result = $mysqli->query($sql)) 
		{
			while ($obj1 = $result->fetch_object()) 
			{
				$GLO_ROLE_SYSTEM = $obj1->role_system;
				$GLO_ROLE_ADMIN = $obj1->role_admin;
			}
			$result->close();
		}
		unset($result);
	  }

	}
	else 
	{
	  if (!isset($_COOKIE['passwordprotectcookie'])) 
	  {
		showLoginPasswordProtect("");
	  }
	  $found = false;
	  foreach($LOGIN_INFORMATION as $key=>$val) 
	  {
		  
        $id = $ID_INFORMATION[$key];
		$GLOBALS['ulogid'] = $id;

		$orgid = $ORGID_INFORMATION[$key];
		$GLOBALS['lid'] = $orgid;

		$org = $ORG_INFORMATION[$key];
		$GLOBALS['lcode'] = $org;

        
		$lp = (USE_USERNAME ? $key : '') .'%'.$val;
		if ($_COOKIE['passwordprotectcookie'] == md5($lp)) 
		{
		  $found = true;
		  if (TIMEOUT_CHECK_ACTIVITY) 
		  {
			setcookie("passwordprotectcookie", md5($lp), $timeout, '/');
                        
			
			unset($result1);
			if ($result1 = $mysqli->query("SELECT id, scode, tvalue1 FROM sys_self  WHERE active = '1' AND rstat = '1' ORDER BY id"))
			{
				while ($obj1 = $result1->fetch_object())
				{
					$id = $obj1->id;
					$scode = TRIM($obj1->scode);
					$tvalue1 = TRIM($obj1->tvalue1);
					$SELF[$scode] = $tvalue1;
				}
				$result1->close();
			}
			unset($result1);
			
			if ($result1 = $xmysqli->query("SELECT * FROM m_user WHERE id = '" . $GLOBALS['ulogid'] . "' AND lid = '" . $GLOBALS['lid'] . "' AND lcode = '" . $GLOBALS['lcode'] . "' AND active = 1 ORDER BY id"))
			{
				while ($obj1 = $result1->fetch_object())
				{
					$GLOBALS['planid'] = $obj1->planid;
					$GLOBALS['flagdemo'] = $obj1->flag_demo;
				}
				$result1->close();
			}
			unset($result1);

			$GLO_ROLE_SYSTEM = 0;
			$GLO_ROLE_ADMIN = 0;
			$sql = "SELECT * FROM m_user WHERE id = '" . $GLOBALS['ulogid'] . "'  AND lid = '" . $GLOBALS['lid'] . "'";
			if ($result = $mysqli->query($sql)) 
			{
				while ($obj1 = $result->fetch_object()) 
				{
					$GLO_ROLE_SYSTEM = $obj1->role_system;
					$GLO_ROLE_ADMIN = $obj1->role_admin;
				}
				$result->close();
			}
			unset($result);
		  }
		  break;
		}
	  }
	  if (!$found) 
	  {
		showLoginPasswordProtect("");
	  }
	}
?>
