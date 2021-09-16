<?php 

 ob_start(); //output buffering start

 session_start();

 $pageTitle='Show Items';

 include "init.php";

    //check if get request userid is numeric and get its integer value
            
    $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

    //select all data according to this id

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
     where itemID=? LIMIT 1");
    
    $stmt->execute(array($itemid));

    $count=$stmt->rowCount();

    if($count > 0){   

        $item=$stmt->fetch();


?> 

    <h1 class="text-center"><?php echo $item['itemName'] ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img class="img-responsive img-thumbnail center-block" src="galaxy-s10-plusBLACK.png" alt="" />
            </div>   
            <div class="col-md-9 item-info">
                <h2><?php echo $item['itemName'] ?></h2>
                <p><?php echo $item['itemDescription'] ?></p>
                <ul class="list-unstyled">
                    <li>
                        <i class="fa fa-calendar fa-fw"></i>
                        <span>Added Date</span> : <?php echo $item['addDate'] ?>
                    </li>
                    <li>
                        <i class="fas fa-money-bill"></i>
                        <span>Price</span> : $<?php echo $item['price'] ?>
                    </li>
                    <li>
                        <i class="fa fa-building fa-fw"></i>
                        <span>Made in</span> : <?php echo $item['madeCountry'] ?>
                    </li>
                    <li>
                        <i class="fa fa-tags fa-fw"></i>
                        <span>Category</span> : <a href="categoriesItem.php?catid=<?php echo $item['catID'] ?>">
                        <?php echo $item['Name'] ?></a>
                    </li>
                    <li>
                        <i class="fa fa-user fa-fw"></i>
                        <span>Added By</span> : <a href="profile.php?catid=<?php echo $item['userID'] ?>">
                        <?php echo $item['username'] ?></a>
                    </li>
                    <li class="tags-name">
                        <i class="fas fa-hashtag"></i>
                        <span>Tags</span> : 
                         <?php 
                          /*   $allTags = explode(",",$item['tags']);
                            foreach($allTags as $tag){
                               
                                $tag = str_replace(" ","", $tag);
                                
                                $lowertag = strtolower($tag);
                                
                                if(!empty($tag)){
                                    echo "<a class='' href='tags.php?name={$lowertag}'>" . $tag . "</a>";
                                }
                            } */
                        ?> 
                    </li>
                </ul>
            </div>
        </div>
        <hr class="custom-hr">

        <?php 

            if(isset($_SESSION['usrname'])){ 
               

                ?>
        <!-- start add comment -->
        <div class="row">
            <div class="col-md-offset-3">
                <div class="add-comment">
                    <h3>Add Your Comment</h3>
                    <form  action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['itemID'].'&do=Insert' ?>" method="POST">
                        <textarea name="comment" required></textarea>
                        <input class="btn btn-primary" type="submit" value="Add Comment" />
                    </form>
                    <?php
                
                if($_GET['do']=='Insert'){
                     if($_SERVER['REQUEST_METHOD'] == 'POST'){
                            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                            $userid = $_SESSION['usrId'];
                            $itemid = $item['itemID'];

                            if(!empty($comment)){

                                $stmt = $con->prepare("INSERT INTO comments(comment, status, cDate, itemID, userID) 
                                                        
                                                        VALUES( :zcomment, 0, now(), :zitem, :zuser )");
                                
                                $stmt->execute(array(
                                    
                                    'zcomment' => $comment,
                                    'zitem' => $itemid,
                                    'zuser' => $userid
                                
                                ));

                                if($stmt)
                                    echo "<div class='alert alert-success'>Comment Added </div>";
                            }
                           
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
        <!-- end add comment -->

        <?php  } else {

                    echo "<a href='login.php'>Login</a> or <a href='login.php'>Register</a> To Add Comment";

                    }
        ?>

        <hr class="custom-hr">
        <?php 
                
           /*  //select all users except admins

            $stmt=$conn->prepare("SELECT comments.*, users.Username AS Member FROM comments

            INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ?
        
            AND status = 1 ORDER BY c_id DESC");

            $stmt->execute(array($item['Item_ID']));

            $comments=$stmt->fetchAll();
 */
            

        ?>

        <?php
      //  foreach($comments as $com){ ?>

              <!--   <div class="comment-box">
                    <div class='row'>
                        <div class='col-sm-2 text-center'>
                            <img class="img-responsive img-thumbnail img-circle center-block" src="image.jpg" alt="" />
                            <?php //echo $com['Member'] ?>
                        </div>
                        <div class='col-sm-10'>
                            <p class="lead"><?php //echo $com['comment'] ?></p>
                        </div>
                    </div>
                </div>
                <hr class="custom-hr">
         <?php  // }
        ?> -->

    </div>


<?php 

    }
    else{

        echo '<div class="container">';
                   $theMsg= '<div class="alert alert-danger">There is No Such ID or This Item Is Waiting Approval</div>'; 
                   redirectpage($theMsg, 'back',3);
        echo '</div>';

    }

?>    
<?php

 include $passtpl . 'footer.php';

 ob_end_flush(); //release the output

?>