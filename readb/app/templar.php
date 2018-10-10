<?php
include('defaultcreds.php');
$headers = mysql_query("SHOW COLUMNS FROM templates");
$content = mysql_query("SELECT * FROM templates");
print "<table border='1'>";
$count = mysql_num_rows($headers);
while($hed = mysql_fetch_row($headers)){
	if($hed[0] != 'template_id'){
	print "<th name='{$hed[0]}'>{$hed[0]}</th>";
	}
}
print "<th><input type='text' id='newtempcolumn' size='20' value='' onchange='tempc()'></th>";
while($cnt = mysql_fetch_assoc($content)){
	print "<tr>";
	foreach($cnt as $thing => $other){
		if($thing != 'template_id'){
			print "<td><input type='text' size='20'value='{$cnt[$thing]}' onchange='tempchange(this,{$cnt['template_id']})'></td>";
		}
	}
	print "<td name='td'><input type='text' readonly size='20' onchange='tempplus(this)'></td>";
	print "</tr>";
}
print "<tr>";
while($count > 1){
	print "<td name='td'><input type='text' size='20' value='' onchange='tempplus(this)'></td>";
	--$count;
}
print "<td anme='td'><input type='text' size='20' value='' readonly onchange='tempplus(this)'></td>";
print "</tr>";
print "</table>";
?>

