<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	
	function save($save)
	{
		$this->db->insert('language',$save);
	}
	
	function update($save)
	{	$this->db->where('id',$id);	
		$this->db->update('language',$save);
	}
	
	function delete($id)
	{	$this->db->where('id',$id);	
		$this->db->delete('language');
	}
		
	function get_all()
	{
		//print_r($save);die;
		return $this->db->get('language')->result();
	}
	
	function get_language_id($id)
	{
				$this->db->where('id',$id);
		return $this->db->get('language')->row();
	}
	
	
}