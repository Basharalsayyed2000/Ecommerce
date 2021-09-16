<!DOCTYPE html>
<html>
<head>
<title><?php printTitle();?></title>
<link rel="stylesheet" href="<?php echo $passcss;?>bootstrap.min.css">
<script src="<?php echo $passjs;?>jquery-3.5.1.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<link rel="stylesheet" href="<?php echo $passcss;?>fontawesome.min.css">
<link rel="stylesheet" href="<?php echo $passcss;?>frontend.css">
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
<div class="upper-bar">
   <div class="container">
     <?php
     if(isset($_SESSION['usrname'])){
       ?>
       <nav class="navbar navbar-expand-lg my-nav">
       <div class="btn-group my-info collapse navbar-collapse ">
        <img src="download.png" alt="" class="img-circle img-thumbnail">
         <span class="user-span">
           <?php echo $sessionUser;?>
           <ul class="navbar-nav mr-auto navbar-right">
             <?php
             if(isset($_SESSION['admin'])){
             echo "<li class='nav-item'><a href='admins/index.php' class='nav-link my-link'>Manage</a></li>";
             }
             ?>
            <li class='nav-item'><a href="profile.php" class='nav-link my-link'>My Profile</a></li>
            <li class='nav-item'><a href="newAds.php" class='nav-link my-link'>New Item</a></li>
            <li class='nav-item'><a href="profile.php#my-ads" class='nav-link my-link'>My Items</a></li>
            <li class='nav-item'><a href="logout.php" class='nav-link my-link'>logout</a></li>
           </ul>
           </span>
       </div>
       </nav>
       <?php
    }
     else{
      ?>
    <a href="login.php">
      <span class="pull-right">login / signUp</span>
    </a>
     <?php } ?>
  </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">

  <a class="navbar-brand" href="index.php">Homepage</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto ">
     <?php
      foreach(getTableFrom("catagories","where parent=0") as $catagory){
        echo  "<li class='nav-item'><a href='catagoriesItem.php?catname=".$catagory['Name']."&catid=".$catagory['catID']."' class='nav-link'>".$catagory['Name']."</a><li>";
      }
     ?>
    </ul>
    <form class="form-inline my-2 my-sm-0 navbar-right my-search">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
  </div>

</nav>
