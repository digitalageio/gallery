<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
	<title>County Information Database Interface</title>
	<!--CSS goes here-->
</head>
<body>
<?php 
	$fh = fopen("510", "rb");
	fseek($fh, 534);
	$data = fread($fh, 15);
	print $data;
?>

