<?php
Class Room_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	
	function get_states()
    {
		$this->db->select('COUNT(room_no) as total_rooms');	
		$result = $this->db->get('rooms');
        return $result->row();
    }
    function get_all()
    {
		$this->db->select('R.*,F.name floor,RT.title room_type,F.floor_no');
		$this->db->join('floors F', 'F.id = R.floor_id', 'LEFT');
		$this->db->join('room_types RT', 'RT.id = R.room_type_id', 'LEFT');
		$result = $this->db->get('rooms R');
        return $result->result();
    }
	
	function get_by_room_no($no,$id)
    {
		if($id>0){
			$this->db->where('id !=',$id);
		}
		$this->db->where('room_no',$no);
		$result = $this->db->get('rooms');
        return $result->row();
    }
	
	function get_booked_room()
    {
		$this->db->where('date',date('Y-m-d'));
		$this->db->where('room_id >',0);
		$result = $this->db->get('rel_orders_prices');
        return $result->result();
    }
	
	
	
	
    
	function get($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('rooms');
        return $result->row();
    }
	
	
   
    
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('rooms', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('rooms', $save);
            return $this->db->insert_id();
        }
    }
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rooms');
    }
    

    function getByBuilding($idGedung) {
        $q  = "SELECT *,room_types.id  as idTypeRooms  FROM `room_types` LEFT JOIN rooms on room_types.id = rooms.room_type_id where rooms.idGedung = '".$idGedung."' GROUP BY room_types.id";
        $result = $this->db->query($q)->result_array();
        return $result;
    }

    function getByRoomNo($id) {
        $q  = "SELECT *, room_types.id  as idTypeRooms FROM `room_types` LEFT JOIN rooms on room_types.id = rooms.room_type_id where room_types.id  = '".$id."'";
        $result = $this->db->query($q)->result_array();
        return $result;
    }
    
}