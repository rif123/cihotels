<?php
Class Testimonial_model extends CI_Model
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
		$result = $this->db->get('testimonials');
        return $result->result();
    }
	
	function get($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('testimonials');
        return $result->row();
    }
	
	
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('testimonials', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('testimonials', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('testimonials');
    }
    
    
   
}