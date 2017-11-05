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
	
    function get_gallery()
    {
		return $this->db->get('gallery')->result();
    }
	
	function get_images()
    {
		$result = $this->db->get('rel_gallery_image');
        return $result->result();
    }

	function get_amenities_active($id)
    {
				 $this->db->where('R.room_type_id', $id);
				 $this->db->where('A.active',1);	
				 $this->db->select('A.*');
				 $this->db->join('amenities A', 'A.id = R.amenity_id', 'LEFT');
		return $this->db->get('rel_room_types_amenities R')->result();
    }
	
	function get_testimonials()
    {	
				$this->db->order_by('id', 'RANDOM');
		return $this->db->get('testimonials',4)->result();
    }
	function get_room_types()
    {
				$this->db->order_by('id', 'RANDOM');
		return $this->db->get('room_types',4)->result();
    }
	function get_room_type($id)
    {
				$this->db->where('id', $id);
		return $this->db->get('room_types')->row();
    }
	
	function get_room_types_all()
    {
			   $this->db->order_by('title', 'ASC');	
		return $this->db->get('room_types')->result();
    }
	
	function get_taxes()
    {
			   			 $this->db->where('id', 1);	
		$setting	=	 $this->db->get('settings')->row();
		$tids		=	json_decode($setting->taxes);
		if(empty($tids)){
			return false;
		}else{
			$this->db->where_in('id', $tids);
			return $this->db->get('taxes')->result();
    	}
	}
	
	function get_paid_services($id)
    {
			   $this->db->where('R.room_type_id', $id);	
			    $this->db->where('S.status',1);	
		       $this->db->join('rel_room_types_services R', 'S.id = R.service_id', 'LEFT');
		return $this->db->get('services S')->result();
    }
	
	function get_amenities($id)
    {
				 $this->db->where('R.room_type_id', $id);	
				 $this->db->select('A.*');
				 $this->db->join('amenities A', 'A.id = R.amenity_id', 'LEFT');
		return $this->db->get('rel_room_types_amenities R')->result();
    }
    

    function get_currency()
    {
				$this->db->where('status', 1);
		return $this->db->get('currency')->result();
    }
   
   function get_currency_by_currency_code($c_code){
   			   $this->db->where('currency_code', $c_code);
		return $this->db->get('currency')->row();
   }
   
   function get_coupons(){
								$this->db->where('date_from <=',date('Y-m-d H:i:s'));
								$this->db->where('date_to >=',date('Y-m-d H:i:s'));
			return 	$this->db->get('coupons')->result();	
   }
}