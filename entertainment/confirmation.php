<?php
/*
cart_orders => id 	person 	ip_address 	transaction_id 	total 	last_modified 	created_on 	payment_by 	payment_status 	status 
cart_order_coupons => id 	order 	coupon 	value 	last_modified 	created_on 
cart_shipping_billing => id 	order 	fname 	email 	address 	city 	state 	country 	phone 	zip_code 	fnameb 	emailb 	addressb 	cityb 	stateb 	countryb 	phoneb 	zip_codeb 
cart_order_products => id 	order 	quantity 	product 	price 	last_modified 	created_on 	plan 
cart_products => id 	session_id 	product 	quantity 	last_modified 	created_on 	plan
*/
$obj_cart_product = new CartProducts('cart_products');

if(isset($_POST['btn_submit_braintree']) and !empty($_POST['btn_submit_braintree']) )
{
	$_SESSION['x_card_code'] = $_POST["x_card_code"];
	$name = explode(' ',$_POST['fnameb']);
	//session variable: subtotal u_client_name
	$result = Braintree_Customer::create(array(
		"firstName" => $name[0],
		"lastName" => $name[1],
		"company" => $_SESSION["u_client_name"],
		"email" => $_POST["email"],
		"phone" => $_POST["phone"],
		"creditCard" => array(
			"number" => $_POST["x_card_num"],
			"expirationMonth" => $_POST["month"],
			"expirationYear" => $_POST["year"],
			"cvv" => $_POST["x_card_code"],
			'billingAddress' => array(
				'firstName' => $name[0],
				'lastName' => $name[1],
				'company' => $_SESSION["u_client_name"],
				'streetAddress' => $_POST['addressb'],
				'locality' => $_POST['cityb'],
				'region' => $_POST['statenameb'],
				'postalCode' => $_POST['zip_codeb'],
				'countryCodeAlpha2' => $_POST['countrycodeb']
			)
			
		),
		'customFields' => array(
			'custom_field_one' => $_POST['total_amount'],
			'custom_field_two' => $sessionId
		)
		
	));
	
	if ($result->success) 
	{
		$customer_id = $result->customer->id;
		$total_amount = $result->customer->customFields['custom_field_one'];
		$session_id = $result->customer->customFields['custom_field_two'];
		
		$cc_plan = array();
		$plan_amount = 0;
		
		$sql_plan = "SELECT cms_product_plans.cc_plan, cms_product_plans.price
		FROM cart_products
		JOIN cms_product_plans ON cms_product_plans.id=cart_products.plan
		WHERE cart_products.session_id='$session_id' AND cart_products.plan IS NOT NULL";
		$res_plan=Ado::exec($sql_plan);
		if(Ado::count($res_plan)>0)
		{
			while($row_plan = Ado::fetch($res_plan))
			{
				$cc_plan[] = trim($row_plan['cc_plan']);
				$plan_amount = $row_plan['price']+$plan_amount;
			}
		}
		$new_amount = $total_amount-$plan_amount;
		/* if plan */
		if(is_array($cc_plan) and count($cc_plan)>0)
		{
			$customer = Braintree_Customer::find($customer_id);
			$payment_method_token = $customer->creditCards[0]->token;
			
			foreach($cc_plan as $planid)
			{
				$subs_result = Braintree_Subscription::create(array(
					'paymentMethodToken' => $payment_method_token,
					'planId' => $planid
				));
			}
			$transaction_id = $subs_result->subscription->transactions[0]->id;
		}
		if($new_amount>0)
		{
			$payment_result = Braintree_Transaction::sale(
			array(
				'customerId' => $customer_id,
				'amount' => $new_amount,
				'creditCard' => array(
				  'cvv' => $_SESSION['x_card_code']
				),
				'options' => array(
					'submitForSettlement' => true
				  )
			  )
			);
			if ($payment_result->success) 
			{
				$transaction_id = $payment_result->transaction->id;
				$payment_by = 'braintree';
				$order_id = $obj_cart_product->insertNewOrder($session_id,$transaction_id,$payment_by);
				$obj_cart_product->emailBuyer($order_id);
				$obj_cart_product->emailMerchant($order_id);

				Core::setMessage("Thank you for your purchase.  If you have purchased any digital products, please click the product name in your order history to access your products.  To re-visit or re-download the products, you can login and go to My Account > Order History.", 1);
				Core::redirect(getUserLink('orders', 'order-detail',$order_id));
			} 
			else
			{
				$errors = array(); 
				foreach (($payment_result->errors->deepAll()) as $error) 
				{
					$errors[] = $error->message . "<br/>";
				}
			}
		}
		else
		{
			$payment_by = 'braintree';
			$order_id = $obj_cart_product->insertNewOrder($session_id,$transaction_id,$payment_by);
			$obj_cart_product->emailBuyer($order_id);
			$obj_cart_product->emailMerchant($order_id);
			Core::setMessage("Thank you for your purchase.  If you have purchased any digital products, please click the product name in your order history to access your products.  To re-visit or re-download the products, you can login and go to My Account > Order History.", 1);
			Core::redirect(getUserLink('orders', 'order-detail',$order_id));
		}
		//echo $session_id."---".$transaction_id."---".$payment_by;
	}
	else
	{
		$errors = array(); 
		foreach (($result->errors->deepAll()) as $error) 
		{
			$errors[] = $error->message . "<br/>";
		}
	}
}
else if(isset($_POST['btn_submit_no_braintree']) and !empty($_POST['btn_submit_no_braintree']) )
{
	$session_id = $sessionId;
	$transaction_id = randomPassword(10);
	$payment_by = 'free';
	$order_id = $obj_cart_product->insertNewOrder($session_id,$transaction_id,$payment_by);
	$obj_cart_product->emailBuyer($order_id);
	$obj_cart_product->emailMerchant($order_id);
	Core::setMessage("Thank you for your purchase.  If you have purchased any digital products, please click the product name in your order history to access your products.  To re-visit or re-download the products, you can login and go to My Account > Order History.", 1);
	Core::redirect(getUserLink('orders', 'order-detail',$order_id));
}
