<?php
include('defaultcreds.php');
//$and = mysql_query("SELECT super_id FROM parcels WHERE CONCAT(tax_map,grp,parcnum1,parcnum2,spec_int) = '{$_POST['parcel']}'");
//$then = mysql_fetch_row($and);
$there = mysql_query("SELECT area_name,area_id FROM parentage WHERE super_id = '{$_POST['parcel']}'");
print "<p><select id='allsec' onchange='expandtype(this)'><option></option>";
while($was = mysql_fetch_row($there)){
		print "<option value='{$was[1]}'>{$was[0]}</option>";
}
print "</select><input type='button' name='{$_POST['parcel']}' onclick='armaker(this)' value='+' /></p>";
print "Current Section Contents:<br />";
?>
