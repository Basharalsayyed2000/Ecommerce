<?php
//Error Reportin

ini_set('display_errors','On');
error_reporting(E_ALL);

$sessionUser='';
if(isset($_SESSION['usrname']))
{
    $sessionUser=$_SESSION['usrname'];
}

//routes
$passtpl="includes/templates/"; //tempalate folder directory in admin
$passfunc="includes/functions/"; //function folder directory in admin
$passcss="design/css/";  // css folder directory in admin
$passjs="design/js/";   //js folder directory in admin
$passlang="includes/languages/";//languages directory in admin

//include the important files
include $passfunc."function.php";
include "Admins/connection.php";
include $passlang."english.php";
include $passtpl."header.php";

?>