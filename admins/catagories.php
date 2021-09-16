<?php
ob_start();
// you can manage catagories 
session_start();

$pageTitle="Catagories"; // page title variable , will print using function

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
    $sort='ASC';
    $sort_array=array('ASC','DESC');
    if(isset($_GET['sort'])&& in_array($_GET['sort'],$sort_array)){
      $sort=$_GET['sort'];
    }
   
  $stmt2=$con->prepare("SELECT * from catagories WHERE parent=0 ORDER BY ordering $sort"); 
  $stmt2->execute();
  $catInfo=$stmt2->fetchAll();
  if(!empty($catInfo)){
  ?>
   <h1 class="text-center">Manage Catagories</h1>
   <div class="container catagories">
     <div class="panel panel-default">
    <div class="panel-heading head"><h4><i class='fa fa-edit'></i> Manage Catagories</h4>
      <div class="ordering pull-right">
      <i class='fa fa-sort'></i> ordering:
           <a class="<?php if($sort=='ASC') {echo 'active';}?>" href="?sort=ASC" >ascending</a> |
           <a class="<?php if($sort=='DESC'){ echo 'active';}?>" href="?sort=DESC">descending</a>
      </div>
    </div>
       <div class="panel-body">
       <?php 
       foreach($catInfo as $cats){
        
         echo " <div class='cat'>";
         echo "<div class='hidden-buttons'>";
         echo "<a href='catagories.php?do=Edit&catID=". $cats['catID'] ."' class='btn btn-xxs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
         echo "<a href='catagories.php?do=Delete&catID=". $cats['catID'] ."' class='confirm btn btn-xxs btn-danger'><i class='fa fa-times'></i> Delete</a>";
         echo "</div>";
         echo   "<h3>".$cats['Name']."</h3>";    
         echo "<div class='full-view'>";  
         echo   "<p>";
         if(empty($cats['Description'])){
          echo "this catagory has no description yet"; 
         }
         else{
         echo $cats['Description'];
         }
         echo "</p>"; 
         if($cats['Visibility']==1) {
         echo "<span class='visibility'><i class='fa fa-eye'></i> hidden </span>"; 
         }
         if($cats['Allow_Comment']==1) {
          echo "<span class='comm'><i class='fa fa-times'></i> Comment Disable </span>"; 
          }
          if($cats['Allow_Add']==1) {
            echo "<span class='ads'><i class='fa fa-times'></i>Ads Disable</span>"; 
            }
          
        echo "</div>";
        $children=getTableFrom("catagories","where parent=".$cats['catID']);
        if(!empty($children)){
        echo "<h4 class='child-head'>Child Catagory</h4>";
        }
        echo   "<ul class='list-unstyled child-cat'>";
        foreach($children as $child){
           echo "<li class='child-link'>
           <a href='catagories.php?do=Edit&catID=". $child['catID'] ."'class='c-link'>".$child['Name'] ."</a>";
           echo "<a href='catagories.php?do=Delete&catID=". $child['catID'] ."' class='confirm show-delete'> Delete</a>";
           echo "</li>"; 
          }
        echo "</ul>"; 
        echo "</div>";
        echo"<hr>";

       }
       ?>
       </div>     
     </div>
     <?php
      }else{
        echo '<h1 class="text-center">There is no Catagory</h1>' ;
        echo '<div class="container">';
      }
      ?>
   <a class="btn btn-primary add-cata" href="catagories.php?do=Add"><i class="fa fa-plus"></i>Add Catagory</a>
   </div>
  <?php
  }
  else if($do=='Add'){
    if(isset($_GET['mass'])){
      echo  '<h1 class="text-center" style="color:red">first you must add catagory</h1>';
    }
?>
   <h1 class="text-center">New Catagory</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Insert" method="POST">
       
    <!-- name -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label"> Name :</label>
          <div class="col-sm-9">
           <input type="text" name="name" class="form-control" autocomplete="off"  required="required" placeholder="Name of the catagory">
          </div>
    </div>
    <!-- description -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label">Description:</label>
           <div class="col-sm-9">
            <input type="text" name="description" class="form-control " autocomplete="new-password"  placeholder="describe the catagory" >
          </div>
   </div>
    <!-- ordering -->
    <div class="form-group form-group-lg">

        <label class="col-sm-3 control-label">Ordering :</label>
          <div class="col-sm-9">
           <input type="text" name="Ordering" class="form-control" autocomplete="off" placeholder="number to arrange catagory">
          </div>
    </div>

    <!-- start catagory type -->
    <div class="form-group form-group-lg">

    <label class="col-sm-3 control-label">Parent Catagory? :</label>
      <div class="col-sm-9">
      <select name="parent">
               <option value="0">None</option>
               <?php
               $catvalues=getTableFrom("catagories","where parent=0");
               foreach($catvalues as $catvalue){
               ?>
               <option value="<?php echo $catvalue['catID']; ?>"><?php echo $catvalue['Name']; ?></option>
               <?php } ?>
           </select>
      </div>
    </div>


    <!-- visibility -->
    <div class="form-group form-group-lg">
      <label class="col-sm-3 control-label">visibile :</label>
      <div class="col-sm-9 col-md-6">
         <div> 
             <input id="vis-yes"type ="radio" name ="visibility" value=0 checked>
             <label  for="vis-yes">yes</label>
         </div>
         <div> 
             <input id="vis-no" type ="radio" name ="visibility" value=1 >
             <label for="vis-no">No</label>
         </div>
     </div>
    </div>
    <!-- Commenting  -->
    <div class="form-group form-group-lg">
      <label class="col-sm-3 control-label">Allow Commenting:</label>
      <div class="col-sm-9 col-md-6">
         <div> 
             <input id="com-yes"type ="radio" name ="Commenting" value=0 checked>
             <label  for="com-yes">yes</label>
         </div>
         <div> 
             <input id="com-no" type ="radio" name ="Commenting" value=1 >
             <label for="com-no">No</label>
         </div>
     </div>
    </div>
     <!-- Allow ADD  -->
     <div class="form-group form-group-lg">
      <label class="col-sm-3 control-label">Allow ads:</label>
      <div class="col-sm-9 col-md-6">
         <div> 
             <input id="ids-yes"type ="radio" name ="ads" value=0 checked>
             <label  for="ids-yes">yes</label>
         </div>
         <div> 
             <input id="ids-no" type ="radio" name ="ads" value=1 >
             <label for="ids-no">No</label>
         </div>
     </div>
    </div>
    <!-- submit -->
    <div class="form-group">

      <div class="col-sm-offset-3 col-sm-10">
       <input type="submit" value="Add " class="btn btn-primary btn-lg">
      </div>
    </div>
  </form>
</div>




<?php
} 
else if($do=='Insert'){
    // insete page
 

   if($_SERVER['REQUEST_METHOD']=="POST"){  // to check the information get from post request
    echo '<h1 class="text-center">Insert catagory</h1>';
    echo "<div class='container'>"; 
    $name= $_POST['name'];
     $desc= $_POST['description'];
     $order= $_POST['Ordering'];
     $parent= $_POST['parent'];
     $visible=$_POST['visibility'];
     $Comment=$_POST['Commenting'];
     $Ads=$_POST['ads'];
     
     
    //insert data
     $checkUser= checkItem("Name","catagories",$name);
     if(empty($name)){
        $message= "<div class='alert alert-danger'>sorry ,we must fill the name field</div>";
        redirectpage($message,"back.php",5);
     }
    else{
    if($checkUser==1){
     $msgs= "<div class='alert alert-danger'>sorry this catagory is already exist </div>";
     redirectpage($msgs,"back",5);
    }
    else if($checkUser==0){
    $stmt =$con->prepare("INSERT INTO catagories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Add,parent)
    values (:cname,:cdesc,:corder,:cvisible,:cComment,:cAds,:zparent)");
    $stmt->execute(array(
      'cname'=>$name,
      'cdesc'=>$desc,
      'corder'=>$order,
      'cvisible'=>$visible,
      'cComment'=>$Comment,
      'cAds'=>$Ads,
      'zparent'=>$parent
    ));
    if( $stmt->rowcount()>0){
     $message= "<div class ='alert alert-success'>Add successfuly</div>";
     redirectpage($message,"back",5);
    }
   }
  }
   }
   else{
     echo '<div class="container">';
       $message= "<div class='alert alert-danger'>sorry man you can't veiw page directly</div>";
       redirectpage($message,"index.php",5);
       echo '</div>'; 
      }
   echo "</div>";
  

} 
else if($do=='Edit'){
  //Edit page
  $catid=0; // default value
  if(isset($_GET['catID']) && is_numeric($_GET['catID'])){ //to check the value of id come from get request and in numric value
  $catid=intval($_GET['catID']);
  }

  $stmt=$con->prepare("select * from catagories where catID=? LIMIT 1");  //select all information of id value 
  $stmt->execute(array($catid));   
  $rowresult = $stmt->fetch(); //result of stmt
  $row=$stmt->rowCount();  // result number
  if($row>0){
  ?>

<h1 class="text-center">Edit Catagory</h1>
<div class="container">
  <form class="form-horizontal" action="?do=Update" method="POST">
  <input type="hidden" name ="catId" value="<?php echo $catid ?>">

    <!-- name -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label"> Name :</label>
          <div class="col-sm-9">
           <input type="text" name="name" class="form-control" autocomplete="off"  required="required" placeholder="Name of the catagory" value="<?php echo $rowresult['Name']; ?>">
          </div>
    </div>
    <!-- description -->
    <div class="form-group form-group-lg">
        <label class="col-sm-3 control-label">Description:</label>
           <div class="col-sm-9">
            <input type="text" name="description" class="form-control " autocomplete="new-password"  placeholder="describe the catagory" value="<?php echo $rowresult['Description']; ?> ">
          </div>
   </div>
    <!-- ordering -->
    <div class="form-group form-group-lg">

        <label class="col-sm-3 control-label">Ordering :</label>
          <div class="col-sm-9">
           <input type="text" name="Ordering" class="form-control" autocomplete="off" placeholder="number to arrange catagory" value="<?php echo $rowresult['Ordering']; ?> ">
          </div>
    </div>
    <!-- parent -->
   <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> parent:</label>
           <select name="parent">
           <?php
             $stmt2=$con->prepare("SELECT * from catagories where parent=0");
             $stmt2->execute();
             $catgs=$stmt2->fetchAll();
             echo "<option value='0'>none</option>";
             foreach($catgs as $catg){
                echo "<option value='".$catg['catID']."'";
                if($catg['catID']==$rowresult['parent']){
                  echo "selected";
                }
                echo ">".$catg['Name']."</option>";
             }
             ?>  
           </select>
     </div>

    <!-- visibility -->
    <div class="form-group form-group-lg">
      <label class="col-sm-3 control-label">visibile :</label>
      <div class="col-sm-9 col-md-6">
         <div> 
             <input id="vis-yes"type ="radio" name ="visibility" value=0 <?php if($rowresult['Visibility']==0) echo 'checked'; ?>>
             <label  for="vis-yes">yes</label>
         </div>
         <div> 
             <input id="vis-no" type ="radio" name ="visibility" value=1 <?php if($rowresult['Visibility']==1) echo 'checked'; ?>>
             <label for="vis-no">No</label>
         </div>
     </div>
    </div>
    <!-- Commenting  -->
    <div class="form-group form-group-lg">
      <label class="col-sm-3 control-label">Allow Commenting:</label>
      <div class="col-sm-9 col-md-6">
         <div> 
             <input id="com-yes"type ="radio" name ="Commenting" value=0  <?php if($rowresult['Allow_Comment']==0) echo 'checked'; ?>>
             <label  for="com-yes">yes</label>
         </div>
         <div> 
             <input id="com-no" type ="radio" name ="Commenting" value=1 <?php if($rowresult['Allow_Comment']==1) echo 'checked'; ?>>
             <label for="com-no">No</label>
         </div>
     </div>
    </div>
     <!-- Allow ADD  -->
     <div class="form-group form-group-lg">
      <label class="col-sm-3 control-label">Allow ads:</label>
      <div class="col-sm-9 col-md-6">
         <div> 
             <input id="ids-yes"type ="radio" name ="ads" value=0 <?php if($rowresult['Allow_Add']==0) echo 'checked'; ?>>
             <label  for="ids-yes">yes</label>
         </div>
         <div> 
             <input id="ids-no" type ="radio" name ="ads" value=1 <?php if($rowresult['Allow_Add']==1) echo 'checked'; ?>>
             <label for="ids-no">No</label>
         </div>
     </div>
    </div>
    <!-- submit -->
    <div class="form-group">

      <div class="col-sm-offset-3 col-sm-10">
       <input type="submit" value="Update " class="btn btn-primary btn-lg">
      </div>
    </div>
  </form>
</div>


  <?php
   }
   else{
     
    echo '<div class="container">';
    $message= "<div class='alert alert-danger'>sorry , this id not exist</div>";
    redirectpage($message,"index.php",5);
    echo '</div>'; 
  }
  } 

else if($do=='Update'){
  echo '<h1 class="text-center">Update Catagory</h1>';
  echo "<div class='container'>";
  if($_SERVER['REQUEST_METHOD']=="POST"){  // to check the information get from post request
    $catids=$_POST['catId'];
    $name= $_POST['name'];
    $desc= $_POST['description'];
    $order= $_POST['Ordering'];
    $pare= $_POST['parent'];
    $visible=$_POST['visibility'];
    $Comment=$_POST['Commenting'];
    $Ads=$_POST['ads'];

    
   //update data
   $stmt2=$con ->prepare("SELECT * FROM catagories WHERE Name=? AND catID!=?");
   $stmt2->execute(array($name,$catids));
    if( $stmt2->rowcount()==0){
    $stmt3=$con->prepare("UPDATE catagories SET Name=? , Description=? , Ordering=? ,Visibility=? ,Allow_Comment=?,Allow_Add=?, parent=? where catID=?");
    $stmt3->execute(array($name,$desc,$order,$visible,$Comment,$Ads,$pare,$catids));
    if( $stmt3->rowcount()>0){
    $message=  "<div class ='alert alert-success'>update successfuly</div>";
    redirectpage($message,"back",3); 
   }
  }
  else{
    echo '<div class="container">';
    $message=  "<div class ='alert alert-danger'>sorry this catagory name is already exist</div>";
    redirectpage($message,"back.php",3);
    echo '</div>'; 
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


else if($do=='Delete'){
  echo '<h1 class="text-center">Delete page</h1>';
  echo "<div class='container'>"; 
  $catid=0; // default value
if(isset($_GET['catID']) && is_numeric($_GET['catID'])){ //to check the value of id come from get request and in numric value
  $catid=intval($_GET['catID']);
}
 
  $nu= checkItem("catID","catagories",$catid);

if($nu>0){
   $stmt=$con->prepare("DELETE FROM catagories where catID=? ");  //delete user  
   $stmt->execute(array($catid));   
   $row=$stmt->rowCount();  // result number
 if($row>0){
  echo "<div class='container'>";
  $message= "<div class ='alert alert-success'>delete successfuly</div>";
  redirectpage($message,"back",3); 
  echo "</div";
}
}
else{
  echo "<div class='container'>";
 $message= "<div class ='alert alert-danger'>id not exest</div>";
 redirectpage($message,"index.php",5); 
 echo "</div";

}
 echo "</div";
}

include $passtpl."footer.php";
}
else {
header('location:index.php');
exit();
}
ob_end_flush();
?>