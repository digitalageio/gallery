<?php 
include('defaultcreds.php');
$last = mysql_query("SELECT pid FROM posvals WHERE {$_POST['category']} IS NULL LIMIT 1");
$pos = mysql_fetch_row($last);
if($pos[0]){
mysql_query("UPDATE posvals SET {$_POST['category']} = '{$_POST['newval']}' WHERE pid = {$pos[0]}");
} else mysql_query("INSERT INTO posvals ({$_POST['category']}) VALUES ('{$_POST['newval']}')");
?>
