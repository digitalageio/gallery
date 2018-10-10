<?php 
include('loginvars.php');
$table_query = mysql_query("SHOW TABLES FROM $db");
$i = 0;
$j = 0;
$a = 0;
$primary_tables = array( '1' => 'crs', '2' => 'gsmaor', '3' => 'kaar');
//$progenitor = array('1' => 'lotcomp','2' => 'lettcomp','3' => 'streetcomp','4' => 'numcomp','5' => 'id','6' => 'filler','7' => 'blank');
while($things = mysql_fetch_array($table_query)){
	$tables[$i] = $things[0];
	$i++;
}

$post_tables = array_merge($primary_tables,$tables);
$post_tables = array_unique($tables);

foreach($tables as $key => $value){
	$request = mysql_query("SHOW COLUMNS FROM {$tables[$key]}");
	$k = 0;
	while($stuff = mysql_fetch_array($request)){
		$columns[$j][$k] = $stuff[0];
		$k++;
	}
	sort($columns[$j],SORT_STRING);
	$j++;
}

$post_tables = implode(',',$post_tables);
$count = count($tables);
$comparators = array('>'=> 'Greater Than', '<' => 'Less Than', '=' => 'Equals', 'REGEXP' => 'Matches', 'IN' => 'Contains', 'NOT IN' => 'Does Not Contain');
$width = 0;
print "<div id='query'>";
print "<form enctype='multipart/form-data' name='selection' method='POST' action='querydisplay.php'>";
print "SELECT ";
foreach($tables as $a => $b){
print "<select><option selected=\"selected\">      </option>";
	foreach($columns[$a] as $c => $d){
		print "<option>{$columns[$a][$c]}</option>";
	}
print "</select>";
}
print "<br /> FROM ";
print "<select><option>all tables</option>";
foreach($tables as $a => $b){
print "<option>{$tables[$a]}</option>";
}
print "</select>";
print "<br /> WHERE ";
print "<select>";
foreach($columns as $a => $b){
	foreach($columns[$a] as $c => $d){
	print "<option>{$columns[$a][$c]}</option>";
	}
}
print "</select>";
print "<br /> IS ";
print "<select>";
foreach($comparators as $e => $f){
	print "<option>{$comparators[$e]}</option>";
}
print "</select>";
print "<input type=text name='criteria' size=20>";

print "<p style='position:absolute;bottom:5%>";
print "<input type=submit name=submit value='Submit Query'>";
print "</form></p>";
print "</div>";
?>

