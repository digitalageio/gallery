<?php
include("loginvars.php");
mysql_query("SELECT * FROM sales_views WHERE view_name='{$_POST['divname']}'");

print "<div id='{$_POST['divname']}'>";
print "{$_POST['divname']}";
print "</div>";

?>
