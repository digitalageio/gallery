<?php
include('defaultcreds.php');
$namen = array('tax_map','grp','parcnum1','parcnum2','spec_int','name','pri','sec','gen','spe');
$cs = "";
$vs = "";
foreach($namen as $na => $men){
	if($_POST[$namen[$na]]){
	print "<li>{$namen[$na]} : {$_POST[$namen[$na]]}</li>";
	$cs[$namen[$na]] = $namen[$na];
	$vs[$namen[$na]] = $_POST[$namen[$na]];
	}
}
$q = "INSERT INTO parcels (" . implode(',',$cs) . ") VALUES ('" . implode('\',\'',$vs) . "')";
print $q;
if(mysql_query($q)){
	print $q;
} else print mysql_error();
?>
