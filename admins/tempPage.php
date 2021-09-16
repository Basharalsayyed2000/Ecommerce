<?php
ob_start();
// you can manage catagories 
session_start();

$pageTitle=""; // page title variable , will print using function

// to check the user

if(isset($_SESSION['name']))
{  
   include "init.php";

   $do='';

  if(isset($_GET['do'])){
    $do=$_GET['do'];
  }
  else{
    $do='Manage';
  }
  if($do=='Manage'){  //Manage page
  
  }
  else if($d0=='Add'){

} else if($d0=='Insert'){

} else if($d0=='Edit'){

}else if($d0=='Update'){

}
else if($d0=='Delete'){

}else if($d0=='Activate'){

}
include $passtpl."footer.php";
}
else {
header('location:index.php');
exit();
}
ob_end_flush();
?>