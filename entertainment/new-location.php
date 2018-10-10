<?php
/*
locations->id 	name 	address 	phone_number 	created_by 	last_modified 	created_on 	client 	region 	type 	website 	dropbox_url 	inactive
addresses->id 	address 	address2 	city 	zip 	state 	last_modified 	created_on 	country_id
phone_numbers->id 	number 	type 	ext 	last_modified 	created_on
*/
$date = 'NOW()';
if (isset($_POST['btn_add_location']) && !empty($_POST['btn_add_location'])) 
{
	$errors = array(); 
    $fields = array(); 
    $rules = array();
    $rules[] = "required,name,Name is required";
	$rules[] = "required,website,Website is required";
    $rules[] = "required,address,Address is required";
	$rules[] = "required,city,City is required";
	$rules[] = "required,zip,Zip is required";
    $errors = validateFields($_POST, $rules);
	
    if(empty($_POST['type']))
        $errors[] = "Location type is required";
	if(empty($_POST['country_id']))
        $errors[] = "Country is required";
    
    if(!empty($errors))
        $message = $errors;
    else 
	{
		$number = $_POST['contact_phone1'].$_POST['contact_phone2'].$_POST['contact_phone3'];
		$client = new Client("phone_numbers");
		$cell_phone = '';
		if(!empty($number))
		{
			$array_content = array(
				'number'=>trim($number),
				'type'=>2,
				'last_modified'=>$date,
				'created_on'=>$date
				);
			$cell_phone = $client->insert($array_content);
		}
		$client = new Client("addresses");
		$array_content = array(
			'address'=>clean($_POST['address']),
			'address2'=>clean($_POST['address2']),
			'city'=>clean($_POST['city']),
			'zip'=>trim($_POST['zip']),
			'state'=>trim($_POST['state']),
			'country_id'=>trim($_POST['country_id']),
			'last_modified'=>$date,
			'created_on'=>$date
			);
		$address_id = $client->insert($array_content);

		$inactive = isset($_POST['inactive'])?'1':'0';
		$client = new Client("locations");
		$array_content = array(
			'name'=>clean($_POST['name']),
			'phone_number'=>$cell_phone,
			'address'=>$address_id,
			'type'=>clean($_POST['type']),
			'website'=>clean($_POST['website']),
			'created_by'=>trim($_SESSION['u_userid']),
			'client'=>trim($_POST['client_id']),
			'inactive'=>$inactive,
			'last_modified'=>$date,
			'created_on'=>$date
			);
		$location_id = $client->insert($array_content);
		$employee_id = $client->getNameFromField('employees','id','person',$_SESSION['u_userid']);
		Ado::exec("INSERT INTO employee_to_locations SET `location`='$location_id', employee='$employee_id'");
		
		Core::setMessage("New Location added sucessfully", 1);
		Core::redirect(getUserLink('account', 'open-location', $location_id));
	}
}

?>
