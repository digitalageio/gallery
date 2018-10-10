<?php
function getAjaxPage()
{
	$cur_url = $_SERVER['REQUEST_URI'];
	$arr_url = explode('/',$cur_url);
	return (!empty($arr_url[2]) && $arr_url[2] == 'ajax') ? true : false; 
}