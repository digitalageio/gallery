<?php
include('defaultcreds.php');
$bat = mysql_query("SHOW COLUMNS FROM templates");
print "<form name='entryform'><input name='name' type='text' size='30'><select name='template'>";
while($man = mysql_fetch_row($bat)){
	if($man[0] == 'template_id'){
	} else print "<option>{$man[0]}</option>";
}
print "</select><input name='butt' type='button' value='Add' onclick='adder(this)'>";
print "<input type='hidden' name='parent' value='{$_POST['parent']}' /><input type='hidden' name='parcel' value='{$_POST['parcel']}'></form>";
?>
