<?php
include('defaultcreds.php');
$riga = mysql_query("SELECT area_name,area_id FROM parentage WHERE parent = '{$_POST['aid']}'");
print "<p name='{$_POST['aid']}'><select name='{$_POST['aid']}' onchange='expandtype(this)'><option></option>";
while($marole = mysql_fetch_assoc($riga)){
	print "<option value='{$marole['area_id']}'>{$marole['area_name']}</option>";
}
print "</select><input type='button' name='{$_POST['aid']}' onclick='armaker(this)' value='+' /></p>";
print "<p name='{$_POST['aid']}'>--------------------------------------------------------------------------------<br />";
print "<select id='{$_POST['aid']}' name='currentc' onchange='openvals(this)'><option></option>";
$cols = mysql_query("SELECT col_name FROM poscols");
while($sss = mysql_fetch_row($cols)){
	$req = mysql_query("SELECT id FROM {$sss[0]} WHERE parent = '{$_POST['aid']}'");
	if($req){
		if(mysql_num_rows($req) > 0){
			print "<option>{$sss[0]}</option>";
		}
	}
}
print "</select><input type='button' onclick='valadder(this)' value='+' />";
print "<select id='columns' style='display:none'>";
$recols = mysql_query("SELECT col_name FROM poscols");
while($ttt = mysql_fetch_row($recols)){
	print "<option>{$ttt[0]}</option>";
}
print "</select>";
print "<input type='button' id='vlad' onclick='valpush(this)' value='Add' style='display:none'>";
print "<input type='button' name='off' onclick='valmaker(this)' value='Edit' /></p>";
?>


