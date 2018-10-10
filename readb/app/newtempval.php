<?php 
include('defaultcreds.php');
$last = mysql_query("SELECT template_id FROM templates WHERE {$_POST['col']} IS NULL LIMIT 1");
$pos = mysql_fetch_row($last);
if($pos[0]){
	if(mysql_query("UPDATE templates SET {$_POST['col']} = '{$_POST['val']}' WHERE template_id = {$pos[0]}")){
	} else print mysql_error();
} else {
	if(mysql_query("INSERT INTO templates ({$_POST['col']}) VALUES ('{$_POST['val']}')")){
	} else print mysql_error();
}
?>
