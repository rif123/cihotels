<?php
Class Book_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
    }
	
	function save_order($save)
    {
			   	
		       $this->db->insert('orders',$save);
		return $this->db->insert_id();
    }
	function save_payment($save){
		$this->db->insert('payment',$save);
	} 
	function update_order($save,$id)
    {
			 	$this->db->where('id',$id);
			   $this->db->update('orders',$save);
    }
	
	function save_taxes($save)
    {
		       $this->db->insert_batch('rel_orders_taxes',$save);
	}
	function save_price($save)
    {
		       $this->db->insert_batch('rel_orders_prices',$save);
	}
	
	function save_service($save){
		$this->db->insert_batch('rel_orders_services',$save);
	}	
    
	function get_order($id)
    {
		$this->db->where('O.id',$id);
		$this->db->select('O.*,G.firstname,G.lastname,G.mobile,RT.title room_type,C.currrency_symbol cs,G.email');
		$this->db->join('room_types RT', 'RT.id = O.room_type_id', 'LEFT');
		$this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');
		$this->db->join('currency C', 'C.currency_code = O.currency', 'LEFT');
		$result = $this->db->get('orders O');
        return $result->row();
    }
	function get_taxes($id)
    {
		$this->db->where('OT.order_id',$id);
		$this->db->group_by('T.id');
		$this->db->select('OT.amount,T.name,T.rate,T.type');
		$this->db->join('taxes T', 'T.id = OT.tax_id', 'LEFT');
		$result = $this->db->get('rel_orders_taxes OT');
        return $result->result();
    }
	function get_services($id)
    {
		$this->db->where('OS.order_id',$id);
		$this->db->select('OS.amount,S.title,S.price_type,S.id');
		$this->db->join('services S', 'S.id = OS.service_id', 'LEFT');
		$result = $this->db->get('rel_orders_services OS');
        return $result->result();
    }
	
	function get_prices($id)
    {
		$this->db->where('order_id',$id);
		$result = $this->db->get('rel_orders_prices');
        return $result->result();
    }
    
   
}