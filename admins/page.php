<?php

//categories =>[manage|Edit|Update|Add|Insert|Delete|Stats]
$do='';
if(isset($_GET['do'])){

    $do=$_GET['do'];
}
else{
    $do='Manage';
}

//if the page is main page

if($do=='Manage'){
    echo 'welcome you are in Add Manage page <br>';
    echo '<a href="page.php?do=Add"> add new catagory</a> <br>';
    echo '<a href="page.php?do=Insert"> Insert new catagory</a>';

}

else if($do=='Add'){
    echo 'welcome you are in Add category page';
}
else if($do=='Insert'){
    echo 'welcome you are in Insert category page' ;
}
else {
    echo 'Error There\'s No page with This Name';
}
?>