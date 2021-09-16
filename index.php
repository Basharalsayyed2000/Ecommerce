<?php 
ob_start();
 session_start();
 $pageTitle="Homepage";
 include "init.php";
 ?>

<div class="container"> 
   <h1 class="text-center"> </h1>
   <div class="row">
   <?php
   $allitems=getTableFrom("items",'where Approve=1',"itemID");
   foreach($allitems as $item){
    echo "<div class='col-sm-6 col-md-3'>";
        echo '<div class="thumbnail item-box">';
           echo  " <span class='price-tag'>".$item['price']."$</span> ";
           echo '<img src="download.png"  class="img-thumbnail img-responsive" alt="">';
              echo '<div class="caption">';
                echo "<h4><a href='items.php?&itemid=". $item['itemID'] ."'>".$item['itemName'].'</a></h4>';     
                echo '<p>'.$item['itemDescription'].'</p>'; 
                echo '<div class="date">'.$item['addDate'].'</div>';     
    
              echo "</div>";
        echo "</div>";
    echo "</div>";
   }
   ?>
   </div>
</div>




<?php
include $passtpl."footer.php";
ob_end_flush();
?>