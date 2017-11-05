<?php
Class Gallery_model extends CI_Model
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
		$result = $this->db->get('gallery');
        return $result->result();
    }
	
	function get($id)
    {
		$this->db->where('G.id', $id);
		$this->db->select('G.*');
		$result = $this->db->get('gallery G');
        return $result->row();
    }
	function get_image($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('rel_gallery_image');
        return $result->row();
    }
	function get_images($id)
    {
		$this->db->where('gallery_id', $id);
		$result = $this->db->get('rel_gallery_image');
        return $result->result();
    }
	function save_images($save){
		$this->db->insert('rel_gallery_image', $save);
	}
	function update_images($save,$id){
		$this->db->where('id', $id);
		$this->db->update('rel_gallery_image', $save);
	}
	
	function delete_image($id){
		$this->db->where('id', $id);
		$this->db->delete('rel_gallery_image');
	}
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('gallery', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('gallery', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('gallery');
    }
    
    
   
}