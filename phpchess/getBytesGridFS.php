<?php
	$url = parse_url($_SERVER['REQUEST_URI']);
	parse_str($url["query"]);
	$find = $set . '_' . $piece . '_' . $size . '.png';
	$connection = new MongoClient();
	$db = $connection->test;
	$gridFS = new MongoGridFS($db);
	$file = $gridFS->findOne($find);
	header('Content-Type: image/png');
	echo $file->getBytes();
?>
