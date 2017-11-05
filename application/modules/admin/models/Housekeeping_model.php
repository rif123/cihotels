<?php
Class Housekeeping_model extends CI_Model
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
		$this->db->select('H.*,R.room_no room_number,HS.title status,F.name floor,RT.title room_type,U.firstname,U.lastname');
		$this->db->join('house_keeping_status HS', 'HS.id = H.housekeeping_status', 'LEFT');
		$this->db->join('rooms R', 'R.id = H.room_id', 'LEFT');
		$this->db->join('room_types RT', 'RT.id = R.room_type_id', 'LEFT');
		$this->db->join('floors F', 'F.id = R.floor_id', 'LEFT');
		$this->db->join('users U', 'U.id = H.assigned_to', 'LEFT');
		$result = $this->db->get('housekeeping H');
        return $result->result();
    }

    function get_this_date_house($date)
    {
        $this->db->group_by(array('MONTH(date)'));
        $this->db->where('DATE(date)', $date);
        $this->db->select('SUM(id) as total');
        return  $this->db->get('housekeeping')->row();
    }
    function get_this_year_house($y, $m)
    {
        $this->db->group_by(array('MONTH(date)'));
        $this->db->where('MONTH(date)', $m);
        $this->db->where('YEAR(date)', $y);
        $this->db->select('SUM(id) as total');
        return  $this->db->get('housekeeping')->row();
    }
	
	 function get_all_by_room($id)
    {
		$this->db->where('H.room_id',$id);
		$this->db->select('H.*,R.room_no room_number,HS.title status,F.name floor,RT.title room_type,U.firstname,U.lastname');
		$this->db->join('house_keeping_status HS', 'HS.id = H.housekeeping_status', 'LEFT');
		$this->db->join('rooms R', 'R.id = H.room_id', 'LEFT');
		$this->db->join('room_types RT', 'RT.id = R.room_type_id', 'LEFT');
		$this->db->join('floors F', 'F.id = R.floor_id', 'LEFT');
		$this->db->join('users U', 'U.id = H.assigned_to', 'LEFT');
		$result = $this->db->get('housekeeping H');
        return $result->result();
    }
	
	function get($id)
    {
		$this->db->where('H.id', $id);
		$this->db->select('H.*,R.room_no room_number,HS.title status,F.name floor,RT.title room_type,U.firstname,U.lastname');
		$this->db->join('house_keeping_status HS', 'HS.id = H.housekeeping_status', 'LEFT');
		$this->db->join('rooms R', 'R.id = H.room_id', 'LEFT');
		$this->db->join('room_types RT', 'RT.id = R.room_type_id', 'LEFT');
		$this->db->join('floors F', 'F.id = R.floor_id', 'LEFT');
		$this->db->join('users U', 'U.id = H.assigned_to', 'LEFT');
		$result = $this->db->get('housekeeping H');
        return $result->row();
    }
	
	
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('housekeeping', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('housekeeping', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('housekeeping');
    }
    
    
   
}