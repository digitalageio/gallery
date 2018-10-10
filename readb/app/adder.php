<?php 
include('defaultcreds.php');
if(mysql_query("INSERT INTO parentage (area_name,template_name,parent,super_id) VALUES ('{$_POST['name']}','{$_POST['template']}','{$_POST['parent']}','{$_POST['parcel']}')")){
	$newpar = mysql_insert_id();
	$temps = mysql_query("SELECT {$_POST['template']} FROM templates");
	while($tmp = mysql_fetch_row($temps)){
		print "INSERT INTO {$tmp[0]} (parent) VALUES ('{$newpar}')";
		if(mysql_query("INSERT INTO {$tmp[0]} (parent) VALUES ('{$newpar}')")){
		} else { 
			print mysql_error();
			continue;
			}
	}
} else print mysql_error();
?>
