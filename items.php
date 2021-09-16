<?php 
ob_start();
 session_start();
 $pageTitle="show Item";
 include "init.php";

  $itemid=0; // default value
  if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){ //to check the value of id come from get request and in numric value
  $itemid=intval($_GET['itemid']);
  }

  $stmt=$con->prepare("select items.*,catagories.Name , users.username
                             from items
                             INNER JOIN
                             catagories
                             ON 
                             catagories.catID=items.catID
                             INNER JOIN
                             users
                             ON
                             items.userID=users.userID
                              where itemID=? 
                              AND Approve=1
                              LIMIT 1");  //select all information of id value 
  $stmt->execute(array($itemid));   
  $rowresult = $stmt->fetch(); //result of stmt
  $row=$stmt->rowCount();  // result number
  if($row>0){
?>
 <h1 class="text-center"> My <?php echo $rowresult['itemName']; ?> </h1>
<div class="container">
      <div class="row">
        <div class="col-md-3">
           <img src="download.png" alt="" class="img-thumbnail img-responsive center-block">
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $rowresult['itemName']; ?></h2>
            <p>Description :<?php echo $rowresult['itemDescription']; ?></p>
            <ul class="list-unstyled">
            <li>
            <i class="fa fa-calendar fa-fw">    </i>    
              <span> Added Date</span> :<?php echo $rowresult['addDate'];?>
            </li>
            <li>
            <i class="fa fa-dollar-sign fa-fw">    </i>      
            <span>Price</span> :<?php echo $rowresult['price']."$"; ?></li>
            <li>
            <i class="fa fa-globe-americas fa-fw">    </i>      
            <span>Made In</span> :<?php echo $rowresult['madeCountry']; ?></li>
            <li>
            <i class="fa fa-tags fa-fw">    </i>          
            <span>catagory</span> :<a href="catagoriesItem.php?catid=<?php echo $rowresult['catID']?>"><?php echo $rowresult['Name']; ?></a></li>
            <li>
            <i class="fa fa-user fa-fw">    </i>          
            <span>Added By</span> :<a href="#"><?php echo $rowresult['username']; ?></a></li>
            <li class="tags-items">
            <i class="fa fa-user fa-fw">    </i>          
            <span>Tags</span> :
            <?php
            $allTags=explode(",",$rowresult['tags']);
            if(!empty($rowresult['tags'])){
            foreach($allTags as $tag){
              $tag=str_replace(' ','',$tag);
              $lowerTag=strtolower($tag);
              echo "<a href='tags.php?name={$lowerTag}'> ".$tag."</a>";
            }
          }

            ?>
          </ul>
        </div>
      </div>
      <hr class="costume-hr">
      <?php if(isset($_SESSION['usrname'])) {?>
      <!-- start add comment -->
      <div class="row">
        <div class="col-md-offset-3">
           <div class="add-comment">
           <h3>Add your comment</h3>
           <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$rowresult['itemID']?>" method="POST">
           <textarea name="COMMENT" required></textarea>
           <input type="submit" value="send comment" class="btn btn-primary" >
           </form>
           <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST'){  // to check the information get from post request
             $comm='';
             $comm= filter_var($_POST['COMMENT'],FILTER_SANITIZE_STRING);
             $usid=$_SESSION['usrId'];
             $itID=$rowresult['itemID'];
            if(!empty($comm)){
              $stmtmt=$con->prepare("INSERT into 
              comments(comment,status,cDate,userID,itemID) 
              value(:zcomment,0,:zDate,:zUserid,:zitemid)");
  
              $stmtmt->execute(array(
               'zcomment'=>$comm,
               'zDate'=>date('Y-m-d'),
               'zUserid'=>$usid,
               'zitemid'=>$itID
              ));
              if($stmtmt){
                  echo "<div class='alert alert-success'>comment added</div>";
                  $url= $_SERVER['PHP_SELF'].'?itemid='.$rowresult['itemID'];
                  header("refresh:3;url=$url");
              }   
            }
           }
           ?>
          </div>
        </div>
    </div>  
      <?php 
      }else{
      echo "<a href='login.php'>login </a> or <a href='login.php'> register</a> To Add Comment";
      }
      ?>
      <!-- end add comment -->

      <hr class="costume-hr">
              <?php

                    $stmt5=$con->prepare("select comments.*, users.username
                                        from comments
                                        INNER JOIN
                                        users
                                        ON 
                                        comments.userID=users.userID
                                        where itemID=? and status=1
                                        ORDER BY cID DESC");  //select all information of id value 
                    $stmt5->execute(array($rowresult['itemID']));   
                    $commentS = $stmt5->fetchAll(); //result of stmt
                    $rows=$stmt5->rowCount();  // result number
                   
                    ?>
         <?php
          if($rows>0){
              foreach($commentS as $commm){
                echo "<div class='comment-box'>";
                echo '<div class="row">';
                echo  "<div class='col-sm-2 text-center'>";
                echo '<img src="download.png"  class="img-thumbnail img-responsive img-circle" alt="">';
                echo $commm['username'];
                echo '</div>';
                echo  "<div class='col-sm-10'>";
                echo "<p class='lead'>".$commm['comment']."</p>";
                echo '</div>';
                echo "</div>";
                echo "</div>";
                echo "<hr class='costume-hr'>";
               }
            }
             else{
               echo 'there is no comments';
              }
          ?>
  </div>

<?php
  }
  else{
    echo "<div class='container'>";
    echo '<div class="alert alert-danger">there is no id Or this item is not Approval</div>';
    echo '</div>';
  }
include $passtpl."footer.php";
ob_end_flush();
?>