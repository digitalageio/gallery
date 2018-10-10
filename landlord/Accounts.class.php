<?php

class Accounts
{
	protected $_active;
	protected $_router;
	protected $_tables;
	
	const SESSION_CONTAINER_NAME = 'accounts';
	
	private function _log_in($table_name, $id)
	{
		$table = $this->_tables->get($table_name);
		
		if (!$id) {
			throw new Exception('Row ID for table ' . $table_name . ' is falsy: ' . $id);
		}
		
		$row = $table->view($id)->item;
		
		if (!$row) {
			throw new Exception('Row ID ' . $id . ' is falsy: ' . $row);
		}
		
		$this->_active[$table_name] = $row;
		$_SESSION[self::SESSION_CONTAINER_NAME][$table_name] = $id;
	}
	
	public function __construct($router, $tables)
	{
		$this->_router = $router;
		$this->_tables = $tables;
		
		// Discover and load active accounts
		$this->_active = array();
		
		if (!isset($_SESSION[self::SESSION_CONTAINER_NAME])) {
			$_SESSION[self::SESSION_CONTAINER_NAME] = array();
		}
		
		if (!is_array($_SESSION[self::SESSION_CONTAINER_NAME])) {
			throw new Exception('Account session container exists but is not an array.');
		}
		
		// Load up each active account
		foreach ($_SESSION[self::SESSION_CONTAINER_NAME] as $table_name => $id) {
			$this->_log_in($table_name, $id);
		}
	}
	
	public function get($table_name)
	{
		return isset($this->_active[$table_name]) ? $this->_active[$table_name] : false;
	}
	
	public function log_in($table_name, $id)
	{
		$this->_log_in($table_name, $id);
	}
	
	public function log_out($table_name)
	{
		unset($this->_active[$table_name]);
		unset($_SESSION[self::SESSION_CONTAINER_NAME][$table_name]);
	}
	
	public function logged_in($table_name)
	{
		return isset($this->_active[$table_name]);
	}
}
