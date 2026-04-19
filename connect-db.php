<?php
if ($next_include == "connect-db")
    null;
else
    exit;
$next_include = "";    



$xserver = 'localhost';

$xuser = 'u443307521_diskplay_us';
$xpass = 'DiskPlay.Live12#July#2024Code';
$xdb = 'u443307521_diskplay_db';


$xmysqli = new mysqli($xserver, $xuser, $xpass, $xdb);

$server = $xserver;
$user = $xuser;
$pass = $xpass;
$db = $xdb;

		$mysqli = new mysqli($server, $user, $pass, $db);
		$mysqli1 = new mysqli($server, $user, $pass, $db);
		$mysqli2 = new mysqli($server, $user, $pass, $db);
		$mysqli3 = new mysqli($server, $user, $pass, $db);
		$mysqli4 = new mysqli($server, $user, $pass, $db);


$xglo_host = 'localhost';
$xglo_user = $xuser;
$xglo_code = $xpass;
$xglo_db = $xdb;
$xglo_flag = 0;

$xglo_password = $xpass;
$xglo_dbmaster = $xdb;


$next_include = "crypt";
include_once('crypt.php');

$xserver = openssl_encrypt($xserver, $xciphering, $xencryption_key, $xoptions, $xencryption_iv);
$xuser = openssl_encrypt($xuser, $xciphering, $xencryption_key, $xoptions, $xencryption_iv);
$xpass = openssl_encrypt($xpass, $xciphering, $xencryption_key, $xoptions, $xencryption_iv);
$xdb = openssl_encrypt($xdb, $xciphering, $xencryption_key, $xoptions, $xencryption_iv);

$GLOBALS['glo_xvar1'] = $xserver;
$GLOBALS['glo_xvar2'] = $xuser;
$GLOBALS['glo_xvar3'] = $xpass;
$GLOBALS['glo_xvar4'] = $xdb;


//$GLOBALS['glo_xhost'] = "localhost";
//$GLOBALS['glo_xuser'] = $user;
//$GLOBALS['glo_xpassword'] = $pass;
//$GLOBALS['glo_xdbmaster'] = $db;
$xglo_flag = 0;

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
?>

