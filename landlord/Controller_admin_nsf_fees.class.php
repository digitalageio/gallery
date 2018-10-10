<?php

class Controller_admin_nsf_fees extends Controller
{
	protected $_user;
	
	public function __construct($params)
	{
		parent::__construct($params);
		
		// Check user status
		$this->_user = $this->_accounts->get('admins');
		//derp('this->_user', $this->_user);
		
		$result = new GenericResult(false, __METHOD__);
		
		// see if I have a method
		$method = empty($this->_request->args_current[0]) ? 'home' : $this->_method_from_arg($this->_request->args_current[0]);
		//derp('method', $method);
		
		// Enforce login restrictions
		if (!$this->_user) {
			$this->_messages->throw_error('Insufficient permissions. Please log in as an administrator first.');
			$_SESSION['admin_post_login_uri'] = $_SERVER['REQUEST_URI'];
			$this->_redirect($this->_request->base . 'admin');
		} else {
			if (is_callable(array($this, $method))) {
				$this->$method($result);
			}
			
			// Handle result
			if ($result->redirect) {
				// Throw messages if needed
				if (!empty($result->throw)) {
					$this->_messages->throw_result($result->throw);
				}
				
				//header('Location: ' . $this->_request->base . $result->redirect);
				$this->_redirect($result->redirect);
			} else {
				if (isset($result->render) && !$result->render) {
					// Action said don't render
				} else {
					// Render this page
					header('Content-Type: text/html; charset=UTF-8');
					
					$vars = $this->_normal_page_vars();
					
					// Load values from action method into the template
					foreach ($result as $key => $value) {
						if (!in_array($key, array('error', 'origin', 'message', 'render', 'redirect'))) {
							$vars[$key] = $value;
						}
					}
					
					// Kinda has to go last
					$vars['elapsed'] = microtime(true) - $this->_request->time;
					
					// Generate HTML
					echo $this->_render_html('_layout_admin.tpl', $vars);
				}
			}
		}
	}
	
	public function home($ret)
	{
		$txn = trim($this->_request->get('txn'));
		
		$payments = !strlen($txn) ? array() : $this->_tables->get('payments')->get(array(
			'where' => "transaction_id LIKE '%" . $txn . "%'",
			'order' => array('created' => 'desc'),
		))->table;
		
		foreach ($payments as &$payment) {
			$payment['_invoice'] = $this->_tables->get('invoices')->view($payment['invoice_id'])->item;
		}
		
		$ret->payments = $payments;
		
	}
	
	public function invoice_edit($ret)
	{
		$smart_form_name = $this->_smart_form_name(__METHOD__);
		
		$ret->redirect = 'admin/nsf-fees';
		
		try {
			$invoice = $this->_tables->get('invoices')->view($this->_request->get('id'))->item;
			if (!$invoice) {
				throw new Exception('Invoice not found.');
			}
			
			$ret->redirect = 'admin/nsf-fees/invoice-edit?id=' . $invoice['id'];
			
			if (!empty($_POST)) {
				$post = Utility::keep_with_defaults_r(Utility::clean_for_php_r($_POST), array(
					'id' => $invoice['id'],
					'amount_paid' => 0.0,
					'amount_due' => 0.0,
					'late_fee' => 0.0,
					'nsf_fee' => 0.0,
					'paid' => 0,
				));
				
				$this->_smart_forms->set($smart_form_name, $post);
				
				$row = new TableRow($post);
				//derp('row', $row);
				
				$update_result = $this->_tables->get('invoices')->update($row);
				//derp('update_result', $update_result);
				
				if ($update_result->error) {
					throw new Exception($update_result->message);
				}
				
				$this->_messages->throw_note('Invoice saved.');
				
				$this->_smart_forms->clear($smart_form_name);
				
				$ret->redirect = 'admin/nsf-fees';
				
			} else {
				$ret->redirect = false;
				
				$ret->smart_form = array_merge($invoice, $this->_smart_forms->get($smart_form_name));
				
				// Additional data
				$ret->schedule = $this->_tables->get('listing_rent_payment_schedules')->view($invoice['rent_payment_schedule_id'])->item;
				
				$ret->listing = $this->_tables->get('listings')->view($ret->schedule['listing_id'])->item;
				
				$ret->occupants = $this->_tables->get('occupants')->get(array(
					'where' => array('schedule_id = ?', $ret->schedule['id']),
					'order' => array('email' => 'asc'),
				))->table;
				
				//derp('ret', $ret);
			}
		} catch (Exception $e) {
			$this->_messages->throw_error($e->getMessage());
		}
	}
}
