<?php 
ob_start();
 session_start();
 $pageTitle="Login";
 if(isset($_SESSION['usrname']))
 {
    header('Location:index.php'); 
 }
 include "init.php";
 //check if user coming from HTTP post request
 if($_SERVER['REQUEST_METHOD']=='POST'){
   if(isset($_POST['login'])){
   $USER=$_POST['user'];
   $PASS=$_POST['pass'];
   $hashPass=sha1($PASS);
   
   //check if the user in database
   $stmt=$con->prepare("select rank ,userID ,username , password from users where username=? and password=? ");
   $stmt->execute(array($USER,$hashPass));
   $reslt=$stmt->fetch();
   $row=$stmt->rowCount();
   if($row>0){
    $_SESSION['usrname']=$USER; //regester session Name
    $_SESSION['usrId']=$reslt['userID'];
    if($reslt['rank']==1){
      $_SESSION['admin']=$reslt['username'];
    }
    header('Location:index.php');
    exit();
   } 
 }
   else {
    $Evar= $_POST['Email'];
    $Flvar= $_POST['fName'];
    $pvar1=$_POST['pass'];
    $pvar2=$_POST['pass2'];
    $uvar=$_POST['user'];

    $formErrors=array();
    $filterUser=filter_var($_POST['user'],FILTER_SANITIZE_STRING);

    if(strlen($filterUser)<4){  //filter the username
      $formErrors[]= "username can't be less than <strong>3 character</strong>";
    }

   if(isset($_POST['Email'])) {
    $filterEmail=filter_var($_POST['Email'],FILTER_SANITIZE_EMAIL);
    if(filter_var($filterEmail,FILTER_VALIDATE_EMAIL) != true){  //filter the Email
      $formErrors[]= "This mail is not valid ";
    }
    }
   
   
   if(isset($_POST['pass']) && isset($_POST['pass2'])) {
    if(empty($_POST['pass'])){
      $formErrors[]= "password is empty";
    }
    $pvar1=sha1($_POST['pass']);
    $pvar2=sha1($_POST['pass2']);
    if($pvar1!==$pvar2){
      $formErrors[]= "not matched password";
    }
   }
   
   //insert data
   if(empty($formErrors)){
   $checkUser= checkItem("username","users",$filterUser);
   if($checkUser==1){
    echo "<div class='container'>";
    $formErrors[]= "sorry this user is already exist ";
    echo '</div>';
   }
   else if($checkUser==0){
     
   $stmt =$con->prepare("INSERT INTO users(username,password,Email,FullName,Regstatus,RegistedDate)
    values (:zuser,:zpass,:zmail,:zname,:zstatus,:zdate)");
    $stmt->execute(array(
     'zuser'=>$filterUser,
     'zpass'=>$pvar1,
     'zmail'=>$Evar,
     'zname'=>$Flvar,
     'zstatus'=>0,
     'zdate'=>date('Y-m-d')
    ));
    if( $stmt->rowcount()>0){
    $successMsg= "Add successfuly";
    }
   }
  }
  }
 }
 ?>
<div class="container login-page"> 
    <h1 class="text-center"><span class="selected" data-class="login">login</span> | 
    <span data-class="signup">signup</span></h1>
    <!-- start login form -->
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <input class="form-control log" type="text" name="user" placeholder="username" autofocus autocomplete='off'>
    <input class="form-control log" type="password" name="pass" placeholder="password" autocomplete='new-password'>
    <input class="btn btn-primary btn-block"type="submit" value="login" name="login">
    </form>


    <!-- start signup form -->
    <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <input pattern=".{4,}" title="username must be graeter than 4 char" class="form-control log" type="text" name="user" placeholder="username greater than 4 characters" autofocus autocomplete='off' required> 
    <input minlength="4" class="form-control log" type="password" name="pass" placeholder="type a complex password" autocomplete='new-password'  required>
    <input  minlength="4" class="form-control log" type="password" name="pass2" placeholder="retype password" autocomplete='new-password' required>
    <input class="form-control log" type="Email" name="Email" placeholder="valid Email" autofocus autocomplete='' required>
    <input class="form-control log" type="text" name="fName" placeholder="Full Name" autofocus autocomplete='off' required>
    <input class="btn btn-success btn-block"type="submit" value="signup" name="signup">
    </form>
    <div class="Errors text-center">
     <?php
      if(!empty($formErrors)){
       foreach($formErrors as $error){
         echo "<div class='msg'>".$error."</div>";
       }
      }
      if(isset($successMsg)){
        echo "<div class='msg'>".$successMsg."</div>";
      }
     ?>
    </div>
</div>
<?php include $passtpl."footer.php";?>