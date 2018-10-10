<?php

//error_reporting(E_ALL ^ E_WARNING);

include 'xhtml-arrays.php';


$filename = 'name.com_page-sitemap.xml';
$handle = fopen($filename, 'r');

$writefilename = 'new-sitemap.xml';
$writehandle = fopen($writefilename, 'w');

$match = false;

if($handle && $writehandle){
	while(($line = fgets($handle)) !== false){
		fwrite($writehandle, $line);
		if(strpos($line, '<loc>')){
			$one = strpos($line, '<loc>') + 5;
			$two = strpos($line, '</loc>');
			$length = $two - $one;
			$http = substr($line, $one, $length);
			foreach($xhtml_arrays as $set){
				foreach($set as $xhtml){
					$xhtml_one = strpos($xhtml, 'href="') + 6;
					$xhtml_two = strpos($xhtml, '" />');
					$xhtml_length = $xhtml_two - $xhtml_one;
					$xhtml_http = substr($xhtml, $xhtml_one, $xhtml_length);
					if($xhtml_http === $http){
						//printf($line . "        " . $xhtml . "\n");
						$match = true;
					}
				}
				if($match){
					foreach($set as $xhtml){
						$newline = "        " . $xhtml . "\n";
						fwrite($writehandle, $newline);
					}
				}
			$match = false;
			}
		}
	}
	fclose($handle);
	fclose($writehandle);
} else {

} 

