<?php 
 session_start();
 $pageTitle="Create New Item";
 include "init.php";
 if(isset($_SESSION['usrname'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      
        $formEr=array();
        
        $tags=filter_var($_POST['Tags'],FILTER_SANITIZE_STRING);
        $title=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $desc=filter_var($_POST['Description'],FILTER_SANITIZE_STRING);
        $price=filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_FLOAT);
        $cost=filter_var($_POST['cost'],FILTER_SANITIZE_NUMBER_FLOAT);
        $discount=filter_var($_POST['discount'],FILTER_SANITIZE_NUMBER_FLOAT);
        $country=filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $catagory=filter_var($_POST['catagory'],FILTER_SANITIZE_NUMBER_INT);
        $status=filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $usid=$_SESSION['usrId'];
        if(strlen($title)<4){
            $formEr[]='Item Title Must Be at least 3 char';
        }
        if(strlen($desc)<10){
            $formEr[]='Item Description Must Be at least 10 char';
        }
        if(strlen($country)<2){
            $formEr[]='Item Country Must Be at least 2 char';
        }
        if(empty($price)){
            $formEr[]='Item price Must Be not empty';
        }
        if(empty($discount)){
            $formEr[]='Item discount Must Be not empty';
        }
        if(empty($cost)){
            $formEr[]='Item cost Must Be not empty';
        }
        if(empty($status)){
            $formEr[]='Item status Must Be not empty';
        }
        if(empty($catagory)){
            $formEr[]='Item catagory Must Be not empty';
        }

         //insert data
       if(empty($formEr)){
      
        $stmt2 =$con->prepare("INSERT INTO items(itemName,itemDescription,price,addDate,madeCountry,status,cost,discount,catID,userID,tags)
         values (:iname,:idesc,:iprice,:iDate,:icountry,:istatus,:icost,:idiscount,:zcat,:zuser,:ztags)");
         $stmt2->execute(array(
          'iname'=>$title,
          'idesc'=>$desc,
          'iprice'=>$price,
          'iDate'=>date('Y-m-d'),
          'icountry'=>$country,
          'istatus'=>$status,
          'icost'=>$cost,
          'idiscount'=>$discount,
          'zuser'=>$usid,
          'zcat'=>$catagory,
          'ztags'=>$tags
         ));
         if( $stmt2->rowcount()>0){
            $successMsg='Added successfully';
        }
       
      }
      
                
    } 
?>
 <h1 class="text-center"> <?php echo $pageTitle ?> </h1>
  <div class="Create-Ad block">
     <div class="container">
         <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $pageTitle ?></div>
             <div  class="panel-body"> 
                <div class="row">
                    <div class="col-md-8">
                          <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
        
                                <!-- name -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> Name :</label>
                                    <div class="col-sm-9">
                                        <input pattern=".{3,}" title="this field required at least 3 char" type="text" name="name" class="form-control live-name" autocomplete="off"  placeholder="Name of the Item must be greater than 3 char" required>
                                    </div>
                                </div>
                                <!-- Description -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> Description:</label>
                                    <div class="col-sm-9">
                                        <input pattern=".{10,}" title="this field required at least 10 char" type="text" name="Description" class="form-control live-Description" autocomplete="off"  placeholder="Description of the Item must be greater than 10 char" required>
                                    </div>
                                </div>
                                <!-- price -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> price:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="price"  class="form-control live-price" autocomplete="off"  placeholder="price of the Item" required>
                                    </div>
                                </div>
                                    <!-- cost -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> cost:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="cost"  class="form-control" autocomplete="off"  placeholder="cost of the Item" required>
                                    </div>
                                </div>
                                    <!-- discount -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> discount:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="discount"  class="form-control" autocomplete="off"  placeholder="discount" required>
                                    </div>
                                </div>
                                    <!-- country -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> country:</label>
                                    <div class="col-sm-9">
                                        <input pattern=".{2,}" title="this field required at least 2 char" type="text" name="country"  class="form-control" autocomplete="off"  placeholder="country of made must be greater than 2 char" required>
                                    </div>
                                </div>
                                 <!-- Tags -->
                                 <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> Tags:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="Tags"  class="form-control" autocomplete="off"  placeholder="seperate Tags with comma">
                                    </div>
                                </div>
                                <!-- status -->
                                <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> status:</label>
                                    <select name="status">
                                    <option value="">...</option>
                                        <option value="1">like New</option>
                                        <option value="2">Used</option>
                                        <option value="3">Old</option>
                                        <option value="4">very old</option>
                                        <option value="5">New</option>
                                    </select>
                                </div>
                           
                            <!-- catagory -->
                            <div class="form-group form-group-lg">
                                    <label class="col-sm-3 control-label"> catagory:</label>
                                    <select name="catagory">
                                    <option value="">...</option>
                                    <?php
                                       $catgs=getTableFrom("catagories","where parent=0");
                                        foreach($catgs as $catg){
                                            echo "<option value='".$catg['catID']."'>".$catg['Name']."</option>";
                                            $childcatgs=getTableFrom("catagories","where parent=".$catg['catID']);
                                            foreach($childcatgs as $childcatg){
                                                echo "<option value='".$childcatg['catID']."'>---".$childcatg['Name']."</option>";
  
                                            }

                                        }
                                        ?>  
                                    </select>
                                </div>

                                <!-- submit -->
                                <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="Add Item" class="btn btn-primary btn-md">
                                </div>
                                </div>
                        </form>
                    
                    </div>
                    <div class="col-md-4">
                        <?php
                        echo '<div class="thumbnail item-box live-preview">';
                        echo  " <span class='price-tag'>".'0$'."</span> ";
                        echo '<img src="download.png" alt="">';
                        echo '<div class="caption">';
                        echo '<h4>'.'Title'.'</h4>';     
                        echo '<p>'.'description'.'</p>';  
                        echo "</div>";
                        echo "</div>";

                    ?>
                    </div>  
                </div>
                <?php
                
                if(!empty($formEr)){
                    foreach($formEr as $Error){
                        echo "<div class='alert alert-danger'>". $Error."</div>";
                    }
                }
                if(isset($successMsg)){
                        echo "<div class='alert alert-success'>".$successMsg."</div>";
                       

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