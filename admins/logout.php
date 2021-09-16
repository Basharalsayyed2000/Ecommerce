<?php
   $pageTitle="logout";
session_start(); //before destroy we need to start session 
session_unset(); // unset for data
session_destroy(); //end the session
header('location:index.php');
exit();
?>