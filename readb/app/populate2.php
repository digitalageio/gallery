<?php 
include('loginvars.php');
$table = $_POST['table'];
$fields = mysql_query("SELECT column_name FROM information_schema.columns WHERE table_name = '$table'");
print "<select name='copyfieldlist'>";
while($fieldlist = mysql_fetch_assoc($fields)){
	foreach($fieldlist as $i => $v){
		print "<option>{$fieldlist[$i]}</option>";
		}
	}
print "</select>";
?>
