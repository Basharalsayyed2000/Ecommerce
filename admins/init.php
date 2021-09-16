<?php
//routes
$passtpl="includes/templates/"; //tempalate folder directory in admin
$passfunc="includes/functions/"; //function folder directory in admin
$passcss="design/css/";  // css folder directory in admin
$passjs="design/js/";   //js folder directory in admin
$passlang="includes/languages/";//languages directory in admin

//include the important files
include $passfunc."function.php";
include "connection.php";
include $passlang."english.php";
include $passtpl."header.php";
 if(!isset($noNavBar)){
 include $passtpl."navbar.php";
 }

?>