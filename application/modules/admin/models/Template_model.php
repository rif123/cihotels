<?php
Class Template_model extends CI_Model
{
	function __construct()
	{
			parent::__construct();
	}
	
	
	function get_all()
	{
		$res = $this->db->get('mail_templates');
		return $res->result_array();
	}
	
	function get($id)
	{
		$res = $this->db->where('id', $id)->get('mail_templates');
		return $res->row_array();
	}
	
	function save($data)
	{
		if($data['id'])
		{
			$this->db->where('id', $data['id'])->update('mail_templates', $data);
			return $data['id'];
		}
		else 
		{
			$this->db->insert('mail_templates', $data);
			return $this->db->insert_id();
		}
	}
	
	function delete($id)
	{
		$this->db->where('id', $id)->delete('mail_templates');
		return $id;
	}
	
	
}