<?php

//version function that print page title , if page don't have title it will print the default title
function printTitle(){
  global $pageTitle;
  if(isset($pageTitle)){
    echo $pageTitle;
  }
  else {
      echo 'Default';
  }
}


//function check user status
function checkUserStatus($user){
  global $con;
  $stmt=$con->prepare("select username, Regstatus from users where username=? and Regstatus=0 ");
  $stmt->execute(array($user));
  $row=$stmt->rowCount();
  return $row;
}



//function that get table from database version 1

function getTableFrom($table,$where=null,$orderBy=null){
  global $con;
  if($orderBy == null){
    $sql='';
   }
  else{
    $sql='ORDER BY '.$orderBy.' DESC';
  }
  $getAll=$con->prepare("SELECT  * FROM $table $where $sql");
  $getAll->execute();
  $rows= $getAll->fetchAll();
  return $rows;
}


//function that get items from database version 2

function getItem($where,$value,$apprv=null){
  global $con;
  if($apprv==null){
   $sql='AND Approve=1';
  }
  else{
    $sql=null;
  }
  $getitems=$con->prepare("SELECT  * FROM items where items.$where=? $sql  ORDER BY itemID DESC ");
  $getitems->execute(array($value));
  $rows= $getitems->fetchAll();
  return $rows;
}





//function that get result join between two table
function joinTable($select,$table1,$table2,$cond2){
  global $con;
  $stmt3=$con->prepare("SELECT $select FROM $table1 NATURAL JOIN $table2 where $cond2");
  $stmt3->execute();
  $result=$stmt3->fetchColumn();
  return $result;
}


/** version 2
 * redirect function
 * second before redirecting
 * echo  message
*/

function redirectpage($Msg , $url, $second =3){
  $page='';
if($url == 'index.php'){
$url='index.php';
$page='homepage';
}
else {
    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!== ''){
    $url=$_SERVER['HTTP_REFERER'];
    $page='previous page';
    }else{
    $url='index.php';
    $page='homepage';
    }
}
echo $Msg;
echo "<div class='alert alert-info'>wait , we will directed into $page after $second seconds.</div>";
header("refresh:$second;url=$url");
exit();
}




/*check  Items function version 1
  function that check if item in database or not
*/

function checkItem($select,$from,$value){
global $con;
$statement=$con->prepare("SELECT $select FROM $from WHERE $select = ?");
$statement->execute(array($value));
$rcount= $statement->rowCount();
  return $rcount;
}













/*
//version function that print page title , if page don't have title it will print the default title
function printTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
      echo $pageTitle;
    }
    else {
        echo 'Default';
    }
}
/** version 2
 * redirect function
 * second before redirecting
 * echo  message
*/
/*
function redirectpage($Msg , $url, $second =3){
  $page='';
if($url == 'index.php'){
$url='index.php';
$page='homepage';
}
else {
    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!== ''){
    $url=$_SERVER['HTTP_REFERER'];
    $page='previous page';
    }else{
    $url='index.php';
    $page='homepage';
    }
}
echo $Msg;
echo "<div class='alert alert-info'>wait , we will directed into $page after $second seconds.</div>";
header("refresh:$second;url=$url");
exit();
}

/*check  Items function version 1
  function that check if item in database or not
*/
/*
function checkItem($select,$from,$value){
global $con;
$statement=$con->prepare("SELECT $select FROM $from WHERE $select = ?");
$statement->execute(array($value));
$rcount= $statement->rowCount();
  return $rcount;
}

// count Number of Items version 2.0
function countItems($Item,$table,$cond){
   global $con;
   $stmt2=$con->prepare("SELECT COUNT($Item) FROM $table  $cond");
   $stmt2->execute();
   return  $stmt2->fetchColumn();
}

//function that get lastest items version 1

function getLastest($Item,$table, $limit=5,$order,$conds=null){
  global $con;
  $getstmt=$con->prepare("SELECT  $Item FROM $table $conds ORDER BY $order DESC LIMIT $limit");
  $getstmt->execute();
  $rows= $getstmt->fetchAll();
  return $rows;
}











// my work 
/*
**
**
**
*/

/*
//function that get result join between two table
function joinTable($select,$table1,$table2,$cond2){
  global $con;
  $stmt3=$con->prepare("SELECT $select FROM $table1 NATURAL JOIN $table2 where $cond2");
  $stmt3->execute();
  $result=$stmt3->fetchColumn();
  return $result;
}
function selectWithCondition($select,$from,$cond2){
  global $con;
  $stmt3=$con->prepare("SELECT $select FROM $from where $cond2");
  $stmt3->execute();
  $result=$stmt3->fetchColumn();
  return $result;
}
*/
?>