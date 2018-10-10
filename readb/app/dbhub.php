<!DOCTYPE html> 
<?php 
	//PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	//"http://w3.org/TR/xhtml1-transitional.dtd">

//AUTOMATICALLY LOGS IN AS ROOT !--EDIT BEFORE BETA TESTING--!
include("loginvars.php");
/*
if($_POST['user']){
	$user = $_POST['user'];
} else print("Invalid Login.");

if($_POST['pswd']){
	$pswd = $_POST['pswd'];	
} else print("Invalid Login.");

if($_POST['host']){
	$host = $_POST['host'];
} else print("Invalid Login.");

if($_POST['db']){
	$db = $_POST['db'];
} else print("Invalid Login.");


$link = mysql_connect($host,$user,$pswd);
if(!$link){
	die();
}

if(!mysql_select_db($db)){
	die();
}*/
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta charset="UTF-8" />
	<title>REA,Inc. -- Database Hub</title>
<script type="text/javascript" src="jquery-1.7.2.min.js" language="javascript"></script>
<!--script type="text/javascript" src="selecttoggle.js"></script--!>
<form enctype="multipart/form-data" id="creds" method="POST"> 
<input type="hidden" name="user" value=<?php echo $user; ?>>
<input type="hidden" name="host" value=<?php echo $host; ?>>
<input type="hidden" name="db" value=<?php echo $db; ?>>
<input type="hidden" name="pswd" value=<?php echo $pswd; ?>>
</form>
<script type="text/javascript" language="javascript">
	var thegoodstuff = $("#creds").serializeArray();
	//setInterval( "getStats()", 30000 );

	var parameters = new Array();
	var super_query = "";
	var cols = new Array();
	var sorts = new Array();
	var lims = new Array();
	var filters = "";
	function loadDisplay(){
		cols = $('#arrangedcolumns').serializeArray();
		sorts = $('#sortfl').serializeArray();
		lims = $('#limitfilters').serializeArray();
/*		if(document.getElementsByName('id')){
			document.getElementsByName('id').checked = 'true';
		}
		if(document.getElementsByName('tax_id')){
			document.getElementsByName('tax_id').checked = 'true';
		}*/
		document.getElementById('display').innerHTML = "";
		var Parpar = thegoodstuff.concat(cols,sorts,lims);
		Parpar.push({ name: 'filters', value: filters });
		$.ajax({		
				url: './display.php',
				type: 'POST',
				dataType: 'html',
				data: Parpar,
				success: function(show){
					$('#display').html(show);
					}
			})
	}

			function loadViews(){
		$.ajax({
				url: './loadviews.php',
				type: 'POST',
				dataType: "html",
				data: thegoodstuff,
				success:function (viewlist){
					$("#viewer").html(viewlist);
					}
			})
	}

	function getStats(){
		$.ajax({
				url: './dbstats.php',
				type: 'POST',
				dataType: "html",
				data: thegoodstuff,
				success: function (reply) {
					$("#stats").html(reply);
				}
			})
	}
/*
	function embolden(index){
		var spot = "ul li:eq(" + index + ")";
			$(spot).css({"font-size":"125%"});
	}
	
	function unbolden(index){
		var spot = "ul li:eq(" + index + ")";
			$(spot).css({"font-size":"100%"});
	}
*/
	function makeView(){
		var vname = document.getElementById('viewname').value;
		var selection = $('#row_boxes input:checked').serializeArray();
		var agh = [];
		agh.push({ name: 'view_name', value: vname });
		agh.push({ name: 'orig_table', value: parameters['table'] });
		var viewParams = thegoodstuff.concat(agh,selection);
		$.ajax({
				url: './makeview.php',
				type: 'POST',
				dataType: "html",
				data: viewParams,
				success: function (viewview) {
					if(response != '') 
					{
					alert(viewview);
					}
				}
		})	
	}

		var table = new Array();
	function switchTables(){
		var t = document.getElementById('tableswitch');
		$('#arrangedcolumns').html("<li><input type='text' name='id' value='id' readonly /><input type='button' value='+' onclick='bumpUp(this)' /><input type='button' value='-' onclick='bumpDn(this)' /></li><li><input type='text' name='tax_id' value='tax_id' readonly /><input type='button' value='+' onclick='bumpUp(this)' /><input type='button' value='-' onclick='bumpDn(this)' /></li>");
		parameters['table'] = t.options[t.selectedIndex].value;
		table.length = 0;
		table = thegoodstuff.slice(0);
		table.push({ name: 'table', value: parameters['table'] });
	}

		var fields = new Array();
	function loadFields(){
		$.ajax({ 
				url: './populate.php',
				type:'POST',
				dataType:"html",
				data: table,
				success: function(t){
					$('#columns').html(t);
					}
		})
		$.ajax({
				url: './populate2.php',
				type: 'POST',
				dataType: 'html',
				data: table,
				success: function(t){
					$('#totalfieldlist').html(t);
					}
			})
	}

	function choose(d){
		var e = document.getElementById(d);
		$(e).toggle();		
	}
	
	function logout(){
		window.document.location="./index.php";
	}

	function changeList(hips){
		var namen = $(hips).attr("name");
		var sw = hips.checked;
		switch(sw){
		case true:
			$('#arrangedcolumns').append("<li><input type='text' name='" + namen + "' value='" + namen + "' readonly /><input type='button' value='+' onclick='bumpUp(this)' /><input type='button' value='-' onclick='bumpDn(this)' /></li>");
		break;
		case false:
			$("#arrangedcolumns input[value='" + namen + "']").parent().remove();
		break;
		default:
		break;
		}
	}

	function bumpUp(these){
		var btt = $(these).parent().prev();
		var butt = $(these).parent();
		$(butt).insertBefore(btt);
		loadDisplay();
	}

	function bumpDn(these){
		var btt = $(these).parent().next();
		var butt = $(these).parent();
		$(butt).insertAfter(btt);
		loadDisplay();
	}

	function addSort(){
		var c = $('#sortfl li').length;
		$('#sortfl').append("<li><input type='radio' name='" + c + "' value='ASC' onclick='setParam(this)' />Ascending<input type='radio' name='" + c + "' value='DESC' onclick='setParam(this)' />Descending <select name='sortcol" + c + "'></select></li>");
		var names = new Array();	
		$("#arrangedcolumns input[type='text']").each(function(){ names.push('<option>' + $(this).attr("name") + '</option>');
								});
		$('#sortfl select').html(names.join(""));
	}

	function subSort(){
		$('#sortfl li:last').remove();
	}

	function addFilter(){
		var c = $('#appliedfilters form').length;
		if(c == 0){
			$('#appliedfilters').append("<form enctype='multipart/form-data' method='POST'>" + $('#totalfieldlist').html() + $('#comparison').html() + "<input type='text' name='comp2' size='30'></form>");
		}  else $('#appliedfilters').append("<form enctype='multipart/form-data' method='POST'>" + $('#gate').html() + $('#totalfieldlist').html() + $('#comparison').html() + "<input type='text' name='comp2' size='30'></form>");
	}

	function subFilter(){
		$('#appliedfilters form:last').remove();
	}

		var grotto = new Array();
	function loadFilters(){
		grotto = [];
		var i = 0;
		$('#appliedfilters form').each( function(){
			filters = $(this).serialize();
			grotto.push({ name: 'filter' + i, value: filters });
			i++;
			});
		$.ajax({
			url: './something.php',
			type: 'POST',
			dataType: 'html',
			data: grotto,
			success: function(y){
				filters = y;
			}
		})
	}
	
	function mysqlRequest(){
		newvalue = document.getElementById('newvalue').value;
		currenttable = parameters['table'];
		bam = $('#creds').serializeArray();
		bam.push({ name: 'currenttable', value: currenttable });
		bam.push({ name: 'id', value: id });
		bam.push({ name: 'columnname', value: columnname });
		bam.push({ name: 'newvalue', value: newvalue });
		$.ajax({
			url: './request.php',
			type: 'POST',
			dataType: 'html',
			data: bam,
			success: function (line){
				alert(line);
				}
		})
	}
				
</script>
<link rel="stylesheet" href="dbstyle.css" type="text/css" />

</head>
<body onload="loadViews()">
<div id="header">
<p id="stats" style="top:2%;height:20%">
Loading...
</p>
<p style='position:absolute;left:2%;top:25%'></p><hr>
<br />
<ul style="bottom:50%;height:50%">
<input type='button' onclick="choose('tables')" value='Table' /><br />
<input type='button' onclick="choose('sort');loadDisplay()" value='Sort' /><br />
<input type='button' onclick="choose('filter');loadFilters()" value='Filter' /><br />
<input type='button' onclick="choose('columnsdiv');loadDisplay()" value='Columns' /><br />
<input type='button' onclick="choose('views')" value='Comps' /><br />
<input type='button' onclick="choose('display');loadDisplay()" value='Display' /><br />
</ul>
<p style='bottom:20%'>
<textarea id='editbox' rows='1' cols='20'></textarea>
<input type='text' rows='20' id='newvalue' value="" />
<input type='button' value='Edit' onclick='mysqlRequest();loadDisplay()' />
</div>

<p style='position:absolute;left:2%;bottom:3%'></p><hr>
<input style='position:absolute;left:2%;bottom:2%' type="button" id="logout" onclick="logout()" value="Logout" />

<div id='display' style='position:absolute;left:15%;top:2%;bottom:2%;width:70%;right:15%'>
</div>

<div id='menu'>
<div style='position:absolute;left:15%;background-color:white;display:none' id='tables'>
<form enctype='multipart/form-data' id='table' name='table' method='POST'>
Table: 
<select id='tableswitch' onchange='switchTables(),loadFields(),loadDisplay()'>
<?php 	$tableq = mysql_query("SHOW TABLES FROM sales");
	while($tables = mysql_fetch_row($tableq)){
		print "<option>{$tables[0]}</option>";
	}?>
</select></form></div>

<div id='sort' style='position:absolute;left:15%;background-color:white;display:none'>
<form enctype='multipart/form-data' id='sortfl' name='sortfl' method='POST'>
</form>
<input type='button' value='Add Sort' onclick='addSort()' />
<input type='button' value='Remove' onclick='subSort()' />
</div>

<div id='totalfieldlist' style='display:none;position:absolute;left:50%'>
</div>

<div id='gate' style='display:none'>
<input name='g' checked type='radio' value='AND' />AND OR
<input name='g' type='radio' value='OR' />
</div>

<div id='comparison' style='display:none'>
<select name='comp'>
<option value='REGEXP'>similar to</option>
<option value='>'>greater than</option>
<option value='<'>less than</option>
<option value='=='>equal to</option>
<option value='IN'>contains</option>
<option value='NOT IN'>doesn't contain</option>
</select>
</div>


<div id='filter' style='position:absolute;top:2%;left:15%;background-color:white;display:none;border:1px solid black'>
<p id='appliedfilters' name='appliedfilters'></p>
<input type='button' value='New Filter' onclick='addFilter()' />
<input type='button' value='Remove' onclick='subFilter()' />
<form enctype='multipart/form-data' id='limitfilters' name='limitfilters' method='POST'>
Starting Position<input type='text' size='8' name='pos' />
Number of Rows<input type='text' size='8' name='len' />
</form>
</div>

<div id='columnsdiv' style='position:absolute;top:10%;left:15%;height:90%;background-color:white;display:none;border:1px solid black'>
<form enctype='multipart/form-data' style='overflow:scroll;height:50%' id='columns' name='columns' method='POST'>
</form>
<form enctype='multipart/form-data' id='arrangedcolumns' name='arrangedcolumns' method='POST' />
<li><input type='text' name='id' value='id' readonly /><input type='button' value='+' onclick="bumpUp(this)" /><input type='button' value='-' onclick="bumpDn(this)" /></li>
<li><input type='text' name='tax_id' value='tax_id' readonly /><input type='button' value='+' onclick="bumpUp(this)" /><input type='button' value='-' onclick="bumpDn(this)" /></li>
</form>
</div>

<div id='views' style='position:absolute;left:15%;background-color:white;display:none'>
<form enctype='multipart/form-data' id='alterviews' name='alterviews' method='POST'>
Complist name: 
<input type="text" id="viewname" size="18" value="" /><br /><br />
</form>
<input type="button" id="viewbutton" onclick="makeView();loadViews()" value="Comparison" />
<p id='viewer'></p>
</div>

</div> <!-- menu --!>
</body>
</html>
















