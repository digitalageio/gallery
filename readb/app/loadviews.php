<?php 
	include("loginvars.php");
	
$views = mysql_query("SELECT view_name FROM sales_views GROUP BY view_name");
$www=0;
print "<ul id=\"viewlist\" style='overflow:scroll'>";
while($viewlist = mysql_fetch_array($views)){
	$www=0;
	for($www=0;$www<count($viewlist);$www+=2){
		print "<li>{$viewlist[$www]}</li>";	
	}
}
print "</ul>";
?>
