<!DOCTYPE html>
<?php //PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	//"http://w3.org/TR/xhtml1-transitional.dtd">
$jquery = '"jquery.min.js"' ?>
<html = xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta charset="UTF-8" />
	<title>REA,Inc. -- Database Login</title>
<link rel="stylesheet" href="dbstyle.css" type="text/css" />
<script type="text/javascript" src=<?php print $jquery ?> language="javascript"></script>
<script type="text/javascript" lang="javascript">
	window.onload = function centerBox(section){
		var height = document.getElementById("loginform").offsetHeight;
		var topmargin = Math.ceil(height/2);
		var topcss = "-" + topmargin + "px";
		var width = document.getElementById("loginform").offsetWidth;
		var leftmargin = Math.ceil(width/2);
		var leftcss = '-' + leftmargin + 'px';
		$("#loginform").css({"margin-left":leftcss,"top":topcss});
	}
</script>
</head>
<body style="background-color:#020043">
<div id="centerpoint">
<div id="loginform">
<form enctype="multipart/form-data" name="login" method="POST" action="dbhub.php" onclick="scramble()">
<input type="image" src="image426.jpg" border="2" alt="submit"><br />
<input type="text" name="user" size=30 value=''><br />
<input type="password" name="pswd" size=30 value=''><br />
<input type="text" name="host" size=30 value=''><br />
<input type="text" name="db" size=30 value=''><br />
</form></div></div>
</body>
</html>












