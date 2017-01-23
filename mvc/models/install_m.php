<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install_m extends CI_Model{

	function __construct() {
		parent::__construct();
		$this->sql_path		= APPPATH.'models/inilabs_csm.sql';
		$this->load->helper('file');
		$this->load->helper('url');				
		$this->load->database();
	}

	public function insert_setting($data) {
		$this->db->insert('settings', $data);
		return TRUE;
	}

	public function select_setting() {
		$this->db->select('*');
		$query = $this->db->get('settings');
		return $query->result();
	}

	public function update_setting($data, $id) {
		$this->db->where('settingID', $id);
		$this->db->update('settings', $data); 
		return TRUE;

	}

	public function hash($string) {
		return hash("sha512", $string . config_item("encryption_key"));
	}
	
	public function use_sql_string() {
		$sql = read_file($this->sql_path);
		$sql = trim($sql);
	   	$sql = $this->db->_prep_query($sql);
	   	// dump($this->db->hostname);
	   	// dump($this->db->username);
		$link = @mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);		
		mysqli_multi_query($link, $sql);		
	}
}	
?>