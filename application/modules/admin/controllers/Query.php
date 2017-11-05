<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Query extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	function index(){
		
		$this->db->query("ALTER TABLE `settings` ADD `meta_keywords` TEXT NULL DEFAULT NULL , ADD `meta_description` TEXT NULL DEFAULT NULL ;");
	}
	
}
