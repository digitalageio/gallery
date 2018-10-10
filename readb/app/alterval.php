<?php
include('defaultcreds.php');
if(mysql_query("UPDATE {$_POST['tab']} SET {$_POST['col']} = '{$_POST['con']}' WHERE id = '{$_POST['id']}' LIMIT 1")){
} else print mysql_error();
?>
