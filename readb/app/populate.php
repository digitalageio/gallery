<?php 
include('loginvars.php');
$table = $_POST['table'];
$fields = mysql_query("SELECT column_name FROM information_schema.columns WHERE table_name = '$table'");
while($fieldlist = mysql_fetch_assoc($fields)){
	foreach($fieldlist as $i => $v){
		if($v == 'id' || $v == 'tax_id'){
		} else print "<input type='checkbox' name='{$fieldlist[$i]}' value='{$fieldlist[$i]}' onclick='changeList(this);loadDisplay()' />{$fieldlist[$i]}<br />";
		}
	}
?>
