<?php
if ($next_include == "crypt")
    null;
else
    exit;
$next_include = "";    


$xciphering = "AES-128-CTR";
$xiv_length = openssl_cipher_iv_length($xciphering);
$xoptions   = 0;
$xencryption_iv = '1234567891011121';
$xencryption_key = "QuliEncrypt12345";
$xdecryption_iv = '1234567891011121';
$xdecryption_key = "QuliEncrypt12345";




$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options   = 0;
$encryption_iv = '1234567891011121';
$encryption_key = "QuliEncrypt12345";
$decryption_iv = '1234567891011121';
$decryption_key = "QuliEncrypt12345";


?>
