<?php
Class Expenses_model extends CI_Model
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
		$this->db->order_by('E.date', 'DESC');
		$this->db->select('E.*,EC.name ecategory');
		$this->db->join('expenses_category EC', 'EC.id = E.expanses_category_id', 'LEFT');
		$result = $this->db->get('expanses E');
        return $result->result();
    }
	
	function get($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('expanses');
        return $result->row();
    }
	
	
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('expanses', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('expanses', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('expanses');
    }
    
    
   
}