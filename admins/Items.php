<?php
ob_start();
// you can manage Items 
session_start();

$pageTitle="Items"; // page title variable , will print using function

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
    $queryToAdd='';
   if(isset($_GET['approve'])&& $_GET['approve']=='Yes'){
     $queryToAdd="AND Approve=0";
   }
   $stmt=$con->prepare("select * from items $queryToAdd ORDER BY itemID DESC "); // select all user except admin
   $stmt->execute(); // execute statement
   $rows= $stmt->fetchAll();
   if(!empty($rows)){
?>
<h1 class="text-center">Manage Items</h1>
<div class="container">
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
    <tr>
      <td> #ID </td>
      <td> itemName </td>
      <td> itemDescription </td>
      <td> price </td>
      <td> cost </td>
      <td> discount </td>
      <td> Date </td>
      <td> country </td>
      <td> status </td>
      <td> username</td>
      <td> catagory </td>
      <td> control </td>

  </tr> 
  <?php
  foreach($rows as $r){
    $usernam=joinTable("username","users","items","items.itemID=".$r['itemID']."");
    $catago=joinTable("Name","catagories","items","items.itemID=".$r['itemID']."");
    echo " <tr>";
    echo "<td>". $r['itemID']."</td>";
    echo "<td>". $r['itemName']."</td>";
    echo "<td>". $r['itemDescription']."</td>";
    echo "<td>". $r['price']."</td>";
    echo "<td>". $r['cost']."</td>";
    echo "<td>". $r['discount']."</td>";
    echo "<td>". $r['addDate']."</td>";
    echo "<td>". $r['madeCountry']."</td>";
    echo "<td>";
    if( $r['status']==1)
    {
      echo "like New";
    }
    if( $r['status']==2)
    {
      echo "Used";
    }
     if( $r['status']==3)
    {
      echo "Old";
    } 
    if( $r['status']==4)
    {
      echo "very Old";
    } 
    if( $r['status']==5)
    {
      echo "New";
    }
    echo "<td>". $usernam ."</td>";
    echo "<td>".  $catago ."</td>";
    echo "</td>";

   echo "<td>" . "<a href='Items.php?do=Edit&itemid=". $r['itemID'] ."' class='btn btn-success'><i class='fa fa-edit'> </i>Edit </a> " ;
   echo "<a href='Items.php?do=Delete&itemid=". $r['itemID'] ."' class='btn btn-danger confirm'><i class='fa fa-times'> </i> Delete </a>";
  if($r['Approve']==0)
   {
    echo "<a href='Items.php?do=Approve&itemid=". $r['itemID'] ."' class='btn btn-info Activate'><i class='fa fa-user-check'> </i> Approve </a>";
  }
   echo "  </td>";

    echo " </tr>";
    
  }
    ?>
 
        </table>
        </div>
        <?php
      }else{
        echo '<h1 class="text-center">There is no Items</h1>' ;
        echo '<div class="container">';
      }
      ?>
  
  <a href='Items.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Items</a>
</div>

<?php





  }
  else if($do=='Add'){
   $count= countItems("catID","catagories","");
    if($count==0){
      header('location:catagories.php?do=Add&mass=you must add catagory'); 
    }
    ?>
    <h1 class="text-center">Add new Item</h1>
 <div class="container">
   <form class="form-horizontal" action="?do=Insert" method="POST">
        
     <!-- name -->
     <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> Name :</label>
           <div class="col-sm-9">
            <input type="text" name="name" class="form-control" autocomplete="off"  placeholder="Name of the Item" required='required'>
           </div>
     </div>
    <!-- Description -->
    <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> Description:</label>
           <div class="col-sm-9">
            <input type="text" name="Description" class="form-control" autocomplete="off"  placeholder="Description of the Item">
           </div>
     </div>
      <!-- price -->
    <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> price:</label>
           <div class="col-sm-9">
            <input type="text" name="price"  class="form-control" autocomplete="off"  placeholder="price of the Item" required='required'>
           </div>
     </div>
        <!-- cost -->
    <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> cost:</label>
           <div class="col-sm-9">
            <input type="text" name="cost"  class="form-control" autocomplete="off"  placeholder="cost of the Item" required='required'>
           </div>
     </div>
        <!-- discount -->
    <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> discount:</label>
           <div class="col-sm-9">
            <input type="text" name="discount"  class="form-control" autocomplete="off"  placeholder="discount">
           </div>
     </div>
        <!-- country -->
    <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> country:</label>
           <div class="col-sm-9">
            <input type="text" name="country"  class="form-control" autocomplete="off"  placeholder="country of made" required='required'>
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
           <option value="0">...</option>
               <option value="1">like New</option>
               <option value="2">Used</option>
               <option value="3">Old</option>
               <option value="4">very old</option>
               <option value="5">New</option>
           </select>
     </div>
     
   <!-- members -->
   <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> memeber:</label>
           <select name="member">
           <option value="0">...</option>
             <?php
             $stmtm=$con->prepare("SELECT * from users");
             $stmtm->execute();
             $users=$stmtm->fetchAll();
             foreach($users as $user){
                echo "<option value='".$user['userID']."'>".$user['username']."</option>";
             }
             ?>
           </select>
     </div>
   <!-- catagory -->
   <div class="form-group form-group-lg">
         <label class="col-sm-3 control-label"> catagory:</label>
           <select name="catagory">
           <option value="0">...</option>
           <?php
             $stmt2=$con->prepare("SELECT * from catagories");
             $stmt2->execute();
             $catgs=$stmt2->fetchAll();
             foreach($catgs as $catg){
                echo "<option value='".$catg['catID']."'>".$catg['Name']."</option>";
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
 
 
 
 
 <?php

} else if($do=='Insert'){
    // insete page
 

    if($_SERVER['REQUEST_METHOD']=="POST"){  // to check the information get from post request
      echo '<h1 class="text-center">Insert page</h1>';
      echo "<div class='container'>"; 
      $Iname= $_POST['name'];
       $Idesc= $_POST['Description'];
       $Iprice= $_POST['price'];
       $Icost=$_POST['cost'];
       $Idiscount=$_POST['discount'];
       $Icountry=$_POST['country'];
       $Istatus=$_POST['status'];
       $userId=$_POST['member'];
       $catId=$_POST['catagory'];
       $tags=$_POST['Tags'];
       //validate the form
       $formErrors=array();
  
       if(empty($Iname)){
        $formErrors[]= "<div class='alert alert-danger'>name can't be empty</div>";
       }
       if(empty($Iprice)){
        $formErrors[]= "<div class='alert alert-danger'>price can't be empty</div>";
       }
       if(empty($Icost)){
        $formErrors[]= "<div class='alert alert-danger'>cost can't be empty</div>";
      }
      if(empty($Icountry)){
        $formErrors[]= "<div class='alert alert-danger'>FullName can't be empty</div>";
      }
      if($Istatus==0){
        $formErrors[]= "<div class='alert alert-danger'>you must choose a status</div>";
      }
      if($userId==0){
        $formErrors[]= "<div class='alert alert-danger'>you must choose a user</div>";
      }
      if($catId==0){
        $formErrors[]= "<div class='alert alert-danger'>you must choose a catagory</div>";
      }
      // loop for print error
      foreach($formErrors as $error){
        redirectpage($error,"back",5);
      }
      //insert data
       if(empty($formErrors)){
      
       $stmt =$con->prepare("INSERT INTO items(itemName,itemDescription,price,addDate,madeCountry,status,cost,discount,catID,userID,tags)
        values (:iname,:idesc,:iprice,:iDate,:icountry,:istatus,:icost,:idiscount,:zcat,:zuser,:ztags)");
        $stmt->execute(array(
         'iname'=>$Iname,
         'idesc'=>$Idesc,
         'iprice'=>$Iprice,
         'iDate'=>date('Y-m-d'),
         'icountry'=>$Icountry,
         'istatus'=>$Istatus,
         'icost'=>$Icost,
         'idiscount'=>$Idiscount,
         'zuser'=>$userId,
         'zcat'=>$catId,
         'ztags'=>$tags
        ));
        if( $stmt->rowcount()>0){
        $message= "<div class ='alert alert-success'>Add successfuly</div>";
        redirectpage($message,"back",5);
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

  $itemid=0; // default value
  if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){ //to check the value of id come from get request and in numric value
  $itemid=intval($_GET['itemid']);
  }

  $stmt=$con->prepare("select * from items where itemID=? LIMIT 1");  //select all information of id value 
  $stmt->execute(array($itemid));   
  $rowresult = $stmt->fetch(); //result of stmt
  $row=$stmt->rowCount();  // result number
  if($row>0){
  ?>

<h1 class="text-center">Edit Item</h1>
<div class="container">
 <form class="form-horizontal" action="?do=Update" method="POST">
 <input type="hidden" name ="itemId" value="<?php echo $itemid ?>">

  <!-- name -->
  <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> Name:</label>
           <div class="col-sm-10">
            <input type="text" name="name" class="form-control" autocomplete="off"  placeholder="" required='required' value="<?php echo $rowresult['itemName']; ?>">
           </div>
     </div>
    <!-- Description -->
    <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> Description:</label>
           <div class="col-sm-10">
            <input type="text" name="Description" class="form-control" autocomplete="off"  placeholder="" value="<?php echo $rowresult['itemDescription']; ?>" >
           </div>
     </div>
      <!-- price -->
    <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> price:</label>
           <div class="col-sm-10">
            <input type="text" name="price"  class="form-control" autocomplete="off"  placeholder="" required='required' value="<?php echo $rowresult['price']; ?>">
           </div>
     </div>
        <!-- cost -->
    <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> cost:</label>
           <div class="col-sm-10">
            <input type="text" name="cost"  class="form-control" autocomplete="off"  placeholder="" required='required' value="<?php echo $rowresult['cost']; ?>">
           </div>
     </div>
        <!-- discount -->
    <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> discount:</label>
           <div class="col-sm-10">
            <input type="text" name="discount"  class="form-control" autocomplete="off"  placeholder="" value="<?php echo $rowresult['discount']; ?>">
           </div>
     </div>
        <!-- country -->
    <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> country:</label>
           <div class="col-sm-10">
            <input type="text" name="country"  class="form-control" autocomplete="off"  placeholder="" required='required' value="<?php echo $rowresult['madeCountry']; ?>">
           </div>
     </div>
      <!-- Tags -->
      <div class="form-group form-group-lg">
        <label class="col-sm-2 control-label"> Tags:</label>
            <div class="col-sm-10">
               <input type="text" name="Tags"  class="form-control" autocomplete="off"  placeholder="" value="<?php echo $rowresult['tags']; ?>">
            </div>
       </div>
      <!-- status -->
    <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> status:</label>
           <select name="status">
               <option value="1" <?php if($rowresult['status']==1) echo 'selected'; ?>>like New </option>
               <option value="2" <?php if($rowresult['status']==2) echo 'selected'; ?>>Used</option>
               <option value="3" <?php if($rowresult['status']==3) echo 'selected'; ?>>Old</option>
               <option value="4" <?php if($rowresult['status']==4) echo 'selected'; ?>>very old</option>
               <option value="5" <?php if($rowresult['status']==5) echo 'selected'; ?>>New</option>
           </select>
     </div>
   <!-- members -->
   <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> memeber:</label>
           <select name="member">
             <?php
             $stmtm=$con->prepare("SELECT * from users");
             $stmtm->execute();
             $users=$stmtm->fetchAll();
             foreach($users as $user){
                echo "<option value='".$user['userID']."'";
               if($rowresult['userID']==$user['userID']) echo 'selected'; 
               echo ">".$user['username']."</option>";
             }
             ?>
           </select>
     </div>
   <!-- catagory -->
   <div class="form-group form-group-lg">
         <label class="col-sm-2 control-label"> catagory:</label>
           <select name="catagory">
           <?php
             $stmt2=$con->prepare("SELECT * from catagories");
             $stmt2->execute();
             $catgs=$stmt2->fetchAll();
             foreach($catgs as $catg){
              echo "<option value='".$catg['catID']."'";
              if($rowresult['catID']==$catg['catID']) echo 'selected'; 
              echo ">".$catg['Name']."</option>";
             }
             ?>  
           </select>
     </div>
 
     <!-- submit -->
     <div class="form-group">
       <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" value="Update Item" class="btn btn-primary btn-sm">
       </div>
     </div>
 </form>

<?php
 $stmt=$con->prepare("select * from comments where itemID=$itemid"); // select comment of this item
   $stmt->execute(); // execute statement
   $rows= $stmt->fetchAll();
   if(!empty($rows))
{
?>
<h1 class="text-center">Manage [<?php echo $rowresult['itemName']; ?>] Comments</h1>
   <div class="table-responsive">
    <table class="main-table text-center table table-bordered">
    <tr>
      <td> Comment </td>
      <td> User Name </td>
      <td> Added Date </td>
      <td> Control </td>
     
  </tr> 
  <?php
  foreach($rows as $r){
    $userResult=joinTable("username","users","comments","comments.cID=".$r['cID']."");
    echo " <tr>";
    echo "<td>". $r['comment']."</td>";
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
}else {
  echo "<h1 class='text-center'>item [". $rowresult['itemName']."] has no Comments</h1>";
}
    ?>
  </table>
</div>

  <?php
   }
   else{

     $message= "<div class='alert alert-danger'>sorry , this id not exist</div>";
     redirectpage($message,"index.php",5); 
  }

}else if($do=='Update'){
  echo '<h1 class="text-center">Update Items</h1>';
  echo "<div class='container'>";
  if($_SERVER['REQUEST_METHOD']=="POST"){  // to check the information get from post request
       $Iname= $_POST['name'];
       $Idesc= $_POST['Description'];
       $Iprice= $_POST['price'];
       $Icost=$_POST['cost'];
       $Idiscount=$_POST['discount'];
       $Icountry=$_POST['country'];
       $Istatus=$_POST['status'];
       $userId=$_POST['member'];
       $catId=$_POST['catagory'];
       $ITEMid=$_POST['itemId'];
       $Itags=$_POST['Tags'];
     //validate the form
     $formErrors=array();
  
     if(empty($Iname)){
      $formErrors[]= "<div class='alert alert-danger'>name can't be empty</div>";
     }
     if(empty($Iprice)){
      $formErrors[]= "<div class='alert alert-danger'>price can't be empty</div>";
     }
     if(empty($Icost)){
      $formErrors[]= "<div class='alert alert-danger'>cost can't be empty</div>";
    }
    if(empty($Icountry)){
      $formErrors[]= "<div class='alert alert-danger'>FullName can't be empty</div>";
    }
    // loop for print error
    foreach($formErrors as $error){
      redirectpage($error,"back",5);
    }
   //update data
     if(empty($formErrors)){
     $stmt=$con->prepare("UPDATE items SET itemName=? , itemDescription=? , price=? ,status=? ,cost=?,discount=?,catID=?,userID=?,madeCountry=? ,tags=? where itemID=?");
     $stmt->execute(array($Iname,$Idesc,$Iprice,$Istatus,$Icost,$Idiscount,$catId,$userId, $Icountry,$Itags,$ITEMid));
     if( $stmt->rowcount()>0)
     $message=  "<div class ='alert alert-success'>update successfuly</div>";
     redirectpage($message,"back",5); 
    }
 }
  else{
    $message=  "<div class ='alert alert-danger'>sorry man you can't browse this page</div>";
    redirectpage($message,"index.php",5);     
     }
  echo "</div>";
}


else if($do=='Delete'){
  echo '<h1 class="text-center">Delete page</h1>';
  echo "<div class='container'>"; 
  $itemid=0; // default value
if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){ //to check the value of id come from get request and in numric value
  $itemid=intval($_GET['itemid']);
}
 
  $nu= checkItem("itemID","items",$itemid);

if($nu>0){
   $stmt=$con->prepare("DELETE FROM items where itemID=? ");  //delete user  
   $stmt->execute(array($itemid));   
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
else if($do=='Approve'){

  echo '<h1 class="text-center">Approve page</h1>';
  echo "<div class='container'>"; 
  $itemid=0; // default value
if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])){ //to check the value of id come from get request and in numric value
  $itemid=intval($_GET['itemid']);
}
 
  $nu= checkItem("itemID","items",$itemid);

if($nu>0){
  $stmt=$con->prepare("UPDATE items SET Approve=1 where itemID=? ");  //delete user  
  $stmt->execute(array($itemid));   
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
include $passtpl."footer.php";
}
else {
header('location:index.php');
exit();
}
ob_end_flush();
?>