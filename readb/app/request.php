<?php
include('loginvars.php');
$targetid = $_POST['id'];
$targetcolumn = $_POST['columnname'];
$replacementvalue = $_POST['newvalue'];
$currenttable = $_POST['currenttable'];
$request = "UPDATE $currenttable SET $targetcolumn = '$replacementvalue' WHERE id = '$targetid'"; 
if(mysql_query($request)){
print $request;
} else print mysql_error();
?>
