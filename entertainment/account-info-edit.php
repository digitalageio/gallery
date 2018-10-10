<?php
/*
people->id 	first_name 	last_name 	email 	last_modified 	created_on 	user_type='backend' 	admin_type
users->id 	username 	created_on 	last_modified 	bcrypt_password
employees->id 	client 	person 	last_modified 	created_on 	type 	active
employee_to_locations->id 	employee 	location
user_roles->id 	user_id 	role_id
phone_numbers->id 	number 	type 	ext 	last_modified 	created_on
*/

$date = 'NOW()';
if (isset($_POST['btn_edit_user_entry']) && !empty($_POST['btn_edit_user_entry'])) 
{
	$user_id = $_POST['user_id'];
	$errors = array(); 
    $fields = array(); 
    $rules = array();
    $rules[] = "required,first_name,First name is required";
	$rules[] = "required,last_name,Last name is required";
    $rules[] = "required,email,Email is required";
    $rules[] = "valid_email,email,Enter the valid email address";
    $errors = validateFields($_POST, $rules);
	
	$admin = new Admin('users');
    if($admin ->checkUserExistOther("username",$_POST['username'],$user_id) == "exist")
        $errors[] = "Username already exists";
    
    if(!empty($errors))
        $message = $errors;
    else 
	{
		/*phone_numbers*/
		$cell_phone = $_POST['phone_numbers_id'];
		$number = $_POST['contact_phone1'].$_POST['contact_phone2'].$_POST['contact_phone3'];
		$client = new Client("phone_numbers");
		if(!empty($number))
		{
			if(empty($cell_phone))
			{
				$array_content = array(
					'number'=>trim($number),
					'type'=>2,
					'last_modified'=>$date,
					'created_on'=>$date
					);
				$cell_phone = $client->insert($array_content);
			}
			else
			{
				$update_array = array(
					'number'=>trim($number),
					'last_modified'=>$date
					);
				$where_array = array('id'=>$cell_phone);
				$client->update($update_array,$where_array);
			}
		}
		/*users*/
		$client = new Client("users");
		$update_array = array(
			'username'=>clean($_POST['username']),
			'last_modified'=>$date
			);
		$where_array = array('id'=>$user_id);
		$client->update($update_array,$where_array);
		if(isset($_POST['password']) and !empty($_POST['password']))
		{
			$password = trim($_POST['password']);
			$bcrypt_password = PassHash::hash($password);
			Ado::exec("UPDATE `users` SET `bcrypt_password`='$bcrypt_password' WHERE `id` = '$user_id'");
		}
		/*people*/
		$client = new Client("people");
		$update_array = array(
			'cell_phone'=>$cell_phone,
			'first_name'=>clean($_POST['first_name']),
			'last_name'=>clean($_POST['last_name']),
			'email'=>trim($_POST['email']),
			'last_modified'=>$date
			);
		$where_array = array('id'=>$user_id);
		$client->update($update_array,$where_array);
		
		
		Core::setMessage("Account info updated sucessfully", 1);
		Core::redirect(getUserLink('account', 'account-info'));
	}
}
?>