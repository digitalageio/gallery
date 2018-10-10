<?php

include("loginvars.php");
$idlist = array();
$blacklist = array("db",'divname','host','orig_table','pswd','user','view_name');
foreach($_POST as $mush => $room){
	if(!in_array($mush,$blacklist,'true')){
		$idlist[$mush] = $room;
	}
}
$view_name = $_POST['view_name'];
$orig_table = $_POST['orig_table'];
var_dump($blacklist);
var_dump($idlist);
foreach($idlist as $none => $number){	
	if(mysql_query("INSERT INTO sales_views (view_name, orig_table, tax_id, orig_id) VALUES('{$view_name}','{$orig_table}',{$none},'{$number}')")){
	} else print mysql_error();
}
?>
	

