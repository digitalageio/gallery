<?php
	$square = 20;
	$base = 16;
	$interval = 3;
	$start = 0;
	$hex = array();
	$r = $start;
	while($r < $base){
		$g = $start;
		while($g < $base){
			$b = $start;
			while($b < $base){
				$push = array();
				$push["width"] = $square . "px";
				$push["height"] = $square . "px";
				$push["left"] = (($b/3) * $square) . "px";
				$push["top"] = (((($r/3) * 6) + ($g/3)) * $square) . "px";
				$push["hex"] = "#" . dechex($r) . dechex($r) . dechex($g) . dechex($g) . dechex($b) . dechex($b);
				array_push($hex,$push);
				$b += $interval;
			}
			$g += $interval;
		}
		$r += $interval;
	}
	//var_dump($hex);
	$json = json_encode($hex);
	echo $json;
