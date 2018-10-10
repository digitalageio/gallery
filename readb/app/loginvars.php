<?php 
$user = $_POST['user'];
$host = $_POST['host'];
$pswd = $_POST['pswd'];
$db = $_POST['db'];
if(!mysql_connect($host,$user,$pswd)){
	die();
}

if(!mysql_select_db($db)){
	die();
}
?>
