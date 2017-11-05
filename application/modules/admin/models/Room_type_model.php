<?php
Class Room_type_model extends CI_Model
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
		$result = $this->db->get('room_types');
        return $result->result();
    }
	
	
    
	function get($id)
    {
		$this->db->where('R.id', $id);
		$this->db->select('R.*,GROUP_CONCAT(A.name) as ams');
		$this->db->join('rel_room_types_amenities RR', 'R.id = RR.room_type_id', 'LEFT');
		$this->db->join('amenities A', 'A.id = RR.amenity_id', 'LEFT');
		$result = $this->db->get('room_types R');
        return $result->row();
    }
	function get_images($id)
    {
		$this->db->where('room_type_id', $id);
		$result = $this->db->get('room_types_images');
        return $result->result();
    }
	
	function update_images($save,$id){
		$this->db->where('id', $id);
		$this->db->update('room_types_images',$save);
	}
	
	function unset_featured($value,$id){
		$this->db->where('room_type_id', $id);
		$this->db->set('is_featured', $value);
		$this->db->update('room_types_images');
	}
	
	function set_featured($id){
		$this->db->where('id', $id);
		$this->db->set('is_featured', 1);
		$this->db->update('room_types_images');
	}
	
	function get_image($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('room_types_images');
        return $result->row();
    }
	function delete_image($id)
    {
		$this->db->where('id', $id);
		$this->db->delete('room_types_images');
       
    }
	
	function save_images($save){
		$this->db->insert('room_types_images', $save);
	}	
   
    
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('room_types', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('room_types', $save);
            return $this->db->insert_id();
        }
    }
	 function get_amenities($id){
	 			$this->db->where('room_type_id',$id);
	 	return $this->db->get('rel_room_types_amenities')->result();
	 }
	 function save_amenity($save){
	 	$this->db->insert_batch('rel_room_types_amenities', $save);
	 }
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('room_types');
    }
    
	function delete_roomtype($id){
					$this->db->where('room_type_id',$id);
	 				$this->db->delete('rel_room_types_amenities');
	}
	function check_slug($slug, $id=false)
	{
		if($id)
		{
			$this->db->where('id !=', $id);
		}
		$this->db->where('slug', $slug);
		
		return (bool) $this->db->count_all_results('room_types');
	}
	
	function validate_slug($slug, $id=false, $count=false)
	{
		if($this->check_slug($slug.$count, $id))
		{
			if(!$count)
			{
				$count	= 1;
			}
			else
			{
				$count++;
			}
			return $this->validate_slug($slug, $id, $count);
		}
		else
		{
			return $slug.$count;
		}
	}
	    
   
}