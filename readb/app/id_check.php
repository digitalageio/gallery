<?php
	$exitval = FALSE;
	foreach($_POST as $key => $value){
		$pattern = "";
		switch($key){
			case 'tax_map':
				$pattern = "/^[0-9]{3}([A-Z]{1})?$/";	
			break;
			case 'grp':
				$pattern = "/^[A-Z]{1}$/";
			break;
			case 'parcnum1':
				$pattern = "/^[0-9]{3}$/";
			break;
			case 'parcnum2':
				$pattern = "/^[0-9]{2}$/";
			break;
			case 'specint':
				$pattern = "/^(?:[0-9]{3})?$/";
			break;
			default:
				$exitval = FALSE;
			break;
		}
		if(preg_match($pattern,$_POST[$key])){
			$exitval = TRUE;
		}
	}
	print $exitval;
?>
