<?php
	ob_start();
	session_start();
	require_once('sowhall.php'); 
	require_once('xcode.php'); 

	if(count($_POST)>0) 
	{
		$userName = $_POST["userName"];
		if (!(ctype_alnum ($_POST["newPassword"])))
		{
			$message = "Error 2 ";
		}
		else
		{
			if (strlen($_POST["newPassword"]) < 5)
			{
				$message = "Error 3 - Min 5 chars Max 9 chars ";
			}
			else
			{
				$tsql = "SELECT lpassword from m_user WHERE mobile='" . $userName . "'  AND id='" . $GLOBALS['ulogid'] . "'";
			//	$message = $tsql;
				$result = $xmysqli->query($tsql);

				$row = mysqli_fetch_array($result);
				if(trim($_POST["currentPassword"]) == trim($row["lpassword"])) 
				{
					$usql = "UPDATE m_user set lpassword='" . $_POST["newPassword"] . "' WHERE mobile='" . $userName . "'  AND id='" . $GLOBALS['ulogid'] . "'";
					if ($xmysqli->query($usql))
						$message = "Password Changed";
					else
						$message = "Error in database";
				} 
				else
				{ 
					$message = "Current Name / Password is not correct";
				}
			}
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/png" href="favicon.png" />
	<title>Change Password</title>
	<?php echo $toplink; ?>
	<script>
		function validatePassword() 
		{
			var currentPassword, newPassword, confirmPassword, output = true;
			
			currentPassword = document.frmChange.currentPassword;
			newPassword = document.frmChange.newPassword;
			confirmPassword = document.frmChange.confirmPassword;
			userName = document.frmChange.userName;
			
			if(!currentPassword.value) 
			{
				currentPassword.focus();
				document.getElementById("currentPassword").innerHTML = "required";
				output = false;
			}
			else if(!userName.value) 
			{
				userName.focus();
				document.getElementById("userName").innerHTML = "required";
				output = false;
			}
			else if(!newPassword.value) 
			{
				newPassword.focus();
				document.getElementById("newPassword").innerHTML = "required";
				output = false;
			}
			else if(!confirmPassword.value) 
			{
				confirmPassword.focus();
				document.getElementById("confirmPassword").innerHTML = "required";
				output = false;
			}
			if(newPassword.value != confirmPassword.value) 
			{
				newPassword.value="";
				confirmPassword.value="";
				newPassword.focus();
				document.getElementById("confirmPassword").innerHTML = "not same";
				output = false;
			} 	
			return output;
		}
		
		var LS_CUR_PAGE = "ALTERPASS";
		
		
	</script>                
	
        
</head>
<body>
	<?php echo $navbar; ?>
	
	
	
	<?php 
		if ($GLOBALS['flagdemo'] == 1)
			$DISABLED = "DISABLED"; 
		else
			$DISABLED = ""; 
	
	?>
	
	
		
		
	<div class="w3-container">
		<div class="w3-display-middle">
			<div class="w3-animate-top">
				
				<div class="w3-card-4">
					<div class="w3-container w3-blue">
						<h3>Change Password</h3>
					</div>				
								

					<form name="frmChange" method="post" action="alterpass.php" onSubmit="return validatePassword()" style="z-index: 10000;">
						<div style="width:500px;">
							<div class="message"><?php if(isset($message)) { echo $message; } ?></div>
							<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
								<tr>
									<td><input class="w3-input w3-animate-left" placeholder="User Name" type="text" name="userName" class="txtField"/><span id="userName"  class="required"></span></td>
								</tr>
								<tr>
									<td><input class="w3-input w3-animate-left" placeholder="Current Password"  type="password" name="currentPassword" class="txtField"/><span id="currentPassword"  class="required"></span></td>
								</tr>
								<tr>
									<td><input class="w3-input w3-animate-left" placeholder="New Password" type="password" name="newPassword" class="txtField"/><span id="newPassword" class="required"></span></td>
								</tr>
									<td><input class="w3-input w3-animate-left" placeholder="Confirm New Password"  type="password" name="confirmPassword"/><span id="confirmPassword" class="required"></span></td>
								</tr>
								<tr>
									<td><input type="submit" <?php echo $DISABLED; ?>  class="w3-button w3-section w3-blue w3-ripple" name="submit" value="Submit" class="btnSubmit"></td>
								</tr>
							</table>
						</div>
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

		
	<br><br><br><br><br><br><br><br><br><br><br><br>	
	<br><br><br><br><br><br><br><br><br><br><br><br>	
		
		
		
		
		
		
		
	<?php echo $footer2; ?>

	<?php echo $bottomlink; ?>

	<script>                
		<?php echo "var msg = '" . $message . "';"; ?>		
		if (msg == "Password Changed")
			location.reload();
	</script>                

</body>
</html>

