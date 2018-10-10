<?php

$savepath = $_POST['savepath'];
if(!$savepath){
	$filename = 'subdivision.csv';
} else $filename = $savepath . '.csv';

include('masterlistmaker.php');

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application");
header("Content-disposition: attachment;filename=$filename");


$unzip = zip_open($_FILES['pathname']['tmp_name']);
if(!$unzip){
	echo "Tripped off the starting line!";
}

if($_POST['columnflag']){
$columnflag = TRUE;
} else $columnflag = FALSE;

$a = 0;
$f=1;
while($zip_entry = zip_read($unzip)){
//	$zip_entry = zip_read($unzip);	
	$size = zip_entry_filesize($zip_entry);
	if($size == 0){
		goto end;
	}	
	$name = zip_entry_name($zip_entry);
	$file = zip_entry_read($zip_entry,$size);
//if($a == 5){
	$stacktsv[$a] = grab($file);
//}
//	if($a == 46){
//	var_dump($stacktsv[$a]);
//	}
//	print_r(array_keys(($stacktsv[$a])));

end:
$a++;
}
//var_dump($protolist);
$finaltotal = count($stacktsv);
$ff=1;
$masterlist = array();
if($_POST['columnflag'] == 'allcolumns'){
$masterlist[0] = '"' . implode('","',$protolist) . '"';
$protolist = array_flip($protolist);
//foreach($protolist as $key => $value);
goto write;
} else {
	$protolist = array_flip(array_keys($stacktsv[1]));
//	var_dump($protolist);
//	var_dump(array_flip(array_keys($stacktsv[1])));
	foreach($stacktsv as $key => $value){
		$protolist = array_merge($protolist,array_flip(array_keys($stacktsv[$key])));
		}
//	var_dump($protolist);
//	$masterlist[0] = '"' . implode('","',array_flip($protolist)) . '"';
	}
//echo "<br />";
//$protolist = array_flip($protolist);
//$masterlist[0] = '"' . implode('","',array_flip($protolist)) . '"';
foreach($protolist as $key => $value){
	$protolist[$key] = $key;
}
//var_dump($protolist);
//echo "<br />";
$masterlist[0] = '"' . implode('","',array_flip($protolist)) . '"';
write:
foreach($protolist as $key => $value){
	$protolist[$key] = '';
}
//var_dump($masterlist);
for($ff=1; $ff < ($finaltotal + 1); $ff++){
	$masterlist[$ff] = array_merge($protolist,$stacktsv[$ff]);
//	var_dump($masterlist[$ff]);
//	echo "<br />";
	$masterlist[$ff] = '"' . implode('","',$masterlist[$ff]) . '"';
}

$csv = implode("\n",$masterlist);
echo $csv;


?>

<?php

function grab($data) {


$tableregex = '/<table id=\"tbl(.*)\"/iU';
$divregex = '/<div id=\"divBuildings(.*)Ex\"/iU';
$divregex2 = '/<div id=\"divBuildings([0-9]+)\"/iU';

$datum1regex = "/line_left\"(?: style=\"width:61%;\")?>(.*)<\/td>/iU";
$datum2regex = "/[^>](?:<strong>)?(.*)(?:<\/a>)?(?:<\/strong>)?<\/td>/iU";
$datum3regex = '/px\"|right;\">(.*)<\/td>/iU';
//$datum4regex = "/(?<=%;\">)(?:<strong>)?(.*)(?:<Br>)?(?:<\/strong>)?[^($.(?:<\/a>))](?=<\/td>)/iU";
$datum4regex = "/<td[^>]*>(.*?)<\/td>/i";
$datum5regex = "/[td|line_left\"]>((?!<STRONG>).*)<\/td>/iU";
$datum7regex = "/[px;\"|line_left\"]>((?!<strong>).*)<\/td>/U";
$datum8regex = "/[px;\"|line_left\"]>((?!<STRONG>).*)<\/td>/iU";
$bldgdatumrgx = "/line_left\">((?!<strong>).*)<\/td>/U";

$label1regex = '/<STRONG>(.*)<\/STRONG><\/td><td class/iU';
$label2regex = '/[^>](?<!;\")(.*)[^($;)]<\/STRONG><\/th>/iU';
$label3regex = '/bold;\">(.*)<\/td>/iU';
$label4regex ='/<STRONG>(.*)<\/STRONG>/U';
$label5regex = '/<th(?: style=\".*\")?><STRONG>(.*)<\/STRONG><\/th>/iU';
$label6regex = '/(?: style=\".*\")?><STRONG>(.*)<\/STRONG><\/td>/iU';

$bldglabelrgx = "/<strong>(.*)<\/strong>|<td>[^<](.+)<\/td>/iU";
$bldgstartregex = "/<table class=\"standardViewTextSize\">/U";
$bldgsecregex = "/<tr class=\"standardViewTextSize\">/U";



preg_match_all($tableregex,$data,$tables);

preg_match_all($divregex,$data,$divs);
preg_match_all($datum1regex,$data,$datum1);
preg_match_all($divregex2,$data,$divstops);
$tablecount = count($tables[0]);
$divcount = count($divs[0]);
$datum1count = count($datum1[0]);
$tablepos[] = NULL;
$divpos[] = NULL;
$tsvstring = NULL;

$d=0;
while($d < $tablecount){
	$tablepos[$d] = strpos($data,"<table id=\"tbl{$tables[1][$d]}\"");
	$d++;
}
//var_dump($divs[1]);
$assoctable = array_combine($tables[1],$tablepos);

$e=0;
while($e < $divcount){
	$divpos[$e] = strpos($data,"<div id=\"divBuildings{$divs[1][$e]}Ex\"");
	$e++;
}

$ee=0;
while($ee < count($divstops[1])){
	$divstoppos[$ee] = strpos($data,"<div id=\"divBuildings{$divstops[1][$ee]}\"");
	$ee++;
	}

//var_dump($divstoppos);
$assocbldg = array_combine($divs[1],$divpos);
//var_dump($assocbldg);

$divcount = count($assocbldg);
$secount = count($assoctable);

//echo $secount;
//echo "</br>";

$j = 0;
while($j < $secount){
	$switch = key($assoctable);
	switch($switch){

//location, current owner, property summary, gen par info
	case 'Location':
	$length = $tablepos[$j+4] - $tablepos[$j];
	$genlump = substr($data,$tablepos[$j],$length);
	preg_match_all($label1regex,$genlump,$labels);
	preg_match_all($datum1regex,$genlump,$datum);
	$gen = cleaner($labels[1],$datum[1],$switch);
	break;

	case 'CurrentOwner':
	continue;

	case 'PropertySummary':
	continue;

	case 'GeneralParcelInformation':
	continue;

	case 'SalesHistory':
	break;

//skip non-expanded sales history table
//begin sales history ex table
	case 'SalesHistoryEx':
	$length = $tablepos[$j+1] - $tablepos[$j];
	$section = substr($data,$tablepos[$j],$length);
	preg_match_all($label2regex,$section,$labels);
	preg_match_all($datum2regex,$section,$datum);
	$labelpurge = preg_replace("/\\t|\\n/","",$labels[0]);
	$k=7;
	$violentpurge = preg_replace("/\\t|\\n/","",$datum[0]);
	$violentpurge = array_slice($violentpurge,2);
	$sales = cleaner($labelpurge,$violentpurge,$switch);
	break;

//begin tax assessment table 	
	case 'TaxAssessment':
	$length = $tablepos[$j+1] - $tablepos[$j];
	$section = substr($data,$tablepos[$j],$length);
	preg_match_all($label3regex,$section,$labels);
	preg_match_all($datum3regex,$section,$datum);
	$tax = cleaner($labels[1],$datum[1],$switch);
	break;

	case 'MortgageHistory':
	break;
	

//begin mortgage history ex table
	case 'MortgageHistoryEx':
	$length = $divstoppos[0] - $tablepos[$j];
	$section = substr($data,$tablepos[$j],$length);
	preg_match_all($label5regex,$section,$labels);
	preg_match_all($datum4regex,$section,$tdatum);
	$labelpurge = preg_replace("/\\t|\\n/","",$labels[0]);
	$datum = str_replace("\t","",$tdatum[0]);
	$stackdatum = array_slice($datum,1);
	$violentpurge = preg_replace("/\\t|\\n/","",$datum);
	$mort = cleaner($labelpurge,$violentpurge,$switch);
//	var_dump($mort);
//	echo "</br>";
	break;


//begin extra features table
	case 'ExtraFeatures':
	$length = $tablepos[$j+1] - $tablepos[$j];
	$section = substr($data,$tablepos[$j],$length);
	preg_match_all($label2regex,$section,$labels);
	preg_match_all($datum5regex,$section,$tdatum);
	$labelpurge = preg_replace("/\\t|\\n/","",$labels[0]);
	$featlabel = $labelpurge;
	$k=0;
	$datum = str_replace("\t","",$tdatum[0]);
	$count = count($datum);
		while($k < $count){
			$datum[$k % 4] .= "</br>" . $datum[$k];
		$k++;
	}
	$stackdatum = array_slice($tdatum[1],0,-2);
	$violentpurge = preg_replace("/\\t|\\n/","",$stackdatum);
	$featdatum = $violentpurge;
	$feat = cleaner($labelpurge,$stackdatum,$switch);
//	var_dump($feat);
//	echo "</br>";
	break;



//begin lot table
	case 'Lot':
	$length = $tablepos[$j+1] - $tablepos[$j];
	$section = substr($data,$tablepos[$j],$length);
	$shift = array('Property Characteristics: Lot','Close');
	preg_match_all($label6regex,$section,$labels);
	preg_match_all($datum7regex,$section,$datum);
	$datumshift = array_diff($datum[1],$shift);
	$lot = cleaner($labels[1],$datum[1],$switch);
//	var_dump($lot);
//	echo "</br>";
	break;


//begin utilities table
	case 'Utilities':
	$length = $tablepos[$j+1] - $tablepos[$j];
	$section = substr($data,$tablepos[$j],$length);
	preg_match_all($label1regex,$section,$labels);
	preg_match_all($datum8regex,$section,$datum);
	$utillabel = $labels[1];
	$slice = array_slice($datum[1],2,count($labels[1]));
	$util = cleaner($labels[1],$slice,$switch);
//	var_dump($util);
//	echo "</br>";
	break;
	

//begin legal table
	case 'LegalDescription':
	$length = $tablepos[$j+1] - $tablepos[$j];
	$section = substr($data,$tablepos[$j],$length);
	preg_match_all($label1regex,$section,$labels);
	preg_match_all($datum8regex,$section,$datum);
	$slice = array_slice($datum[1],2,count($labels[1]));
	$legal = cleaner($labels[1],$slice,$switch);
//	var_dump($legal);
//	echo "</br>";
	break;

	case 'TitleBottom':
	continue;

	default:
	continue;

}

next($assoctable);
$j++;

}


$div = 0;
while($div < $divcount){
// begin buildings tables 
$switch = key($assocbldg);
switch($switch){
	case '1':
	$bl = 0;
	while($bl < count($divpos)){
	if($divpos[$bl+1]){
	$length = $divstoppos[$bl+1] - $divpos[$bl];
	} else $length = $assoctable['ExtraFeatures'] - $divpos[$bl];
	$section = substr($data,$divpos[$bl],$length);
//	echo $section . "</br>" . "<-----------------------------------------------></br>";
	preg_match_all($bldglabelrgx,$section,$labels);
	preg_match_all($bldgdatumrgx,$section,$datum);
//	var_dump($labels[1]);
	$datslice2 = bldgsort(array_merge(array_slice($labels[1],1,10),array_slice($labels[1],12)));
	$secmark = array_search('Quality',$datslice2);
	if($secmark < 12){
		$datslice1 = array_merge(array_slice($datum[1],0,11),array_slice($datum[1],13));
	} else $datslice1 = $datum[1];
	foreach($datslice2 as $thingmonger => $thing){
	//	str_replace("UpperStorieshigh","UpperStoriesHigh",$datslice2[$thingmonger]);
	//	str_replace("FirstStoryBaseSemifinished","FirstBaseStorySemifinished",$datslice2[$thingmonger]);
		$datslice2[$thingmonger] = 'Bldg' . ($bl + 1) . "_" . $datslice2[$thingmonger];
		}
	if($datslice1 > $datslice2){
		$diff = count($datslice1) - count($datslice2);
		$quality = 'Bldg' . ($bl + 1) . "Quality";
		$secmark2 = array_search($quality,$datslice2);
		$datslice1 = array_merge(array_slice($datslice1,0,($secmark2 - $diff)),array_slice($datslice1,$secmark2));
	}

//	var_dump($datslice2);
//	echo "</br>";
//	var_dump($datslice1);
//	echo "</br>";
//	echo "</br>----------------------------------------------------------------------</br>";
	$bldglabel .= "\t" . implode("\t",$datslice2);
	$bldgdatum .= "\t" . implode("\t",$datslice1);
	$bl++;
	}
	$labeltotal = explode("\t",$bldglabel);
	$datumtotal = explode("\t",$bldgdatum);
	$bldg = cleaner($labeltotal,$datumtotal,$switch);
//	var_dump($bldg);
//	echo "</br>";
	break;
 
	default:
	break;
}
next($assocbldg);
$div++;
}

//$bldglabel2 = explode("\t",$bldglabel);
//$bldgdatum2 = explode("\t",$bldgdatum);
$tsvstring = $gen;
$ultron = array($sales,$tax,$mort,$feat,$lot,$util,$legal,$bldg);
foreach($ultron as $ul => $tron){
	if($ultron[$ul]){
		$tsvstring = array_merge($tsvstring,$ultron[$ul]);
	}
}
//$tsvstring = array_merge($gen,$sales,$tax,$mort,$feat,$lot,$util,$legal,$bldg);
//echo "</br><------------------------------------------------------------------------------------------------------------------------------------></br>";
return $tsvstring;

}
?>

<?php 
function cleaner($array1,$array2,$type) {

$blacklist1 = array('','&nbsp;');
$blacklist2 = array('Mortgage History','Click on the Amount or Document# above to see the actual sales (warranty) deed for that sale.','Click here to see building footprint.','Property Characteristics: Building','Close','Property Characteristics: Extra Features','>Property Characteristics: Extra Features','Minimize Close','Property Characteristics: Lot','Click here to see to mortgage (trust) details.');
$blacklist3 = array("<br>","&amp;");
$blacklist4 = array('&Acirc;',' ','&nbsp;','/','#','&amp;','-','(',')','nbsp;');
$blacklist5 = array(' ','$nbsp;',"");

//if($type == 'MortgageHistoryEx'){
//var_dump($array1);
//var_dump($array2);
//}
if(preg_match("/No .* were found for this parcel./",implode("\t",$array2))==1){
	$final = array( 'blank' => 'yes');
	goto skip;
	}

if($array2==false || $array1==false){
	$final = array( 'blank' => 'yes');
	goto skip;
	}

//var_dump($array1);
//echo "</br>" . "-------------------------------------------------------" . "</br>";
//var_dump($array2);

$array2 = str_ireplace($blacklist3," ",$array2);
$array1 = explode("\t",strip_tags(implode("\t",$array1)));
$array2 = explode("\t",strip_tags(implode("\t",$array2)));
$array2 = explode("\t",str_replace('&Acirc;',' ',htmlentities(implode("\t",$array2))));
$array1 = explode("\t",str_replace('&Acirc;',' ',htmlentities(implode("\t",$array1))));
$array1 = str_replace($blacklist4,'',$array1);
//$array1 = array_diff($array1,$blacklist5);
//$array1 = array_filter($array1);
$array2 = array_diff($array2,$blacklist2);
$array2 = str_replace('&nbsp;',' ',$array2);
//$array2 = str_replace(',','.',$array2);
$array1 = str_replace('Date','DateOf',$array1);
$array1 = str_replace('Condition','Cond',$array1);
//if($array2[0] == '' | $array2[0] == '&nbsp;'){
//$array2 = array_slice($array2,1);
//}
$final = NULL;
switch ($type) 
{

	case 'Location':
	break;

	case 'SalesHistoryEx':
	if($array2 > $array1){
		$array2 = array_slice($array2,0,-2);
	}
	$count = count($array2);
	$array1 = array_pad($array1,$count,"");
	$temparr = $array1;
	$z = 0;
	for($z = 0; $z < $count; $z++){
		$temparr[$z] = "Sale" . floor($z/7) . "_" . $array1[$z%7];
	}
	$array1 = $temparr;
	break;

	case 'Lot':
	if($array1 > 6){
	$array1 = array_slice($array1,0,6);
	}
	if($array2 > 6){
	$array2 = array_slice($array2,1,6);
	}
	break;

	case 'MortgageHistoryEx':
	$array2 = array_slice($array2,1,-1);
	$count = count($array2);
	$array1 = array_pad($array1,$count,"");
	$temparr = $array1;
	$y = 0;
	for($y = 0; $y < $count; $y++){
		$temparr[$y] = "Mortgage" . floor($y/6) . "_" . $array1[$y%6];
	}
	$array1 = $temparr;
	break;

	case 'ExtraFeatures':
	$array2 = array_slice($array2,1);
	$count = count($array2);
	$array1 = array_pad($array1,$count,"");
	$temparr = $array1;
	$x = 0;
	for($x = 0; $x < $count; $x++){
		$temparr[$x] = "Feature" . floor($x/4) . "_" . $array1[$x%4];
	}
	$array1 = $temparr;
	break;

	case 'Utilities':
	break;

	case 'Legal':
	break;

	default:
	break;
}


$final = array_combine($array1,$array2);
//if($type == '1'){
//	var_dump($final);
//}
if(!$final){
	$final= array('blank' => 'yes');
	goto skip;
	}
skip:
//var_dump($final);
return $final;
}
?>

<?php 
function bldgsort($array){

$dupes = array_count_values($array);
foreach($dupes as $key => $value){
	if($value > 1){
	$dupelist = array_keys($array,$key);
	foreach($dupelist as $inkey => $invalue){
		$array[$invalue] = ($inkey + 1) . $array[$invalue];
	}
	}
}

return $array;
}
?>

<?php 
function condense($array,$columnum,$iterate){
$j =0;
$i = 0;
for($i = 0; $j < $iterate; $i+=$columnum){
	$temp = array_slice($array,$i,$columnum);
	$group[$j] = implode(":",$temp);
	$temp = NULL;
	$j++;
}
return $group;
}
?>
	























