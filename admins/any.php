<?php
session_start();
if(isset($_SESSION['name']))
{  
   $pageTitle="dashboard";
   include "init.php";
   echo "welcome";
   include $passtpl."footer.php";

}
else {
header('location:index.php');
exit();
}
?>