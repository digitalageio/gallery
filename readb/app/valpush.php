<?php 
include('defaultcreds.php');
if(mysql_query("INSERT INTO {$_POST['vid']} (parent) VALUE ('{$_POST['aid']}')")){
} else print mysql_error();
?>
