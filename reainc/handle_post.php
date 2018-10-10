<?php include("wut.php");

$okay = TRUE;

if (empty($_POST['last_name']) || !ctype_alpha($_POST['last_name'])) {
	print '<p>Please enter your last name.</p>';
	$okay = FALSE;	
} else {$last_name=$_POST['last_name'];
}

if (empty($_POST['first_name']) || !ctype_alpha($_POST['first_name'])) {
	print '<p>Please enter your first name.</p>';
	$okay = FALSE;
} else {$first_name=$_POST['first_name'];
}

$middle_init=$_POST['middle_init'];

if (empty($_POST['company_name'])) {
	print '<p>Please enter your company\'s name.</p>';
	$okay = FALSE;
} else {$company_name=$_POST['company_name'];
}

$home_county=$_POST['home_county'];

list($username, $domain)=explode('@', $_POST['email']);

if (empty($_POST['email']) || !checkdnsrr($domain,'ANY')) {
	print '<p>Please enter a valid email address.</p>';
	$okay = FALSE;
} else {$email=$_POST['email'];
}

if (empty($_POST['phone']) || (!is_numeric($_POST['phone']))) {
	print '<p>Please enter your phone number.</p>';
	$okay = FALSE;
} else {$phone=$_POST['phone'];
}

$primary = $_POST['first_county'];

$secondary = $_POST['choices'];

$j = count($secondary);

if($j>4) {
	$okay = FALSE;
	print 'You may only select a maximum of four additional counties.';
}

if($okay){
	print "<p>You have successfully registered as:</p>";
	print "$last_name</br>";
	print "$first_name $middle_init</br>";
	print "$company_name</br>";
	print "$home_county</br>"; 
	print "$email</br>";
	print "$phone</br>";
	print "<p>Subscribed to the following counties:</p>";
	print "$primary</br>";
	for($i=0; $i<$j; $i++) {
	print "$secondary[$i]";
	print "</br>";
	} 
	$allofit = array( $last_name, $first_name, $middle_init, $company_name, $home_county, $email, $phone, $primary );
	for($k=8; $k<($j+8); $k++) {
	$allofit[$k] = $secondary[$k-8];
	}
	$excel = implode(',', $allofit);
	mail('ashanno2@gmail.com', 'howdy', $excel);
}

?>

</body>
</html>




