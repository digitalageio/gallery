<?php
include('defaultcreds.php');
mysql_query("ALTER TABLE templates ADD ({$_POST['value']} VARCHAR(30), FOREIGN KEY ({$_POST['value']}) REFERENCES poscols(col_name))");
?>
