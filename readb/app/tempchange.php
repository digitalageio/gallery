<?php
include('defaultcreds.php');
mysql_query("UPDATE templates SET {$_POST['col']} = '{$_POST['val']}' WHERE template_id = {$_POST['ind']}");
?>
