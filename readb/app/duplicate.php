<?php
include('defaultcreds.php');
//Locate and copy targeted section
$assoc = mysql_query("SELECT * FROM parentage WHERE area_id='{$_POST['sec']}'");
$sec_prime = mysql_fetch_assoc($assoc);
//unset auto incremented array value 
unset($sec_prime['area_id']);
//gather tables list
$tables = mysql_query("SHOW TABLES FROM imp_desc");
$t = array();
//establish blacklisted tables and push remaining tables into array
$blacklist = array('parcels','parentage','poscols','posvals','templates');
while($tableau = mysql_fetch_row($tables)){
	if(!array_search($tableau[0],$blacklist)){
		array_push($t,$tableau[0]);
	}
}
$orig = $sec_prime['area_name'];









$i=1;
$area_ids = array();
for($i=1;$i < $_POST['count'];++$i){
	$sec_prime['area_name'] = $orig . $i;
	print "INSERT INTO parentage (" . implode(", ",array_keys($sec_prime)) . ") VALUES ('" . implode("', '", array_values($sec_prime)) . "')";
	if(!mysql_query("INSERT INTO parentage (" . implode(", ",array_keys($sec_prime)) . ") VALUES ('" . implode("', '", array_values($sec_prime)) . "')")){
		print mysql_error();
	}
	$area_ids[$i] = mysql_insert_id();
}

?>
