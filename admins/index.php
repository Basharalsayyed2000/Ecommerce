<?php 
 session_start();
 $noNavBar=""; // vairable to check if this bage need navbar or not
 $pageTitle="Login";
 if(isset($_SESSION['name']))
 {
    header('Location:dashboard.php'); 
 }
 include "init.php";
 //check if user coming from HTTP post request
 if($_SERVER['REQUEST_METHOD']=='POST'){
   $USER=$_POST['user'];
   $PASS=$_POST['pass'];
   $hashPass=sha1($PASS);
   
   //check if the user in database
   $stmt=$con->prepare("select username , password,userID from users where username=? and password=? and rank=1 LIMIT 1");
   $stmt->execute(array($USER,$hashPass));
   $rowresult = $stmt->fetch();
   $row=$stmt->rowCount();
   if($row>0){
    $_SESSION['name']=$USER; //regester session Name
    $_SESSION['ID']=$rowresult['userID']; //regester session ID
    header('Location:dashboard.php');
   exit();
   } 
 }
 ?>

<form class="login"  action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center">Admin login</h4>
    
    <input class="form-control log" type="text" name="user" placeholder="username" autofocus autocomplete='off'>
    
    <input class="form-control log" type="password" name="pass" placeholder="password" autocomplete='new-password'>
    <br>
    <input class="btn btn-primary btn-block"type="submit" value="login">
</form>
<?php include $passtpl."footer.php";?>