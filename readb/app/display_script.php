<html>
<body>
<?php
$db_host = '192.168.0.109';
$db_user = 'ashanno2';
$db_pwd = 'B_k1llington';

$database = 'blount_county';
$table = 'general_parcel_data';

if (!mysql_connect($db_host, $db_user, $db_pwd))
    die("Can't connect to database");

if (!mysql_select_db($database))
    die("Can't select database");

$result = mysql_query("SELECT * FROM {$table} WHERE assr_appr_code = 'A' LIMIT 3");
if (!$result) {
    die("Query to show fields from table failed");
}

$fields_num = mysql_num_fields($result);

echo "<h1>Table: {$table}</h1>";
echo "<table border='1'><tr>";

for($i=0; $i<$fields_num; $i++)
{
    $field = mysql_fetch_field($result);
    echo "<td>{$field->name}</td>";
}
echo "</tr>\n";

while($row = mysql_fetch_row($result))
{
    echo "<tr>";

       foreach($row as $cell)
        echo "<td>$cell</td>";

    echo "</tr>\n";
}
mysql_free_result($result);
?>
</body></html>
