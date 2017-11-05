<?php
Class Employee_model extends CI_Model
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
				  
		$result = $this->db->get('users');
        return $result->result();
    }
	
	function get($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('users');
        return $result->row();
    }
	
	
    function save($save)
    {
		
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('users', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('users', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }
    
    function check_username($username){
		$this->db->where('username', $username);
		$result = $this->db->get('users');
        return $result->row();
	}
   
}