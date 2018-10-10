<?php
include('defaultcreds.php');
if(mysql_query("INSERT INTO {$_POST['tab']} (parent) VALUES ('{$_POST['par']}')")){
	print "new {$_POST['tab']} added";
} else print mysql_error();
?>
