<?php
Class Calendar_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	function get_room_type()
    {
				$this->db->where('room_type_id',$_POST['room_type_id']);
				$this->db->select('rooms.*,count(room_no) as total_rooms');
		return  $this->db->get('rooms')->row();
    }
	
	function get_booking_by_room_type_and_date($date){
					$this->db->where('O.room_type_id',$_POST['room_type_id']);
					$this->db->where('R.date',$date);
					$this->db->select('R.*, COUNT(id) as bookings');
					$this->db->join('orders O', 'O.id = R.order_id', 'LEFT');
			return	$this->db->get('rel_orders_prices R')->row();
	}
	
	function get_first_order(){
				$this->db->order_by('check_in','SC');
		return	$this->db->get('orders')->row();
	}    
   
}