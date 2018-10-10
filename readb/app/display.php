
<?php
include('loginvars.php');
unset($_POST['pswd']);
unset($_POST['host']);
unset($_POST['user']);
unset($_POST['db']);
if(array_key_exists('table',$_POST)){
	$table = $_POST['table'];
	unset($_POST['table']);
} else {
	$table = 'improved_sales';
}

if(array_key_exists('pos',$_POST)){
	$pos = $_POST['pos'];
	unset($_POST['pos']);
} else {
	$pos = 1;
}

if(array_key_exists('len',$_POST)){
	$len = $_POST['len'];
	unset($_POST['len']);
} else {
	$len = 1;
}

$primary_header = "id";
$secondary_header = "";
switch($table){
	case 'improved_sales':
		$secondary_header = "tax_id";
	break;
	case 'vacant_sales':
		$secondary_header = 'map_parcel';
	break;
	case 'sales_views':
		$secondary_header = 'orig_id';
	break;
	default:
	break;
}

$i = 0;
$order = array();
for($i = 0; $i < count($_POST); $i++){
	if(!empty($_POST[$i])){
	$order[$i] = $_POST['sortcol' . $i] . " " . $_POST[$i];
	unset($_POST[$i]);
	unset($_POST['sortcol' . $i]);
	}
}
$order = implode(', ',$order);

if(array_key_exists('filters',$_POST)){
	$filters = $_POST['filters'];
	unset($_POST['filters']);
} else $filters = null;

$query = array();

$fields = implode(",",$_POST); //last stop for POST
$query['fields'] = " SELECT $fields ";

$query['table'] = " FROM $table ";

if($filters){
	$query['where'] = " WHERE $filters ";
}
if($order != null){
	$query['order'] = " ORDER BY $order ";
}
if($pos == null){
	$pos = 0;
}
if($len == null){
	$len = 10;
}

$query['limit'] = " LIMIT $pos,$len";

$super_query = implode($query);
print $super_query . "<hr>";
$query2 = mysql_query($super_query);

?>
<script type="text/javascript" src="jquery-1.7.2.min.js" language="javascript"></script>
<script type="text/javascript" src="scrolltable-min.js" language="javascript"></script>
<script type="text/javascript" language="javascript">
	function bing(x){
		var allcells = document.getElementsByTagName("td");
		for(var i = 0; i < allcells.length; i++){
		allcells[i].style.backgroundColor = "white";
		}
		//row = x.parentNode.rowIndex;
		//column = x.cellIndex;
		row = $(x).parent().index();
		column = $(x).index();
		parcel = document.getElementById('displaytable').rows[row].cells;
		colid = $('#displaytable th.id').index();
		id = $('#displaytable tr').eq(row).find('td').eq(colid).html();
		columnpos = document.getElementById('displaytable').rows[0].cells;
		columnname = columnpos[column].innerHTML;
		cell = document.getElementById('displaytable').rows[row].cells;
		content = cell[column];
		content.style.backgroundColor = "red";
		document.getElementById('newvalue').value = "";
		document.getElementById('editbox').value = content.innerHTML;
}
		
</script>
<?php
print "<input type='hidden' id='super_query' value=\"{$super_query}\" />";
print "<table id='displaytable' border='.5'>";
print "<th id='colcheck'>  </th>";
foreach($_POST as $column => $name){
	print "<th class='{$_POST[$column]}'>{$_POST[$column]}</th>";
}
while($rows = mysql_fetch_assoc($query2)){
	print"<tr id=\"row_boxes\">";
	print "<td><input type='checkbox' name='{$rows['tax_id']}' value='{$rows['id']}'></td>";
foreach($rows as $record => $row){
	print "<td name=\"info\" onclick=\"bing(this)\">{$rows[$record]}</td>";
	}
	print "</tr>";
}


print "</table>";
?>

