<?php
// you can manage Comments 
session_start();

$pageTitle="Comments"; // page title variable , will print using function

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
   $stmt=$con->prepare("select * from comments ORDER BY cID DESC"); // select all comments
   $stmt->execute(); // execute statement
   $rows= $stmt->fetchAll();
  if(!empty($rows)){
?>
<h1 class="text-center">Manage Comments</h1>
<div class="container">
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
    <tr>
      <td> #ID </td>
      <td> Comment </td>
      <td> Items Name </td>
      <td> User Name </td>
      <td> Added Date </td>
      <td> Control </td>
     
  </tr> 
  <?php
  foreach($rows as $r){
    $userResult=joinTable("username","users","comments","comments.cID=".$r['cID']."");
    $ItemResult=selectWithCondition("itemName","items , comments","comments.cID=".$r['cID']." AND comments.itemID=items.itemID");
    echo " <tr>";
    echo "<td>". $r['cID']."</td>";
    echo "<td>". $r['comment']."</td>";
    echo "<td>".$ItemResult."</td>";
    echo "<td>". $userResult ."</td>";
    echo "<td>". $r['cDate']."</td>";
    
   echo "<td>" . "<a href='comments.php?do=Edit&id=". $r['cID'] ."' class='btn btn-success'><i class='fa fa-edit'> </i>Edit </a> " ;
   echo "<a href='comments.php?do=Delete&id=". $r['cID'] ."' class='btn btn-danger confirm'><i class='fa fa-times'> </i> Delete </a>";
       if($r['status']==0)
    {
     echo "<a href='comments.php?do=Approve&id=". $r['cID'] ."' class='btn btn-info Activate'><i class='fa fa-user-check'> </i> Approve </a>";
   }
   echo "  </td>";

    echo " </tr>";
    
  }
    ?>
  </table>
  <?php
      }else{
        echo '<h1 class="text-center">There is no comment</h1>' ;
      }
      ?>
<?php

  }else if($do=='Approve'){
   
    echo '<h1 class="text-center">Approve page</h1>';
    echo "<div class='container'>"; 
    $commid=0; // default value
  if(isset($_GET['id']) && is_numeric($_GET['id'])){ //to check the value of id come from get request and in numric value
    $commid=intval($_GET['id']);
  }
   
    $nu= checkItem("cID","comments",$commid);
  
  if($nu>0){
    $stmt=$con->prepare("UPDATE comments SET status=1 where cID=? ");  //update comment  
    $stmt->execute(array($commid));   
    $row=$stmt->rowCount();  // result number
  if($row>0){
   $message= "<div class ='alert alert-success'>Approve successfuly</div>";
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
    $commid=0; // default value
  if(isset($_GET['id']) && is_numeric($_GET['id'])){ //to check the value of id come from get request and in numric value
    $commid=intval($_GET['id']);
  }
   
    $nu= checkItem("cID","comments",$commid);
  
  if($nu>0){
    $stmt=$con->prepare("DELETE FROM comments where cID=? ");  //delete user  
    $stmt->execute(array($commid));   
    $row=$stmt->rowCount();  // result number
  if($row>0){
   $message= "<div class ='alert alert-success'>delete successfuly</div>";
   redirectpage($message,"back",5); 
  }
  }
  else{
   $message= "<div class ='alert alert-danger'>id not exest</div>";
   redirectpage($message,"index.php",5); 
  }
   echo "</div";
}
 
 
  else if($do=='Edit'){
  //Edit page

   $commid=0; // default value
   if(isset($_GET['id']) && is_numeric($_GET['id'])){ //to check the value of id come from get request and in numric value
   $commid=intval($_GET['id']);
   }

   $stmt=$con->prepare("select * from comments where cID=? LIMIT 1");  //select all information of id value 
   $stmt->execute(array($commid));   
   $rowresult = $stmt->fetch(); //result of stmt
   $row=$stmt->rowCount();  // result number
   if($row>0){
   ?>

<h1 class="text-center">Edit comment</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Update" method="POST">
       
    <input type="hidden" name ="cId" value="<?php echo $commid ?>">
    <!-- comment -->
    <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label"> comment:</label>
          <div class="col-sm-10">
          <textarea name="comment" class="form-control"  cols="30" rows="10"  required="required"><?php echo $rowresult['comment']?></textarea>
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
      $message= "<div class='alert alert-danger'>sorry , this id not exist</div>";
      redirectpage($message,"index.php",5); 

   }
   } else if($do=='Update'){
   echo '<h1 class="text-center">Update Comment</h1>';
   echo "<div class='container'>";
   if($_SERVER['REQUEST_METHOD']=="POST"){  // to check the information get from post request
     $Idvar= $_POST['cId'];
     $covar= $_POST['comment'];
    
    //update data
     if(!empty($covar)){
     $stmt=$con->prepare("UPDATE comments SET comment=?  where cID=?");
     $stmt->execute(array($covar,$Idvar));
     if( $stmt->rowcount()>0)
     $message=  "<div class ='alert alert-success'>update successfuly</div>";
     redirectpage($message,"back",5); 
    }
    else{
        echo "<div class='container'>";
        $ms="<div class='alter alter-danger'>comment can't be empty</div>";
        redirectpage($ms,"back",5); 
        echo "</div>"; 
    }
  }
   else{
       echo "<div class='container'>";
       $message=  "<div class ='alert alert-danger'>sorry man you can't browse this page</div>";
       redirectpage($message,"index.php",5);  
       echo "</div>";    
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