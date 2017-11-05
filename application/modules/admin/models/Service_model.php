<?php
Class Service_model extends CI_Model
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
		$result = $this->db->get('services');
        return $result->result();
    }
	
	
    
	function get($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('services');
        return $result->row();
    }
	
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('services', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('services', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('services');
    }
	
	function get_room_types_services($id){
		$this->db->where('service_id', $id);
      return  $this->db->get('rel_room_types_services')->result();
	}
	function delete_room_types_services($id){
		$this->db->where('service_id', $id);
        $this->db->delete('rel_room_types_services');
	}
	function save_service_room_type($save){
		$this->db->insert_batch('rel_room_types_services',$save);
	}    
   
}