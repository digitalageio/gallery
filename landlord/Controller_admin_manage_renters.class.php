<?php

class Controller_admin_manage_renters extends Controller
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
    if(!empty($_POST)){
      //derp('POST', $_POST);
      if(!empty($_POST['delete'])){
        //Handle delete
        foreach($_POST as $key => $ignore_me){
          //Test if key is a renter
          if(strpos($key, 'renter') !== FALSE){
            $id = str_replace('renter', '', $key);
            $result = $this->_tables->get('renters')->delete($id);
          }
        }
      }
      if(!empty($_POST['login'])){
        //Handle login
        $ids = array();
        foreach($_POST as $key => $ignore_me){
          //Test if key is a renter
          if(strpos($key, 'renter') !== FALSE){
            $ids[] = str_replace('renter', '', $key);

          }
        }
        if(count($ids) > 1){
	  $this->_messages->throw_error('You can only log in as 1 renter at a time');
          $ret->redirect = 'admin/manage-renters';
        }
        else if(count($ids) < 1){
	  $this->_messages->throw_error('Please select a renter to login as');
          $ret->redirect = 'admin/manage-renters';
        }
        else{
          //Do the login
          //but how...? Like this!!!
          //derp('id', $ids[0]);
          $this->_accounts->log_in('renters', $ids[0]);
          //that was easy
          //no send them on their way
          $ret->redirect = 'renters';
        }
      }
      if(!empty($_POST['change'])){
        //Handle credential change
        $ids = array();
        foreach($_POST as $key => $ignore_me){
          //Test if key is a renter
          if(strpos($key, 'renter') !== FALSE){
            $ids[] = str_replace('renter', '', $key);

          }
        }
        if(count($ids) > 1){
	  $this->_messages->throw_error('You can change credentials for only 1 renter at a time');
          $ret->redirect = 'admin/manage-renters';
        }
        else if(count($ids) < 1){
	  $this->_messages->throw_error('Please select a renter to login as');
          $ret->redirect = 'admin/manage-renters';
        }

        else{
          $ret->redirect = 'admin/manage-renters/change-credentials?id=' . $ids[0];
        }
      }
    }
    
    $sort = "";
    switch($_GET['sort']){
      case "last":
        $ret->last = 'last';
        if($_GET['order'] == 'asc'){
          $sort =  array('name_last' => 'asc');
          $ret->order = 'dsc';
        }elseif($_GET['order'] == 'dsc'){
          $sort = array('name_last' => 'desc');
          $ret->order = 'asc';
        }
        break;
      case "first":
        $ret->last = 'first';
        if($_GET['order'] == 'asc'){
          $sort =  array('name_first' => 'asc');
          $ret->order = 'dsc';
        }elseif($_GET['order'] == 'dsc'){
          $sort = array('name_first' => 'desc');
          $ret->order = 'asc';
        }
        break;
      case "email":
        $ret->last = 'email';
        if($_GET['order'] == 'asc'){
          $sort =  array('email' => 'asc');
          $ret->order = 'dsc';
        }elseif($_GET['order'] == 'dsc'){
          $sort = array('email' => 'desc');
          $ret->order = 'asc';
        }
        break;
      case "state":
        $ret->last = 'state';
        if($_GET['order'] == 'asc'){
          $sort =  array('address_state' => 'asc');
          $ret->order = 'dsc';
        }elseif($_GET['order'] == 'dsc'){
          $sort = array('address_state' => 'desc');
          $ret->order = 'asc';
        }
        break;
    }
    //derp('sort', $sort);
    
    $sort_array = array('last', 'first', 'email', 'state');

    $renters = $this->_get_table_by_sorted($ret, 'renters', $sort_array);
    $ret->renters = $renters;
  }

  public function change_credentials($ret){
    $ret->id = $_GET['id'];  
    $renter = $this->_tables->get('renters')->view($ret->id)->item;
    $ret->renter = $renter;

    if(!empty($_POST)){
      $post = Utility::clean_for_php_r(Utility::keep_r($_POST, array(
	'email' => true,
	'password1' => true,
        'password2' => true,
      )));

      $email = $post['email'];
      $password1 = $post['password1'];
      $password2 = $post['password2'];

      $dupe_user = $this->_tables->get('renters')->get_by_email($row->email);
      $ret->redirect = 'admin/manage-renters/change-credentials?id=' . $ret->id;
      if(!Utility::looks_like_email($email)){
        $this->_messages->throw_error('Please enter a valid email address');
      }
      elseif ($dupe_user) {
        $this->_messages->throw_error('That email address is already registered.');
      }

      elseif(!empty($password2) && $password1 !== $password2){
        $this->_messages->throw_error('Passwords must match');
      }
      else{
        $ret->redirect = 'admin/manage-renters?id=' . $ret->id;
        $renter = array('id'=>$ret->id, 'email'=>$email);
        if(!empty($password2) && $password1 === $password2){
          $renter['password'] = $password1;   
        }
        $update_row = new TableRow($renter);
        $result = $this->_tables->get('renters')->update($update_row);
        //derp('result', $result);
      }
    }
  }
}


