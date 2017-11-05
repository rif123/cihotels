<?php
Class Setting_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	
	function get()
    {
		$this->db->where('id', 1);
		$result = $this->db->get('settings');
        return $result->row();
    }
	
	
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('settings', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('settings', $save);
            return $this->db->insert_id();
        }
    }
	 
    
    
   
}