<?php
function __autoload($class)
{
	$classFile = BaseUrl.DS.'classes'.DS.$class.'.php';
	if(file_exists($classFile)) {
		include_once($classFile);
	} else {
		echo "No Class Found";
	}
}

function is_ajax() 
{
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") ? true : false;
}

function randomPassword( $length ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}

function randomKeyGenerate()    {
   return sha1(microtime(true).mt_rand(10000,90000));
}

/*
function getSiteLink($module, $action, $query_string="")
{
	global $siteName;
	$link = $siteName."index.php?module=$module&action=$action";
	if($query_string !="") {
		$link .= "&".$query_string;
	}	
	return $link;
}

function getUserLink($module, $action, $query_string="")
{
	global $siteName;
	$link = $siteName."user.php?module=$module&action=$action";
	if($query_string !="") {
		$link .= "&".$query_string;
	}	
	return $link;
}

*/
function getUserLink($module, $action, $query_string="")
{
	global $siteName, $siteNameSSL;
	if($module=='cart')
		$link = $siteNameSSL."$module/$action";
	else
		$link = $siteName."$module/$action";
	if($query_string !="") {
		$link .= "/".$query_string;
	}	
	return $link;
}

function getSiteLink($module, $action, $query_string="")
{
	global $siteName, $siteNameSSL;
	if($module=='cart')
		$link = $siteNameSSL."$module/$action";
	else
		$link = $siteName."$module/$action";
	if($query_string !="") {
		$link .= "/".$query_string;
	}	
	return $link;
}

function getAdminSiteLink($module, $action, $query_string="")
{	
	global $adminSiteName;  
	$link = $adminSiteName."index.php?module=$module&action=$action";
	if($query_string !="") {
		$link .= "&".$query_string; 
	}	 
	return $link;
} 

function getAdminLink($module, $action, $query_string="")
{
	global $adminSiteName; 
	$link = $adminSiteName."admin.php?module=$module&action=$action";
	if($query_string !="") {
		$link .= "&".$query_string;
	}	 
	return $link;
}

function clean($var)
{
	if(is_array($var)) {
		$var_temp = array();
		foreach($var as $k=>$v) {
			if(is_array($v)) {
				$var_temp[$k] =$v;	
				continue;
			}
			$var_temp[$k] = addslashes(trim($v));	
		}
		return($var_temp);
	} else {
		return addslashes(trim($var));
	}	
}

function normalize_str($str)
{
	$invalid = array("©" => "&copy;", "é" => "e's", "‘" => "'","—" => "-","`" => "'", "´" => "'", "„" => ",", "`" => "'",
	"´" => "'", "“" => "\"", "”" => "\"", "´" => "'", "&acirc;€™" => "'", "{" => "",
	"~" => "", "–" => "-", "–" => "-", "’" => "'");
	 
	$str = str_replace(array_keys($invalid), array_values($invalid), $str);
	 
	return $str;
}

function unclean($var)
{
	if(is_array($var)) {
		$var_temp = array();
		foreach($var as $k=>$v) {
			if(is_array($v)) {
				$var_temp[$k] =$v;	
				continue;
			}
			$v = normalize_str($v);
			$var_temp[$k] = stripslashes(trim($v));	
		}
		return($var_temp);
	} else {
		$var = normalize_str($var);
		//return uc_words(stripslashes(trim($var)));
		return stripslashes(trim($var));
	}		
}

function encode($var)
{
	if(is_array($var)) {
		$var_temp = array();
		foreach($var as $k=>$v) {
			if(is_array($v)) {
				$var_temp[$k] =$v;	
				continue;
			}
			$var_temp[$k] = htmlentities(trim($v));	
		}
		return($var_temp);
	} else {
		return htmlentities(trim($var));
	}		
}

function decode($var)
{
	if(is_array($var)) {
		$var_temp = array();
		foreach($var as $k=>$v) {
			if(is_array($v)) {
				$var_temp[$k] =$v;	
				continue;
			}
			$var_temp[$k] = html_entity_decode(trim($v));	
		}
		return($var_temp);
	} else {
		return html_entity_decode(trim($var));
	}		
}

function makeNiceName($str)
{
	$str = preg_replace('/[^(A-z0-9)|\s|\-]/', "-", $str, -1);
	$str = preg_replace('/[\W|\s|\-]/', "-", $str, -1);
	$str = preg_replace('/(-)+/', "-", $str, -1);
	$str = rtrim($str, "-");
	$str = strtolower($str);
	//$str = substr($str,0,30);
	return $str;
}

function uc_words($str)
{
    return ucwords($str);
}

function convertStringToLower($str)
{
	return strtolower($str);
}

function convertStringToUpper($str)
{
	return strtoupper($str);
}

function validateEmailAddress($to_be_tested_email_address)
{
	$regexp="/^[a-z0-9]+([_+\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i"; 
	if(preg_match($regexp, $to_be_tested_email_address)) {
		return true;
	} else {
		return false;
	}
}

function validateUserName($desired_username)
{
	$regexp="/^[a-zA-Z0-9]{6,15}$/";  //min six characters with only alphabet and number allowed
	if(preg_match($regexp, $desired_username)) {
		return true;
	} else {
		return false;
	}
}

function checkNumericId($id)
{
	return (!empty($id) && is_numeric($id)) ? $id : exit();
}

function phoneFormat($phone,$key=0)
{
    if(empty($phone)){
        return $phone;exit;
    }
    $part1 = substr($phone,0,3);
    $part2 = substr($phone,3,3);
    $part3 = substr($phone,6);
    if($key==0)
        $new_phone = $part1."-".$part2."-".$part3;
    else
        $new_phone = "(".$part1.") ".$part2."-".$part3;
    return $new_phone;
}

function timeTranslate($tz_from, $tz_to, $time_str = 'now', $format = 'm-d-Y h:i:s A')
{
    $dt = new DateTime($time_str, new DateTimezone($tz_from));
    $timestamp = $dt->getTimestamp();
    return $dt->setTimezone(new DateTimezone($tz_to))->setTimestamp($timestamp)->format($format);
}

function dateFormat($datetime,$timezone=0)
{
	return date('m-d-Y',strtotime($datetime));
	/*
	$db_server_time = $datetime;
	$db_server_tz   = SERVER_TZ;
	$local_tz        = $_SESSION['local_tz'];
	$local_time = timeTranslate($db_server_tz, $local_tz, $db_server_time,'m-d-Y');
    return $local_time;
	*/
}

function dateTimeFormat($datetime,$timezone=0)
{
	return date('m-d-Y h:i:s A',strtotime($datetime));
	/*
	$db_server_time = $datetime;
	$db_server_tz   = SERVER_TZ;
	$local_tz        = $_SESSION['local_tz'];
	$local_time = timeTranslate($db_server_tz, $local_tz, $db_server_time);
    return $local_time;
	*/
}

function dateCalculate($oldTime, $newTime, $timeType = 'x') 
{
        $timeCalc = strtotime($newTime) - strtotime($oldTime);         
		
        if ($timeType == "x") 
		{
			if ($timeCalc >=0 )
                $timeType = "s";
            if ($timeCalc >= 60)
                $timeType = "m";
            if ($timeCalc >= (60*60))
                $timeType = "h";
            if ($timeCalc >= (60*60*24))
                $timeType = "d";
        }  
		      
        if ($timeType == "s") 
		{
			/*
			if($timeCalc <5 )
				$timeCalc = 'Just now';
			else
			*/
	            $timeCalc .= " seconds";
        }
        if ($timeType == "m")
            $timeCalc = round($timeCalc/60) . " minutes";
        if ($timeType == "h")
            $timeCalc = round($timeCalc/60/60) . " hours";
        if ($timeType == "d")
            $timeCalc = round($timeCalc/60/60/24) . " days";
			
	return $timeCalc;
}

function getWeekNumber($date) 
{
	$date_arr = explode('-',$date);
	$yearNumber = $date_arr[0];
	$monthNumber = $date_arr[1];
	$dayNumber = $date_arr[2];
	$tm = mktime(0,0,0,$monthNumber,$dayNumber,$yearNumber);
	$week = (int)date('W', $tm);
	return $week;
}

function getQuarterDay($date) 
{
	$date_arr = explode('-',$date);
	$yearNumber = $date_arr[0];
	$monthNumber = $date_arr[1];
	$dayNumber = $date_arr[2];
	$tm = mktime(0,0,0,$monthNumber,$dayNumber,$yearNumber);
	$quarter = ceil(date("m", $tm)/3);
	return $quarter;
}

function get_week_dates( $date )
{
	// the return array
	$dates = array();
	$time = strtotime($date);
	$start = strtotime('last Sunday', $time);
	
	$dates[] = date( 'Y-m-d', $start );
	
	
	// calculate the rest of the times
	for( $i = 1; $i < 7; $i++ )
	{
		//$dates[] = date( 'Y-m-d' , ( $start + ( $i * ( 60 * 60 * 24 ) ) ) );
		$dates[] = date('Y-m-d',strtotime("+$i Days",$start));
	}
	
	return $dates;
}

function connection($host,$user,$password,$database)
{
	$conn = @mysql_connect($host,$user,$password);
	
	if(!$conn) {
		echo "<br>Database Error!!!<br>".mysql_error();
		die;			
	}
	mysql_select_db($database);
        return $conn;
}

function connectionClose()
{
    mysql_close();
}