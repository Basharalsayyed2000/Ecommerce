<?php
$dns='mysql:host=localhost;dbname=onlineshopping_zero';
$user='root';
$pass='';
$option=array(
PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8');
try{
$con=new PDO($dns,$user,$pass,$option);
$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOExeption $e){
echo '<br>failed to connect'.$e->getMessage();

}
?>