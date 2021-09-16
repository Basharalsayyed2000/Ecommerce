
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
  <a class="navbar-brand" href="dashboard.php"><?php echo langua('HOME_ADMIN'); ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="catagories.php"><?php echo langua('CATAGORIES'); ?> </a></li>
      <li class="nav-item"><a class="nav-link" href="Items.php"><?php echo langua('ITEMS'); ?></a></li>
      <li class="nav-item"><a class="nav-link" href="members.php"><?php echo langua('MEMBERS'); ?></a></li>
      <li class="nav-item"><a class="nav-link" href="comments.php"><?php echo  langua('COMMENTS'); ?></a></li>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hamzi <span class=""></span></a>
          <ul class="dropdown-menu">
            <li><a href="members.php?do=Edit&id=<?php echo $_SESSION['ID']; ?>"><?php echo  langua('EDITPROFILE'); ?></a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="../index.php"><?php echo  langua('VISITSHOP'); ?></a></li>
            <li><a href="logout.php"><?php echo  langua('LOGOUT'); ?></a></li>
          </ul>
        </li>
    </ul>
  </div>
</div>
</nav>








