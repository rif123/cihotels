<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	function save($save)
	{
		//echo '<pre>'; print_r($save);die;
		$flag = false;
		if(!empty($save['id']))
			$flag = $this->db->update('currency',$save,array('id'=>$save['id']));
		else
			$flag = $this->db->insert('currency',$save);
		
		return $flag;
	}
	function get_all()
	{
			$this->db->order_by('name','ASC');		
			return $this->db->get('currency')->result();
	}
	function get_currency_front(){
		$this->db->order_by('currency_code','ASC');
		$this->db->where('status',1);		
			return $this->db->get('currency')->result();
		
	}
	
	function get_currency_by_id($id)
	{
			   $this->db->where('id',$id);
		return $this->db->get('currency')->row();
	}
	function get_currency_code($code){
		 $this->db->where('currency_code',$code);
		return $this->db->get('currency')->row();
	}
	function update($save,$id)
	{
			   $this->db->where('id',$id);
		       $this->db->update('currency',$save);
	}
	
	
	function delete($id)//delte 
	{
			   $this->db->where('id',$id);
		       $this->db->delete('currency');
	}
}