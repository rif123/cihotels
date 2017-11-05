<?php
Class Building_model extends CI_Model
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
		$result = $this->db->get('building');
        return $result->result();
    }
	
	
    
	function get($id)
    {
		$this->db->where('idBuilding', $id);
		$result = $this->db->get('building');
        return $result->row();
    }
	
	
   
    
    function save($save)
    {
        if ($save['idBuilding'])
        {
            $this->db->where('idBuilding', $save['idBuilding']);
            $this->db->update('building', $save);
            return $save['idBuilding'];
        }
        else
        {
            $this->db->insert('building', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('idBuilding', $id);
        $this->db->delete('building');
    }
    
    
   
}