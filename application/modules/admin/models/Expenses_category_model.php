<?php
Class Expenses_category_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	
    function get_all()
    {
		$result = $this->db->get('expenses_category');
        return $result->result();
    }
	
	
    
	function get($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('expenses_category');
        return $result->row();
    }
	
	
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('expenses_category', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('expenses_category', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('expenses_category');
    }
    
    
   
}