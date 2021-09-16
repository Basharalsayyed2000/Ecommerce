<?php 
session_start();
include "init.php"; ?>

<div class="container"> 
   <h1 class="text-center"> Show Catagory Items</h1>
   <div class="row">
   <?php
   if(isset($_GET['catid']) && is_numeric($_GET['catid'])){
   foreach(getItem("catID",$_GET['catid']) as $item){
    echo "<div class='col-sm-6 col-md-3'>";
        echo '<div class="thumbnail item-box">';
           echo  " <span class='price-tag'>".$item['price']."</span> ";
           echo '<img src="download.png"  class="img-thumbnail img-responsive" alt="">';
              echo '<div class="caption">';
                echo "<h4><a href='items.php?&itemid=". $item['itemID'] ."'>".$item['itemName'].'</a></h4>';     
                echo '<p>'.$item['itemDescription'].'</p>'; 
                echo '<div class="date">'.$item['addDate'].'</div>';     
    
              echo "</div>";
        echo "</div>";
    echo "</div>";
     }
   }
   ?>
   </div>
</div>

<?php include $passtpl."footer.php";?>