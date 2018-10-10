<?php
$filter = array();
foreach($_POST as $fil => $ter){
	$filter[$fil] = explode('&',$_POST[$fil]);
}
foreach($filter as $key => $value){
	foreach($filter[$key] as $one => $two){
		$var = explode('=',$filter[$key][$one]);
		if($var[0] == 'comp2'){
		$filter[$key][$one] = "'" . $var[1] . "'";
		} else $filter[$key][$one] = $var[1];
	}
	$filter[$key] = implode(" ",$filter[$key]);
}
print urldecode(implode(" ",$filter));
?>
