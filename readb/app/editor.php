
<?php
include('loginvars.php');
$tablefetch = mysql_query("SHOW TABLES FROM $db");
while($row = mysql_fetch_row($tablefetch)){
	$tablelist[] = $row[0];
}

?>
<?php //<script type="text/javascript" src="jquery.min.js" language="javascript"></script> ?>
<script type="text/javascript">
/*	function bing(x){
		var allcells = document.getElementsByTagName("td");
		for(var i = 0; i < allcells.length; i++){
		allcells[i].style.backgroundColor = "white";
		}
		row = x.parentNode.rowIndex;
		column = x.cellIndex;
		parcel = document.getElementById('displaytable').rows[row].cells;
		var parcelid = parcel[<?php print $parcelpos; ?>].innerHTML;
		var columnpos = document.getElementById('displaytable').rows[0].cells;
		var columnname = columnpos[column].innerHTML;
		var cell = document.getElementById('displaytable').rows[row].cells;
		var content = cell[column].innerHTML;
		document.getElementById('editor').innerHTML = content;
} */
	function loadDisplay(){
		if(document.getElementsByName('id')){
			document.getElementsByName('id').checked = true;
		}
		if(document.getElementsByName('tax_id')){
			document.getElementsByName('tax_id').checked = true;
		}
		document.getElementById('display').innerHTML = "";
		creds = $("#creds").serializeArray();
		input = $("#toolbar").serializeArray();
		labels = $("#fieldlist input:checked").serializeArray();
		params = creds.concat(input,labels);
		$.ajax({
			url: './display.php',
			type: 'POST',
			dataType: "html",
			data: params,
			success: function (show) {
				$("#display").html(show);
				}
			})
}

	function populateList(){
		makelist = creds.concat(input);
		$.ajax({
			url: './populate.php',
			type: 'POST',
			dataType: "html",
			data: makelist,
			success: function (list) {
				$("#fieldlist").html(list);
				}
			})

}
	function mysqlRequest(){
		newvalue = document.getElementById('newvalue').value;
		tableindex = document.getElementById('table').selectedIndex;
		tablelist = document.getElementById('table');
		var currenttable = tablelist[tableindex].text;
		bam = creds;
		bam.push({ name: 'currenttable', value: currenttable});
		bam.push({ name: 'id', value: id});
		bam.push({ name: 'columnname', value: columnname});
		bam.push({ name: 'newvalue', value: newvalue});
	//	alert(tablelist[tableindex].text + ":" + parcelid +":"+ columnname +":"+ newvalue);
		$.ajax({
			url: './request.php',
			type: 'POST',
			dataType: "html",
			data: bam,
			success: function (line){
				alert(line);
				}
			})
}
</script>
<div id='editor'>
<p id="display">
</p>

<form enctype="multipart/form-data" id="toolbar" method="POST">Table<br />
<select id="table" name="table" onchange="loadDisplay();populateList()">
<option>	</option>;
<?php foreach($tablelist as $key => $value){
	print "<option>$value</option>";
}?>
</select><br />
<br />Record Position
<br />
<input name="pos" type="text" onchange="loadDisplay()" size="6"><br />
<br />Number of Records
<input name="len" type="text" onchange="loadDisplay()" size="4"><br />
<br />Cell Content
<textarea id="editbox" name="editbox" rows=1 cols=15></textarea><br />
<br />New Content
<input type="text" id="newvalue" name="newvalue" size=15><br />
<input type="button" name="change" id="change" value="Edit" onclick="mysqlRequest();loadDisplay()"><br />
<br /></form>
<form enctype="multipart/form-data" id="fieldlist" onchange="loadDisplay()" style="white-space:nowrap;right:0;width:10em;overflow:scroll;height:10em" method="POST">
</form>
</div>
