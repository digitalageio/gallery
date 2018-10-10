<?php 
include('defaultcreds.php');
$round = mysql_query("SELECT * FROM {$_POST['vid']} WHERE parent = '{$_POST['aid']}'");
print "-----------------------------------------------------------------------------<br /><table name='{$_POST['vid']}'>";
while($again = mysql_fetch_assoc($round)){
	$posvals = array();
	print "<tr>";
	foreach($again as $vey => $kalue){
		if($vey == 'id' || $vey == 'parent'){
			break;
		}
		$mn = mysql_query("SELECT $vey FROM posvals");
		if($mn){
			while($op = mysql_fetch_row($mn)){
				if($op[0] != NULL){
					if($op[0] == $again[$vey]){
						array_push($posvals,"<option selected>{$op[0]}</option>");
					} else array_push($posvals,"<option>{$op[0]}</option>");
				}
			}
			$pvals = implode($posvals);	
			print "<td><select name='{$vey}' class='{$again['id']}' onchange='alterval(this)'>";
			print "<option></option>" . $pvals;
			print "</select></td>";
		} else print "<td><input type='text' name='{$vey}' class='{$again['id']}' size='30' value='{$again[$vey]}' onchange='alterval(this)' /></td>";
	}
	print "</tr>";
	//print "<input type='button' value='+' onclick='multival(),openvals()' />";
	//print implode(':',$again) . "<br />";
}
print "</table><input type='button' value='+' onclick='multival()' />";
?>
