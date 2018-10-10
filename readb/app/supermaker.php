<?php
include('defaultcreds.php');
$newtable = $_POST['newtable'];
$cols = array('col1' => "", 'col2' => "", 'col3' => "", 'col4' => "", 'col5' => "");
foreach($cols as $c => $o){
	if(empty($_POST[$c])){
		unset($cols[$c]);
		continue;
	}
	if(in_array($c,$_POST)){
		$cols[$c] = "{$_POST[$c]} VARCHAR(30), index({$_POST[$c]})";
	} else { $cols[$c] = "{$_POST[$c]} VARCHAR(30), index({$_POST[$c]}), FOREIGN KEY ({$_POST[$c]}) REFERENCES posvals({$_POST[$c]})";
		if(mysql_query("ALTER TABLE posvals ADD ({$_POST[$c]} VARCHAR(30), index({$_POST[$c]}))")){
		} else print mysql_error();
	}
}
$colsquery = "CREATE TABLE $newtable (" . implode(', ',$cols) . ", id MEDIUMINT NOT NULL AUTO_INCREMENT, parent MEDIUMINT NOT NULL, index(parent), FOREIGN KEY (parent) REFERENCES parentage(area_id), PRIMARY KEY(id))";
if(mysql_query($colsquery)){
} else print $colsquery . mysql_error();
//$tabquery = "INSERT INTO poscols VALUES ('$newtable')";
//if(mysql_query($tabquery)){
//} else print mysql_error();
?>

