<?php
Class Report_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	function get_this_week_occupancy($date)
    {
				if(!empty($_POST['room_type_id'])){
					$this->db->where('O.room_type_id', $_POST['room_type_id']);
				}
				$this->db->group_by(array('MONTH(R.date)'));
				$this->db->where('DATE(R.date)', $date);
				$this->db->where('O.payment_status', 1);
				$this->db->select('SUM(O.adults) + SUM(O.additional_person) as total');
				$this->db->join('orders O', 'R.order_id = O.id', 'LEFT');
		return  $this->db->get('rel_orders_prices R')->row();
    }
	
	function get_this_year_occupancy($y,$m)
	 {
	 			if(!empty($_POST['room_type_id'])){
					$this->db->where('O.room_type_id', $_POST['room_type_id']);
				}
				$this->db->where('MONTH(R.date)', $m);
				$this->db->where('YEAR(R.date)', $y);
				$this->db->where('O.payment_status', 1);
				$this->db->select('SUM(O.adults) + SUM(O.additional_person) as total');
				$this->db->join('orders O', 'R.order_id = O.id', 'LEFT');
		return  $this->db->get('rel_orders_prices R')->row();
    }
	
	
	function get_this_date_guest($date){
				$this->db->group_by(array('MONTH(added)'));
				$this->db->where('DATE(added)', $date);
				$this->db->select('COUNT(id) as total');
		return  $this->db->get('guests')->row();
	}
	
	function get_this_year_guest($y,$m)
	 {
	 			$this->db->where('MONTH(added)', $m);
				$this->db->where('YEAR(added)', $y);
				$this->db->select('COUNT(id) as total');
		return  $this->db->get('guests')->row();
    }
   
   
   function get_this_date_financial($date)
    {
				$this->db->group_by(array('MONTH(P.date_time)'));
				$this->db->where('DATE(P.date_time)', $date);
				$this->db->where('O.payment_status', 1);
				$this->db->select('SUM(P.amount) as total');
				$this->db->join('orders O', 'P.order_id = O.id', 'LEFT');
		return  $this->db->get('payment P')->row();
    }
	
	function get_this_year_financial($y,$m)
	 {
	 			$this->db->where('MONTH(P.date_time)', $m);
				$this->db->where('YEAR(P.date_time)', $y);
				$this->db->where('O.payment_status', 1);
				$this->db->select('SUM(P.amount) as total');
				$this->db->join('orders O', 'P.order_id = O.id', 'LEFT');
		return  $this->db->get('payment P')->row();
    }
	
	
	function get_this_date_coupon($date)
    {
				if(!empty($_POST['coupon'])){
					$this->db->where('coupon', $_POST['coupon']);
				}
				$this->db->group_by(array('MONTH(ordered_on)'));
				$this->db->where('DATE(ordered_on)', $date);
				$this->db->where('payment_status', 1);
				$this->db->select('SUM(coupon_discount) as amount,COUNT(coupon) as coupons');
		return  $this->db->get('orders')->row();
    }
	
	function get_this_year_coupon($y,$m)
	 {
	 			if(!empty($_POST['coupon'])){
					$this->db->where('coupon', $_POST['coupon']);
				}
				$this->db->where('MONTH(ordered_on)', $m);
				$this->db->where('YEAR(ordered_on)', $y);
				$this->db->where('payment_status', 1);
				$this->db->select('SUM(coupon_discount) as amount,COUNT(coupon) as coupons');
		return  $this->db->get('orders')->row();
    }
	
	function get_coupons()
	 {
		return  $this->db->get('coupons')->result();
    }
	
	function get_this_date_expenses($date)
    {
				if(!empty($_POST['ecategory_id'])){
					$this->db->where('expanses_category_id', $_POST['ecategory_id']);
				}
				$this->db->group_by(array('MONTH(date)'));
				$this->db->where('DATE(date)', $date);
				$this->db->select('SUM(amount) as total');
		return  $this->db->get('expanses')->row();
    }
	
	function get_this_year_expenses($y,$m)
	 {
	 			if(!empty($_POST['ecategory_id'])){
					$this->db->where('expanses_category_id', $_POST['ecategory_id']);
				}
	 			$this->db->where('MONTH(date)', $m);
				$this->db->where('YEAR(date)', $y);
				$this->db->select('SUM(amount) as total');
		return  $this->db->get('expanses')->row();
    }
}