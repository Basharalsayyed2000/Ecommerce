<?php
// you can manage members 
session_start();

$pageTitle="Members"; // page title variable , will print using function

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
   $queryToAdd='';
   if(isset($_GET['pending'])&& $_GET['pending']=='Yes'){
     $queryToAdd="AND Regstatus=0";
   }
   $stmt=$con->prepare("select * from users where rank!=1 $queryToAdd ORDER BY userID DESC"); // select all user except admin
   $stmt->execute(); // execute statement
   $rows= $stmt->fetchAll();
   if(!empty($rows)){
?>
<h1 class="text-center">Manage Members</h1>
<div class="container">
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
    <tr>
      <td> #ID </td>
      <td> profile </td>
      <td> UserName </td>
      <td> Email </td>
      <td> FullName </td>
      <td> Registered Date </td>
      <td> Control </td>
     
  </tr> 
  <?php
  foreach($rows as $r){
    echo " <tr>";
    echo "<td>". $r['userID']."</td>";
    echo "<td>";
    if(empty($r['profile'])){
      echo "<img class='profile rounded-circle' title='".$r['username']."' alt='".$r['username']."'src='design/images/download'>";
    }
    else{
    echo "<img class='profile rounded-circle' title='".$r['username']."' alt='".$r['username']."'src='design/images/". $r['profile']."'>";
    }
    echo "</td>";
    echo "<td>". $r['username']."</td>";
    echo "<td>". $r['Email']."</td>";
    echo "<td>". $r['FullName']."</td>";
    echo "<td>". $r['RegistedDate']."</td>";
   echo "<td>" . "<a href='members.php?do=Edit&id=". $r['userID'] ."' class='btn btn-success'><i class='fa fa-edit'> </i>Edit </a> " ;
   echo "<a href='members.php?do=Delete&id=". $r['userID'] ."' class='btn btn-danger confirm'><i class='fa fa-times'> </i> Delete </a>";
   if($r['Regstatus']==0)
   {
    echo "<a href='members.php?do=Activate&id=". $r['userID'] ."' class='btn btn-info Activate'><i class='fa fa-user-check'> </i> Active </a>";
  }
   echo "  </td>";

    echo " </tr>";
    
  }
    ?>
    </table>
  </div>
  <?php
      }else{
        echo '<h1 class="text-center">There is no Member</h1>' ;
        echo '<div class="container">';
      }
      ?>
  <a href='members.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> new Member</a>
 
</div>

<?php

  }else if($do=='Activate'){
   
    echo '<h1 class="text-center">Activate page</h1>';
    echo "<div class='container'>"; 
    $userid=0; // default value
  if(isset($_GET['id']) && is_numeric($_GET['id'])){ //to check the value of id come from get request and in numric value
    $userid=intval($_GET['id']);
  }
   
    $nu= checkItem("userID","users",$userid);
  
  if($nu>0){
    $stmt=$con->prepare("UPDATE users SET Regstatus=1 where userID=? ");  //delete user  
    $stmt->execute(array($userid));   
    $row=$stmt->rowCount();  // result number
  if($row>0){
   $message= "<div class ='alert alert-success'>Activate successfuly</div>";
   redirectpage($message,"back",3); 
  }
  }
  else{
   $message= "<div class ='alert alert-danger'>id not exest</div>";
   redirectpage($message,"index.php",5); 
  }
   echo "</div";
}
  
  else if ($do=='Delete'){
    echo '<h1 class="text-center">Delete page</h1>';
    echo "<div class='container'>"; 
    $userid=0; // default value
  if(isset($_GET['id']) && is_numeric($_GET['id'])){ //to check the value of id come from get request and in numric value
    $userid=intval($_GET['id']);
  }
   
    $nu= checkItem("userID","users",$userid);
  
  if($nu>0){
    $stmt=$con->prepare("DELETE FROM users where userID=? ");  //delete user  
    $stmt->execute(array($userid));   
    $row=$stmt->rowCount();  // result number
  if($row>0){
   $message= "<div class ='alert alert-success'>delete successfuly</div>";
   redirectpage($message,"back",3); 
  }
  }
  else{
   $message= "<div class ='alert alert-danger'>id not exest</div>";
   redirectpage($message,"index.php",5); 
  }
   echo "</div";
}
  else if($do=='Add'){
    //ADD page
   ?>

<h1 class="text-center">Add Member</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
       
    <!-- username -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label"> userName :</label>
          <div class="col-sm-9">
           <input type="text" name="username" class="form-control" autocomplete="off"  required="required" placeholder="userName">
          </div>
    </div>
    <!-- password -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label">password :</label>
           <div class="col-sm-9">
            <input type="password" name="pass" class="form-control password" autocomplete="new-password"  placeholder="password must be hard and complex" required="required">
            <i class="show-pass fa fa-eye fa-1x"></i>
          </div>
   </div>
    <!-- Email -->
    <div class="form-group form-group-lg">

        <label class="col-sm-3 control-label">Email :</label>
          <div class="col-sm-9">
           <input type="email" name="Email" class="form-control" autocomplete="off"  required="required" placeholder="Email must be valid">
          </div>
    </div>


    <!-- FullName -->
    <div class="form-group form-group-lg">

      <label class="col-sm-3 control-label">fullName :</label>
      <div class="col-sm-9">
        <input type="text" name="fullname" class="form-control" autocomplete="off" required="required" placeholder="full Name for profile">
      </div>
    </div>
     <!-- Avatar -->
     <div class="form-group form-group-lg">
    <label class="col-sm-3 control-label">user photo :</label>
    <div class="col-sm-9">
      <input type="file" name="profile" class="form-control" autocomplete="off" required="required" placeholder="">
    </div>
    </div>
    <!-- submit -->
    <div class="form-group">

      <div class="col-sm-offset-2 col-sm-10">
       <input type="submit" value="Add " class="btn btn-primary btn-lg">
      </div>
    </div>
  </form>
</div>

<?php
  }
  else if ($do=='Insert'){
  // insete page
 

   if($_SERVER['REQUEST_METHOD']=="POST"){  // to check the information get from post request
    echo '<h1 class="text-center">Insert page</h1>';
    echo "<div class='container'>"; 

    //upload variables
    $profile=$_FILES['profile'];
    $profileName=$_FILES['profile']['name'];
    $profileSize=$_FILES['profile']['size'];
    $profileTmp=$_FILES['profile']['tmp_name'];
    $profileType=$_FILES['profile']['type'];

    //list of allow file typed to upload
    
    $profileAllowedExtension=array('jpeg','jpg','png','gif','');
    
    //get profile extension

    $explod=explode('.',$profileName);
    $Lstring=end($explod);
    $profileExtension=strtolower($Lstring);

   



     $Uvar= $_POST['username'];
     $Evar= $_POST['Email'];
     $Flvar= $_POST['fullname'];
     $pvar=$_POST['pass'];
     $hashpass=sha1($_POST['pass']);

     
     //validate the form
     $formErrors=array();

     if(strlen($Uvar)<4){
      $formErrors[]= "<div class='alert alert-danger'>username can't be less than <strong>3 character</strong></div>";
     }
     if(strlen($Uvar)>20){
      $formErrors[]= "<div class='alert alert-danger'>username can't be greater than <strong>20 character</strong></div>";
     }
     if(empty($Uvar)){
      $formErrors[]= "<div class='alert alert-danger'>username can't be empty</div>";
     }
     if(empty($pvar)){
      $formErrors[]= "<div class='alert alert-danger'>password can't be empty</div>";
     }
     if(empty($Evar)){
      $formErrors[]= "<div class='alert alert-danger'>Email can't be empty</div>";
    }
    if(empty($Flvar)){
      $formErrors[]= "<div class='alert alert-danger'>FullName can't be empty</div>";
    }
    if(!empty($profileName) && ! in_array($profileExtension,$profileAllowedExtension)){
      $formErrors[]= "<div class='alert alert-danger'>This extension is not allow </div>";
    }  
    if(empty($profileName)){
      $formErrors[]= "<div class='alert alert-danger'>profile can't be empty</div>";
    }
    if($profileSize>4194304){
      $formErrors[]= "<div class='alert alert-danger'>profile can't be greater than 4 MG</div>";
    }
    // loop for print error
    foreach($formErrors as $error){
      redirectpage($error,"back",5);
    }
    //insert data
    if(empty($formErrors)){
      $APLAOD=rand(0,10000000000)."_".$profileName;
      move_uploaded_file($profileTmp,"design\images\\" .$APLAOD);
    $checkUser= checkItem("username","users",$Uvar);
    if($checkUser==1){
     $msgs= "<div class='alert alert-danger'>sorry this user is already exist </div>";
     redirectpage($msgs,"back",5);
    }
   
    else if($checkUser==0){
      
      $stmt =$con->prepare("INSERT INTO users(username,password,Email,FullName,Regstatus,RegistedDate,profile)
      values (:zuser,:zpass,:zmail,:zname,:zstatus,:zdate,:zprofile)");
      $stmt->execute(array(
      'zuser'=>$Uvar,
      'zpass'=>$hashpass,
      'zmail'=>$Evar,
      'zname'=>$Flvar,
      'zstatus'=>0,
      'zdate'=>date('Y-m-d'),
      'zprofile'=> $APLAOD
     ));
     if( $stmt->rowcount()>0){
     $message= "<div class ='alert alert-success'>Add successfuly</div>";
     redirectpage($message,"back",5);
    }
   }
  }
}
   else{
     echo '<div class="container">';
       $message= "<div class='alert alert-danger'>sorry man you can't veiw page directly</div>";
       redirectpage($message,"index.php",5);
       echo '</div>'; 
      }
   echo "</div>";
  }
  else if($do=='Edit'){
  //Edit page

   $userid=0; // default value
   if(isset($_GET['id']) && is_numeric($_GET['id'])){ //to check the value of id come from get request and in numric value
   $userid=intval($_GET['id']);
   }

   $stmt=$con->prepare("select * from users where userID=? LIMIT 1");  //select all information of id value 
   $stmt->execute(array($userid));   
   $rowresult = $stmt->fetch(); //result of stmt
   $row=$stmt->rowCount();  // result number
   if($row>0){
   ?>

<h1 class="text-center">Edit Members</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Update" method="POST">
       
    <input type="hidden" name ="uId" value="<?php echo $userid ?>">
    <!-- username -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label">userName :</label>
          <div class="col-sm-9">
           <input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $rowresult['username']?>" required="required">
          </div>
    </div>
    <!-- password -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label">password :</label>
           <div class="col-sm-9">
           <input type="hidden" name="pass" value="<?php echo $rowresult['password']?>">
           <input type="password" name="newpass" class="form-control password" autocomplete="new-password" value="" placeholder="skip blank if you don't want to change">
           <i class="show-pass fa fa-eye fa-1x"></i>
 
          </div>
   </div>
    <!-- Email -->
    <div class="form-group form-group-lg">

        <label class="col-sm-3 control-label">Email :</label>
          <div class="col-sm-9">
           <input type="email" name="Email" class="form-control" autocomplete="off" value="<?php echo $rowresult['Email']?>" required="required">
          </div>
    </div>


    <!-- FullName -->
    <div class="form-group form-group-lg">

      <label class="col-sm-3 control-label">fullName :</label>
      <div class="col-sm-9">
        <input type="text" name="fullname" class="form-control" autocomplete="off" value="<?php echo $rowresult['FullName']?>"required="required">
      </div>
    </div>
    <!-- submit -->
    <div class="form-group">

      <div class="col-sm-offset-2 col-sm-10">
       <input type="submit" value="save" class="btn btn-primary btn-lg">
      </div>
    </div>
  </form>
</div>
   <?php
    }
    else{
      echo '<div class="container">';
      $message= "<div class='alert alert-danger'>sorry , this id not exist</div>";
      redirectpage($message,"index.php",5); 
      echo '</div>';
   }
   } else if($do=='Update'){
   echo '<h1 class="text-center">Update Members</h1>';
   echo "<div class='container'>";
   if($_SERVER['REQUEST_METHOD']=="POST"){  // to check the information get from post request
     $Idvar= $_POST['uId'];
     $Uvar= $_POST['username'];
     $Evar= $_POST['Email'];
     $Flvar= $_POST['fullname'];
     $pvar= $_POST['newpass'];
     $pass="";

     //password the form
     if(empty($pvar)){
     $pass= $_POST['pass'];
     }
     else{
       $pass=sha1($pvar);
     }
     //validate the form
     $formErrors=array();

     if(strlen($Uvar)<4){
      $formErrors[]= "<div class='alter alter-danger'>username can't be less than <strong>3 character</strong></div>";
     }
     if(strlen($Uvar)>20){
      $formErrors[]= "<div class='alter alter-danger'>username can't be greater than <strong>20 character</strong></div>";
     }
     if(empty($Uvar)){
      $formErrors[]= "<div class='alter alter-danger'>username can't be empty</div>";
     }
     if(empty($Evar)){
      $formErrors[]= "<div class='alter alter-danger'>Email can't be empty</div>";
    }
    if(empty($Flvar)){
      $formErrors[]= "<div class='alter alter-danger'>FullName can't be empty</div>";
    }
    // loop for print error
    foreach($formErrors as $error){
      echo '<div class="container">';
      redirectpage($error,"back",5);
      echo '</div>';
    }
    //update data
    if(empty($formErrors)){
     
    $stmt2=$con ->prepare("SELECT * FROM users WHERE username=? AND userID!=?");
    $stmt2->execute(array($Uvar,$Idvar));
    if( $stmt2->rowcount()==0){

     $stmt=$con->prepare("UPDATE users SET username=? , Email=? , FullName=? ,password=? where userID=?");
     $stmt->execute(array($Uvar,$Evar,$Flvar,$pass,$Idvar));
     if( $stmt->rowcount()>0){
      echo '<div class="container">';
     $message=  "<div class ='alert alert-success'>update successfuly</div>";
     redirectpage($message,"back",5);
     echo '</div>'; 
     }
    }
    else{
    echo '<div class="container">';
    $message=  "<div class ='alert alert-danger'>sorry this username is already exist</div>";
    redirectpage($message,"back.php",3);
    echo '</div>';  
    }
    }
  }
   else{
    echo '<div class="container">';
       $message=  "<div class ='alert alert-danger'>sorry man you can't browse this page</div>";
     redirectpage($message,"index.php",5);
     echo '</div>';     
      }
   echo "</div>";
}
   include $passtpl."footer.php";
}
else {
header('location:index.php');
exit();
}
?>