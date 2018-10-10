<?php
	$url = parse_url($_SERVER['REQUEST_URI']);
	parse_str($url["query"]);
	$find = $set . '_' . $piece . '_' . $size . '.png';
	$connection = new MongoClient();
	$db = $connection->test;
	$gridFS = new MongoGridFS($db);
	$file = $gridFS->findOne($find);
	$res = fread($file->getResource(),$file->getSize());	
	$png = imagecreatefromstring($res);
	$x = imagesx($png); 
	$y = imagesy($png);
	$squares = array();
	for($i=0;$i<$x;$i++){ 
		for($j=0;$j<$y;$j++){ 
			$rgb = imagecolorat($png,$i,$j);
			$css = array();
			$css["x"] = ($i * 10) . "px";
			$css["y"] = ($j * 10) . "px";
			$css["rgba"] = "rgba(" . implode(",",imagecolorsforindex($png,$rgb)) . ")";
			array_push($squares,$css);
		}
	}
	echo json_encode($squares);
?>
