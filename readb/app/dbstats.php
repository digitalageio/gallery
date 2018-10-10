<?php

$user = $_POST['user'];
$host = $_POST['host'];
$db = $_POST['db'];
$pswd = $_POST['pswd'];
$link = mysql_connect($host,$user,$pswd);
$status = explode("  ",mysql_stat($link));
print "<h1>Current Login: $user@$host</h1>";
print "<h1>Current Database: $db</h1>";
print "<h1>";
foreach($status as $num => $stat){
print "<h1>$stat</h1>";
}

?>








