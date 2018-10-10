<!DOCTYPE html> 
<?php 
	//PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	//"http://w3.org/TR/xhtml1-transitional.dtd">

//AUTOMATICALLY LOGS IN AS ROOT !--EDIT BEFORE BETA TESTING--!
include("loginvars.php");

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
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta charset="UTF-8" />
	<title>REA,Inc. -- Database Hub</title>
<script type="text/javascript" src="jquery.min.js" language="javascript"></script>
<!--script type="text/javascript" src="selecttoggle.js"></script!-->
<form enctype="multipart/form-data" id="creds" method="POST"> 
<input type="hidden" name="user" value=<?php echo $user; ?>>
<input type="hidden" name="host" value=<?php echo $host; ?>>
<input type="hidden" name="db" value=<?php echo $db; ?>>
<input type="hidden" name="pswd" value=<?php echo $pswd; ?>>
</form>
<script type="text/javascript" language="javascript">
	var thegoodstuff = $("#creds").serializeArray();
	setInterval( "getStats()", 30000 );

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

	function embolden(index){
		var spot = "ul li:eq(" + index + ")";
			$(spot).css({"font-size":"125%"});
	}
	
	function unbolden(index){
		var spot = "ul li:eq(" + index + ")";
			$(spot).css({"font-size":"100%"});
	}

	function runScript(divname,script){
		$("#currentscript").find('div').css('display','none');
		if(!document.getElementById(divname)){
		var shmee = thegoodstuff.slice(0);
		shmee.push({ name: 'divname', value: divname });
			$.ajax({
					url: script,
					type: 'POST',
					dataType: "html",
					data: shmee,
					success: function (response) {
						if(response != '')
						{
						$("#currentscript").append(response);
						}
					}
			})
		} 
		document.getElementById(divname).style.display="inline";
	}

	function makeView(){
		var vname = document.getElementById('viewname').value;
		var tablea = document.getElementById('table');
		var tablei = tablea.selectedIndex;
		var tablez = tablea[tablei].text;
		var selection = $('#row_boxes input:checked').serializeArray();
		var agh = [];
		agh.push({ name: 'view_name', value: vname });
		agh.push({ name: 'orig_table', value: tablez });
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
	
	function logout(){
		window.document.location="./index.php";
	}
</script>
<link rel="stylesheet" href="dbstyle.css" type="text/css" />
</head>
<body onload="loadViews()">
<div id="header">
<p id="stats" style="top:2%;height:20%">
Loading...
</p>
<p style='position:absolute;left:2%;top:25%'>---------------</p>
<br />
<ul style="bottom:2%;height:70%">
<li><a id='navbar' onmouseover="embolden('0')" onmouseout="unbolden('0')" onclick="runScript('tables','./tables.php')"> Create or delete secondary tables</a></li><br />
<li><a id='navbar' onmouseover="embolden('1')" onmouseout="unbolden('1')" onclick="runScript('query','./querybuild.php')"> Make a query to the database</a></li><br />
<li><a id='navbar' onmouseover="embolden('2')" onmouseout="unbolden('2')" onclick="runScript('editor','./editor.php')"> Edit columns or records</a></li>
<li style='font-weight:normal;font-size:120%'>---------------</li><br />
</ul>
<li><a id='navbar' onmouseover="embolden('3')" onmouseout="unbolden('3')" onclick="runScript('./tsvmaker.php')"> Output table to a csv file</a></li><br />
<li><a id='navbar' onmouseover="embolden('4')" onmouseout="unbolden('4')" onclick="runScript('./grab.php')"> Convert a batch of crs HTMLs to csv</a></li><br />
<li><a id='navbar' onmouseover="embolden('5')" onmouseout="unbolden('5')" onclick="runScript('./loadcsv.php')"> Append current database with csv files</a></li><br />
<li><a id='navbar' onmouseover="embolden('6')" onmouseout="unbolden('6')" onclick="runScript('./loaddb.php')"> Upload csv files as a new database</a></li><br />
<li><a id='navbar' onmouseover="embolden('7')" onmouseout="unbolden('7')" onclick="runScript('./impact.php')"> Append current database with IMPACT file</a></li><br />
<li><a id='navbar' onmouseover="embolden('8')" onmouseout="unbolden('8')" onclick="runScript('./loadimpact.php')"> Upload IMPACT file as new database</a></li><br />
</ul>
<p id='viewer' style='position:absolute;left:2%;top:50%'></p>
<input style='position:absolute;left:2%;bottom:15%' type="text" id="viewname" size="18" value="">
<input style='position:absolute;left:2%;bottom:10%'type="button" id="viewbutton" onclick="makeView();loadViews()" value="Comparison" />
<p style='position:absolute;left:2%;bottom:3%'>---------------</p>
<input style='position:absolute;left:2%;bottom:2%' type="button" id="logout" onclick="logout()" value="Logout" />
</div>
<div id='currentscript' style='position:absolute;left:15%;top:2%;bottom:2%;width:70%;right:15%'>
</div>
<div id='
</body>
</html>
















