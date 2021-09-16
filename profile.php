<?php 
 session_start();
 $pageTitle="profile";
 include "init.php";
 if(isset($_SESSION['usrname'])){
      $statm=$con->prepare('select * from users where username=?');
     $statm->execute(array($sessionUser));
     $infom=$statm->fetch(); 
 ?>
 <h1 class="text-center"> My Profile </h1>
  <div class="information block">
     <div class="container">
         <div class="panel panel-primary">
             <div class="panel-heading">My information</div>
             <div  class="panel-body"> 
              <ul class="list-unstyle">
                <li>
                <i class="fa fa-unlock-alt fa-fw">    </i>
                <?php echo "<span>username </span>:". $infom['username']; ?></li>
                <li> 
                <i class="fa fa-user fa-fw">    </i>    
                <?php echo "<span>FullName </span> :". $infom['FullName']; ?></li>
                <li> 
                <i class="fa fa-envelope fa-fw">    </i>    
                <?php echo "<span>Email </span> :". $infom['Email']; ?> </li>
                <li>
                <i class="fa fa-calendar fa-fw">    </i>    
                <?php echo "<span>Register Date </span> :". $infom['RegistedDate']; ?>  </li>   
              </ul>
              <a class="btn btn-default my-buttons" href='#'>Edit Info</a>
            </div>
         </div>
     </div>
  </div>


 <div id="my-ads" class="my-ads block">
     <div class="container">
         <div class="panel panel-primary">
             <div class="panel-heading">My Items</div>
            <div class="panel-body"> 
            <?php
            if(!empty(getItem("userID", $infom['userID']))){
            foreach(getItem("userID", $infom['userID'],1) as $item){
                echo "<div class='col-sm-6 col-md-3'>";
                    echo '<div class="thumbnail item-box">';
                    if($item['Approve']==0){
                        echo "<span class='approve-tag'>waiting approval</span>";
                    }
                    echo  " <span class='price-tag'>".$item['price']."$</span> ";
                    echo '<img src="download.png" alt="">';
                        echo '<div class="caption">';
                            echo "<h4><a href='items.php?itemid=". $item['itemID'] ."'>".$item['itemName'].'</a></h4>';     
                            echo '<p>'.$item['itemDescription'].'</p>';   
                            echo '<div class="date">'.$item['addDate'].'</div>';     
  
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                }
            }else{
                echo "sorry ,there is no Ads to show, <a href=''>create new Ads</a> ";
            }
            ?>     
            
            </div>
         </div>
     </div>
 </div>

 <div class="my-comm block">
     <div class="container">
         <div class="panel panel-primary">
             <div class="panel-heading">Latest Comments</div>
             <div class="panel-body"> 
             <?php
                $stmt4=$con->prepare("SELECT comment FROM comments where comments.userID=?");
                $stmt4->execute(array($infom['userID']));
                $result1=$stmt4->fetchAll();
                if(!empty($result1)){
                foreach($result1 as $comm){
                 echo '<p>'.$comm['comment'].'</p>';
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


<?php
}
else{
header('location:login.php');
exit();
}
include $passtpl."footer.php";
?>