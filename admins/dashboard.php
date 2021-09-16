<?php
ob_start();
session_start();
if(isset($_SESSION['name']))
{  
   $pageTitle="dashbord";
   include "init.php";
//start design dashboard

?>

<div class="container text-center home-stat">
    <h1>Dashboard page</h1>
      <div class="row"> 
         <div class="col-md-3">
            <div class="stat st-members">
               
               <i class="fa fa-user uicon "></i>
               <div class="info">
                  total Members
                  <span>
                     <a href="members.php"><?php echo countItems("userID","users","WHERE rank=0");?></a>
                  </span>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="stat st-pending">
            <i class="fa fa-user-plus uicon "></i>
               <div class="info">
                pending MBM
                  <span>
                     <a href="members.php?do=Manage&pending=Yes"> <?php echo countItems("userID","users","WHERE Regstatus=0 AND rank=0");?></a>
                  </span>
              </div>            
            </div>
         </div>
         <div class="col-md-3">
            <div class="stat st-items">
              <i class="fa fa-tag uicon "></i>
               <div class="info">
               total Items
                  <span>
                     <a href="items.php"> <?php echo countItems("itemID","items","");?></a>
                  </span>
              </div>                     
            </div>
         </div>
         <div class="col-md-3">
            <div class="stat st-comments">

              <i class="fa fa-comments uicon "></i>
               <div class="info">
               total Comments
                  <span>
                     <a href="Comments.php"> <?php echo countItems("cID","comments","");?></a>
                  </span>
              </div>    
         </div>
      </div>
   </div>
</div>

<div class="container latest">
   <div class="row"> 
      <div class="col-sm-6">
         <div class="panel panel-default succ">
              <?php $userno = 4?>
               <div class="panel-heading ph">
               <i class="fa fa-users"></i> Lastest <?php echo $userno?> Registered Users
               </div>
               <div class="panel-body mem">
               <?php
               $theLatestUser=getLastest("*","users",$userno,"userID","where users.rank=0");
               if(!empty( $theLatestUser)){
               foreach($theLatestUser as $user){
                  echo "<a href='members.php?do=Edit&id=".$user['userID']."'>" .$user['username']."</a>"."<br>";
               }
               }
               else{
                  echo "there is no users";
               }
               ?>
               </div> 
         </div>
      </div>
      <div class="col-sm-6">
         <div class="panel panel-default succ">
              <?php $itemno = 4?>
              <div class="panel-heading ph">
               <i class="fa fa-tag"></i> Lastest <?php echo $itemno?>  Added Items
              </div>
              <div class="panel-body mem">
               <?php
               $theLatestItem=getLastest("*","items",$itemno,"itemID",'');
               if(!empty( $theLatestItem)){
               foreach($theLatestItem as $item){
                  echo "<a href='Items.php?do=Edit&itemid=".$item['itemID']."'>" .$item['itemName']."</a>"."<br>";
               } 
               }
               else{
                  echo "there is no items";
               }
               ?>
               </div>
         </div> 
      </div>
   </div>
   
   <!-- start lastest comments -->
   <div class="row LastC"> 
      <div class="col-sm-6">
         <div class="panel panel-default succ">
              <?php $commno = 4?>
               <div class="panel-heading ph">
               <i class="fa fa-comments"></i> Lastest <?php echo $commno ?> Comments 
               </div>
               <div class="panel-body mem">
                  <?php
                  $stmt = $con->prepare("SELECT comments.*, users.username AS userN FROM comments INNER JOIN users ON users.userID = comments.userID ORDER BY cID DESC LIMIT $commno");
                  $stmt ->execute();
                  $commen=$stmt->fetchAll();
                  if(!empty( $commen)){
                  foreach($commen as $comm){
                   echo '<div class="comment-box">';
                   echo '<span class="member-n"><a href="members.php?do=Edit&id='.$comm['userID'].'">'.$comm['userN'].'</a></span>';
                   echo '<p class="member-c">'.$comm['comment'].'</p>';
                   echo '</div>';
                  }  
                  } 
                  else{
                     echo "there is no comments";
                  }
                  ?>
               </div> 
         </div>
      </div>
   </div>
   <!-- end lastest commments -->
</div>

<?php
   include $passtpl."footer.php";

}
else {
header('location:index.php');
exit();
}
ob_end_flush();
?>