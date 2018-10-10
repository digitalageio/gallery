<?php 
include('loginvars.php');
?>
<script type="text/javascript" src="selecttoggle.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript">
	function displayTable(TableSetup) {
		$("selection").submit(function() {
		alert($(this).serializeArray());
		});
	}

</script>
<?
$width = 85;
echo "<p id='position:fixed'>";
$table_query = mysql_query('SHOW TABLES FROM primarydb');
$i = 0;
$j = 0;
$a = 0;
$primary_tables = array( '1' => 'crs', '2' => 'gsmaor', '3' => 'kaar');
$progenitor = array('1' => 'lotcomp','2' => 'lettcomp','3' => 'streetcomp','4' => 'numcomp','5' => 'id','6' => 'filler','7' => 'blank');
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
$temp_tables = implode(', ',$primary_tables);
$post_tables = implode(',',$post_tables);
$count = count($tables);
$colpos = 0;
$colwidth = $width / $count;
echo "<div id='tables'>";
echo "<form enctype='multipart/form-data' name='selection' method='POST'>"; "new table name: ";
echo "<input type='hidden' name='tables' value='{$post_tables}'>";
echo "New table name: ";
echo "<input type='text' name='new_table_name' size=30>";
echo "<input type='submit' onclick=\"displayTable()\" value='submit'><br />";
echo "Current primary tables: {$temp_tables}";
echo "</p>";
foreach($tables as $a => $b){
	echo "<p style='position:absolute;top:10%;padding-left:20px;border-right:2px solid black;width:{$colwidth}%;left:{$colpos}%'>";
	echo "<b>{$tables[$a]}: </b><br />";
	echo "<input type='button' onclick=\"toggle('selection','{$tables[$a]}[]',true);\" value='select all' />";
	echo "<input type='button' onclick=\"toggle('selection','{$tables[$a]}[]',false);\" value='deselect all' />";
	if(array_search($tables[$a],$primary_tables)){
	} else {echo "<input type='button' name='droplabel_{$tables[$a]}' onclick=\"drop_flag_toggle('selection','droplabel_{$tables[$a]}','flag_{$tables[$a]}');\" value='drop:no' />";
		echo "<input type='hidden' name='flag_{$tables[$a]}' value='0' />";
	}
	echo "</p>";
	echo "<p style='position:absolute;top:20%;bottom:0px;padding-left:20px;width:{$colwidth}%;left:{$colpos}%;overflow-y:auto'>";
	foreach($columns[$a] as $key => $value){
		if(array_search($value,$progenitor)){
		} else echo "<input type ='checkbox' name='{$tables[$a]}[]' value='{$tables[$a]}.{$columns[$a][$key]}' />{$columns[$a][$key]}<br />";
	}
	$colpos += $colwidth + 2;
	echo "</p>";
}	
echo "</div>";	
?>
