<?php
	ob_start();
	session_start();
	require_once('sowhall.php'); 
	require_once('url.php'); 
	require_once('so_money.php'); 


$ARR_LANG[0][0] = "";

$ARR_LANG["English"]["BILL"] = "Bill";
$ARR_LANG["English"]["BILLVIEW"] = "View";
$ARR_LANG["English"]["BILLEDIT"] = "Edit";
$ARR_LANG["English"]["BILLDELETE"] = "Delete";
$ARR_LANG["English"]["ALISTTITLE"] = "Active Bills : ";
$ARR_LANG["English"]["ILISTTITLE"] = "Inactive Bills";


$ARR_LANG["Tamil"]["BILL"] = "பில்";
$ARR_LANG["Tamil"]["BILLVIEW"] = "பார்க்க";
$ARR_LANG["Tamil"]["BILLEDIT"] = "மாற்ற";
$ARR_LANG["Tamil"]["BILLDELETE"] = "அழிக்க";
$ARR_LANG["Tamil"]["ALISTTITLE"] = "புதிய பில்கள்";
$ARR_LANG["Tamil"]["ILISTTITLE"] = "பழைய  பில்கள்";
	

	
	$ulogid = $GLOBALS['ulogid'];
	$global_lid = $GLOBALS['lid'];
	$global_lcode = $GLOBALS['lcode'];

	
	$GLOBALS['ucustid'] = 1;
	
	$WELCOME_USER = "USER";
	if (($GLOBALS['ulogid'] > 0) AND ($GLOBALS['ucustid'] > 0))
	{
		unset($result1);
		$sql = "SELECT id, fname FROM m_user  WHERE id = '" . $GLOBALS['ulogid'] . "' AND active = '1' AND rstat = '1' ORDER BY id";
		if ($result1 = $xmysqli->query($sql))
		{
			while ($obj1 = $result1->fetch_object())
			{
				$WELCOME_USER = TRIM($obj1->fname);
			}
			$result1->close();
		}
		unset($result1);
	}

$SELF["COMPANY-NAME"] = "Dashboard";	

$HTML_HOME_USER = '';
$HTML_MENU_USER = '';
//if ($GLO_ROLE_SYSTEM > 0)
if ($GLO_ROLE_ADMIN > 0)
{
	null;
}


	$HTML_HOME_USER = '
		  <a href="m_user_list.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_MANAGEUSERS">Manage Users</a>
  		  <a href="#" class="w3-bar-item w3-mobile w3-bar w3-gray" style="padding:1px !important;"></a>';
	$HTML_MENU_USER = '
		  <a href="m_user_list.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_MENU_MANAGEUSERS">Manage Users</a>
  		  <a href="#" class="w3-bar-item w3-mobile w3-bar w3-gray" style="padding:1px !important;"></a>';
  		  
  		  
	$navbar = 
	'
    <div class="SMART_INIT_PAGE_LOADER">
        <div class="SMART_CL_PAGE_LOADER"></div>
    </div>
	 <div  id="SOWW_NAVBAR" class="w3-bar w3-blue-grey noPrint" style="z-index: 10000;">
	 
		  <a href="index.php" class="w3-bar-item w3-button w3-mobile w3-hide-small noPrint" id="ID_XCODE_NAVBAR_HOME_DEFAULT">'  . $SELF["COMPANY-NAME"] .  '</a>

		  <div class="w3-dropdown-hover w3-mobile w3-hide-small noPrint">
			<button class="w3-button"><span id="ID_XCODE_NAVBAR_HOME_TRANSACTION">Transaction</span> <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
				<a href="t_device_display.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_TRANS1">Device - Display - Entry</a>
			</div>
		  </div>



		  <div class="w3-dropdown-hover w3-mobile w3-hide-small noPrint">
			<button class="w3-button"><span id="ID_XCODE_NAVBAR_HOME_MASTER">Master</span> <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
				<a href="m_device_list.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_DEVICE">Device</a>
				<a href="m_user_list.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_USER">User</a>
			</div>
		  </div>

		  <div class="w3-dropdown-hover w3-mobile w3-hide-small noPrint">
			<button class="w3-button"><span id="ID_XCODE_NAVBAR_HOME_REPORT">Reports</span> <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
				<a href="log_device_display.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_STMT_REPORT1">Display Log</a>
			</div>
		  </div>

		  <div class="w3-dropdown-hover w3-mobile w3-hide-small noPrint">
			<button class="w3-button"><span style="color:white;">&#129333;</span> ' . $WELCOME_USER . '<i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
			' . $HTML_HOME_USER . '
<!--			  <a href="mdsettings.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_SETTINGS">Settings</a>
			  <a href="#" class="w3-bar-item w3-mobile w3-bar w3-gray" style="padding:1px !important;" ></a>-->
			  <a href="alterpass.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_CHANGE_PASSWORD">Change Password</a>
			  <a href="#" class="w3-bar-item w3-mobile w3-bar w3-gray" style="padding:1px !important;" ></a>
			  <a href="#" onclick="fnLogout();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_LOGOUT">Logout</a>
			</div>
		  </div>
		  


		<a href="#"  onclick="FullScreen();" class="w3-bar-item w3-button w3-mobile  w3-right w3-hide-small noPrint">&#9713;</a>
		
		 <!-- 
		<div class="w3-dropdown-hover w3-mobile  w3-hide-small w3-right noPrint">
			<button class="w3-button">A அ <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
			  <a href="#" onclick="fn_app_lang_set(2);" class="w3-bar-item w3-button w3-mobile">English</a>
			  <a href="#" onclick="fn_app_lang_set(1);" class="w3-bar-item w3-button w3-mobile">தமிழ்</a>
			</div>
  	   </div>		  
  -->
		<a href="javascript:void(0)" class="w3-bar-item w3-button w3-left w3-hide-large w3-hide-medium" onclick="fn_MinNavbar();">'  . $SELF["COMPANY-NAME"] .  '</a>	  
		<a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="fn_MinNavbar();">&#9776;</a>	  

	</div>


	
	
	<div id="NAVBAR_MOBILE" class="w3-bar-block w3-blue-grey noPrint w3-hide w3-hide-large w3-hide-medium">


		  <div class="w3-dropdown-hover w3-mobile noPrint">
			<button class="w3-button"><span id="ID_XCODE_NAVBAR_MENU_TRANSACTION">Transaction</span> <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
				<a href="t_device_display.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_TRANS1">Device - Display - Entry</a>
			</div>
		  </div>

		  <div class="w3-dropdown-hover w3-mobile noPrint">
			<button class="w3-button"><span id="ID_XCODE_NAVBAR_MENU_MASTER">Master</span> <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
				<a href="m_device_list.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_DEVICE">Device</a>
				<a href="m_user_list.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_USER">User</a>
			</div>
		  </div>

		  <div class="w3-dropdown-hover w3-mobile noPrint">
			<button class="w3-button"><span id="ID_XCODE_NAVBAR_MENU_REPORT">
				Reports
			</span> <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
				<a href="log_device_display.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_HOME_STMT_REPORT1">Display Log</a>
			</div>
		  </div>




	  <div class="w3-dropdown-hover w3-mobile noPrint">
		<button class="w3-button"><span style="color:white;">&#129333;</span> ' . $WELCOME_USER . '<i class="fa fa-caret-down"></i></button>
		<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
			' . $HTML_MENU_USER . '
<!--		  <a href="mdsettings.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_MENU_SETTINGS">Settings</a>
  		  <a href="#" class="w3-bar-item w3-mobile w3-bar w3-gray" style="padding:1px !important;"></a>-->
		  <a href="alterpass.php" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_MENU_CHANGE_PASSWORD">Change Password</a>
  		  <a href="#" class="w3-bar-item w3-mobile w3-bar w3-gray" style="padding:1px !important;"></a>
		  <a href="#" onclick="fnLogout();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_NAVBAR_MENU_LOGOUT">Logout</a>
		</div>
	  </div>

<!--	  
		<div class="w3-dropdown-hover w3-mobile noPrint">
			<button class="w3-button">A அ <i class="fa fa-caret-down"></i></button>
			<div class="w3-dropdown-content w3-bar-block w3-dark-grey">
			  <a href="#" onclick="fn_app_lang_set(2);" class="w3-bar-item w3-button w3-mobile">English</a>
			  <a href="#" onclick="fn_app_lang_set(1);" class="w3-bar-item w3-button w3-mobile">தமிழ்</a>
			</div>
  	   </div>		  
	-->  
		<a href="#"  onclick="FullScreen();" class="w3-button w3-mobile  noPrint">&#9713;</a>

	</div>
	
	
	';
  		  
  		  
  		  
	

	$toplink =  
	'

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" content="diskplay.live">
	<meta name="keywords" content="diskplay.live">
	<meta name="author" content="Harshitha">

	<link rel="stylesheet" href="w3.css">
    <link rel="icon"  type="image/png" href="images/logo-light-icon.png">

	';
	
	
	$toplink2 = 
	'
	<link rel="stylesheet" href="soww.css">  
	';
	
	
	
	
	if ($GLOBALS['planid'] == 26)
		$footer2 = 
		'
		<div class="w3-content w3-section CL_NO_PRINT" style="max-width:500px; border: 1px solid #f2f2f2; display:none;">
			<div class="w3-content w3-section CL_NO_PRINT" style="max-width:500px">
			</div>
			<div style="width:100%; text-align: right; color:grey; display:none;">
			</div>
		<br>
		</div>
		';
	else if ($GLOBALS['planid'] == 27)
		$footer2 = 
		'
		<div class="w3-content w3-section CL_NO_PRINT" style="max-width:500px; border: 1px solid #f2f2f2; display:none;">
			<div class="w3-content w3-section CL_NO_PRINT" style="max-width:500px">
			</div>
			<div style="width:100%; text-align: right; color:grey;">
			</div>
		<br>
		</div>

		<div class="w3-container CL_NO_PRINT" style="width:100%; text-align:center; display:none;">
			<br><br>
			<img src="images/logo-sm.png">
			<br>
		  <div class="w3-tag w3-round w3-green" style="padding:3px;">
			<div class="w3-tag w3-round w3-green w3-border w3-border-white">
			  Support : info@soww.in (Mon-Fri: 10:00 am to 5:00 pm)
			</div>
		  </div>
		<br>
		</div>
		';
	else
		$footer2 = 
		'
		<div class="w3-container CL_NO_PRINT" style="width:100%; text-align:center; display:none;">
			<br><br>
			<img src="images/logo-sm.png">
			<br>
		  <div class="w3-tag w3-round w3-green" style="padding:3px;">
			<div class="w3-tag w3-round w3-green w3-border w3-border-white">
			  Support : info@soww.in (Mon-Fri: 10:00 am to 5:00 pm)
			</div>
		  </div>
		<br>
		</div>
		';
	

	$footer2 .= '


		<div id="DIV_SMARTMSG_IMP" class="CL_NO_PRINT" style="display:none;">                       				
			<!--Support : info@soww.in (Mon-Fri: 10:00 am to 5:00 pm)-->
		</div>                       				

		<div id="DIV_SMARTMSG" class="CL_NO_PRINT" style="display:none;">                       				
		</div>                       				

		<div id="DIV_PROMO" class="CL_NO_PRINT" style="display:none;">                       				
		</div>                       				
		
		<div class="CL_NO_PRINT">
			<br><br><br><br><br><br><br><br><br><br><br><br>
		</div>
	
	
	
		<div id="WAIT_LOADING" class="WAIT_LOADING" style="display:none;">
			<img src="loading.gif" style="width:120px; height:auto;"/>
			Contacting Server...Wait...
		</div>
	
	
	
		<div id="SOWW_FOOTER" class="w3-bottom noPrint">

		  <div class="w3-bar  w3-red w3-display-container ">
				<div class="w3-container w3-cell w3-mobile CL_SM_HIDE">
<!--					Renewal Payment Awaited. Amount : ₹28,320. Due date: 31/05/2025-->
				</div> 		  
		  </div>
		
		  <div class="w3-bar  w3-blue-grey w3-display-container ">
		  
				<div class="w3-container w3-cell w3-mobile CL_SM_HIDE">
					<a href="#" class="w3-bar-item w3-button w3-mobile">' . $SELF["COMPANY-NAME"] . '</a>
				</div>
				<div class="w3-container w3-cell w3-mobile w3-display-middle">
					<a href="#" onclick="fn_jpg();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_FOOTER_IMAGE">Image</a>
					<a href="#" onclick="fn_pdf();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_FOOTER_PDF">Pdf</a>
					<a href="#" onclick="fn_csv();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_FOOTER_CSV">Excel</a>
					<a href="#" onclick="document.getElementById(\'Window_Modal_Help\').style.display=\'block\'; fn_help_view();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_FOOTER_HELP">Help</a>
					<a href="#" onclick="fnShare();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_FOOTER_SHARE" style="display:none;">Share</a>
					<a href="#" onclick="window.print();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_FOOTER_PRINT">Print</a>
					<a href="#" onclick="location.reload();" class="w3-bar-item w3-button w3-mobile"  id="ID_XCODE_FOOTER_REFRESH">Refresh</a>
				</div>
				<div class="w3-container w3-cell w3-mobile w3-display-right CL_SM_HIDE">
					<a href="#" class="w3-bar-item w3-button w3-mobile">Smartoffice</a>		  
				</div> 		  
		  
		  </div>
		</div> 	';
		
		
if ($GLO_ROLE_ADMIN > 0)
{
	$footer2 .= '		
		<!-- HELP - The Modal - START -->
		<div id="Window_Modal_Help" class="w3-modal noPrint">
		  <div class="w3-modal-content">
			<div class="w3-container">
			  <span onclick="document.getElementById(\'Window_Modal_Help\').style.display=\'none\'"  class="w3-button w3-display-topright">&times;</span>
			  <p>
				<div class="w3-card-4">
					<header class="w3-container w3-indigo">
						<h1>Help</h1>
					</header>
					<div class="w3-container">
						Contact Admin for more help.
						<div id="VIEW_HELP">
						</div>
						<br><br>
						<div id="ADD_HELP" style="border: 1px solid grey; padding:10px; margin:10px; font-size:90%;"> 
							Add Help
							<form id="AddHelpForm">
								<table class="table table-striped table-bordered table-hover">
									<tr><td>Question</td><td><input placeholder="Question" type="text"  style="display:table-cell; width:100%" name="txt_help_question" id="txt_help_question" value="" ></td></tr>
									<tr><td>Answer</td><td><textarea placeholder="Answer" type="text"  style="display:table-cell; width:100%" name="txt_help_answer" id="txt_help_answer" value="" ></textarea></td></tr>
								</table>
							</form>
							<p class="w3-rest w3-right-align">
								<button type="button" class="w3-button w3-indigo w3-hover-blue" onclick="fn_help_add();">Add Help</button>
							</p>
						</div>
					</div>
					<footer class="w3-container w3-indigo">
						<button onclick="document.getElementById(\'Window_Modal_Help\').style.display=\'none\'"  class="w3-button">Close window</button>
					</footer>
				</div> 		  
			  </p>
			</div>
		  </div>
		</div>
		<!-- HELP - The Modal - END -->
	';
}
else
{
	$footer2 .= '		
		<!-- HELP - The Modal - START -->
		<div id="Window_Modal_Help" class="w3-modal noPrint">
		  <div class="w3-modal-content">
			<div class="w3-container">
			  <span onclick="document.getElementById(\'Window_Modal_Help\').style.display=\'none\'"  class="w3-button w3-display-topright">&times;</span>
			  <p>
				<div class="w3-card-4">
					<header class="w3-container w3-indigo">
						<h1>Help</h1>
					</header>
					<div class="w3-container">
						Contact Admin for more help.
						<div id="VIEW_HELP">
						</div>
						<div id="ADD_HELP">
						</div>
					</div>
					<footer class="w3-container w3-indigo">
						<button onclick="document.getElementById(\'Window_Modal_Help\').style.display=\'none\'"  class="w3-button">Close window</button>
					</footer>
				</div> 		  
			  </p>
			</div>
		  </div>
		</div>
		<!-- HELP - The Modal - END -->
	';
}	
	
	
	
	
	
	$bottomlink	= 
	'
	<script src="w3.js"></script>  

	<script src="html2canvas.js"></script>
	<script src="html2pdf.js"></script>
	<script src="soww.js?x=' . rand(0,100) . '"></script>  
	
	
	
     ';	
     
     
	$bottomlink2 = 	'	<script src="soww.js"></script>  	';

	$bottomlink2 = 	'		';
	
	$GLOBAL_ORG = $SELF["COMPANY-NAME"];




/*

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
  Your Content For Load Screen
</div>


<style>
.SMART_LOADER {
    -webkit-animation: load-out 1s;
    animation: load-out 1s;
    -webkit-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
}

@-webkit-keyframes load-out {
    from {
        top: 0;
        opacity: 1;
    }

    to {
        top: 100%;
        opacity: 0;
    }
}

@keyframes load-out {
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

*/	


?>
