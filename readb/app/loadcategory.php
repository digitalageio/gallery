<?php
include('defaultcreds.php');
$q = "SELECT {$_POST['category']} FROM posvals";
$qq = mysql_query($q);
print "<select>";
while($go = mysql_fetch_array($qq)){
	if($go[0]){
	print "<option>{$go[0]}</option>";
	}
}
print "</select>";
?>

