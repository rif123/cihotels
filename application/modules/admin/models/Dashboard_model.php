<?php
Class Dashboard_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	function get_coupons(){
								$this->db->where('date_from <=',date('Y-m-d H:i:s'));
								$this->db->where('date_to >=',date('Y-m-d H:i:s'));
			return 	$this->db->get('coupons')->result();	
   }
   function get_vips(){
								$this->db->where('vip',1);
			return 	$this->db->get('guests')->result();	
   }
   
    function get_orders()
    {
		$result = $this->db->get('orders');
        return $result->result();
    }
	function get_latest_bookings($limit)
    {
				  $this->db->limit($limit);	
				  $this->db->order_by('O.ordered_on','DESC');	
				  $this->db->select('O.*,R.title room, G.firstname,G.lastname');
				  $this->db->join('room_types R', 'R.id = O.room_type_id', 'LEFT');	
				  $this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');			
		$result = $this->db->get('orders O');
        return $result->result();
    }
	
	function get_rooms()
    {
		$result = $this->db->get('rooms');
        return $result->result();
    }
	
	function get_guests()
    {
		$result = $this->db->get('guests');
        return $result->result();
    }
	
	 function get_todays_revenue()
    {
				$this->db->where('DATE(date_time)',date('Y-m-d'));
				$this->db->select_sum('amount');
		return $this->db->get('payment')->row();
    }
	function get_total_income(){
		$this->db->select_sum('amount');
		return $this->db->get('payment')->row();
	}
	function get_payment_by_date($date){
		$this->db->where('DATE(date_time)',$date);
				$this->db->select_sum('amount');
		return $this->db->get('payment')->row();
	}   
}