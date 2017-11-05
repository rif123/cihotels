<?php
Class Booking_model extends CI_Model
{

    var $CI;

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	function get_template($id){
		return $this->db->where('id', $id)->get('mail_templates')->row_array();
	}
	function save_payment($save){
		$this->db->insert('payment',$save);
	}
	function update_order($save,$id){
		$this->db->where('id',$id);
		$this->db->update('orders',$save);
	}
	function update_payment($save,$id){
		$this->db->where('id',$id);
		$this->db->update('payment',$save);
	}
	function get_order_total($id){
			   $this->db->where('order_id',$id);
			   $this->db->select('SUM(amount) as total');
		return $this->db->get('payment')->row();
	}
    function get_all()
    {
				 if(!empty($_POST['room_type_id'])){
				 	$this->db->where('O.room_type_id',$_POST['room_type_id']);
				 }
				 if(!empty($_POST['check_in'])){
				 	$this->db->where('O.check_in >=',$_POST['check_in']);
				 }
				 if(!empty($_POST['check_out'])){
				 	$this->db->where('O.check_out <=',$_POST['check_out']);
				 }	
				 if(isset($_POST['payment_status'])){
				 	if($_POST['payment_status']=='F'){
						$this->db->where('O.payment_status',0);
				 	}
					if($_POST['payment_status']=='S'){
						$this->db->where('O.payment_status',1);
				 	}
					if($_POST['payment_status']=='P'){
						$this->db->where('O.payment_status',2);
				 	}
					if($_POST['payment_status']=='PP'){	//partialy paid
						$this->db->where('O.payment_status',3);
				 	}
				 }
				 if(isset($_POST['status'])){
				 	if($_POST['status']=='SP'){
						$this->db->where('O.status',0);
				 	}
					if($_POST['status']=='SS'){
						$this->db->where('O.status',1);
				 	}
					if($_POST['status']=='SC'){
						$this->db->where('O.status',2);
				 	}
					
				 }
				 if(!empty($_POST['ordered_on'])){
				 	$this->db->where('date(O.ordered_on)',$_POST['ordered_on']);
				 }	
				  $this->db->order_by('O.ordered_on','DESC');	
				  $this->db->select('O.*,R.title room, G.firstname,G.lastname');
				  $this->db->join('room_types R', 'R.id = O.room_type_id', 'LEFT');	
				  $this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');	
		$result = $this->db->get('orders O');
        return $result->result();
    }
	
	function get($id)
    {
		  $this->db->where('O.id', $id);
		  $this->db->order_by('O.ordered_on','DESC');	
		  $this->db->select('O.*,R.title room, G.firstname,G.lastname,G.address as guest_address,G.mobile guest_phone,G.email guest_email,C.name guest_country,S.name guest_state,CT.name guest_city,CR.currrency_symbol cs');
		  $this->db->join('room_types R', 'R.id = O.room_type_id', 'LEFT');
		  $this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');	
		  $this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
		  $this->db->join('states S', 'S.id = G.state_id', 'LEFT');
		  $this->db->join('cities CT', 'CT.id = G.city_id', 'LEFT');
		  $this->db->join('currency CR', 'CR.currency_code = O.currency', 'LEFT');	
		$result = $this->db->get('orders O');

        return $result->row();
    }
	function getBuildingWhere($id)
    {
				$this->db->where('idBuilding', $id);
		return $this->db->get('building')->row();
		
	}
	function getCategoryData($id)
    {
				$this->db->where('idCategory', $id);
		return $this->db->get('category')->row();
		
	}
	function getGuestWhere($id)
    {
				$this->db->where('id', $id);
				$this->db->join('category c', 'c.idCategory = c.idCategory', 'LEFT');
		return $this->db->get('guests g')->row();
	}
	function get_payment($id)
    {
		  $this->db->where('P.order_id', $id);
		  $this->db->order_by('P.date_time','DESC');	
		$result = $this->db->get('payment P');

        return $result->result();
    }
	
	function get_taxes($id)
    {
		$this->db->where('OT.order_id',$id);
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
		$this->db->where('R.order_id',$id);
		$this->db->select('R.*,RM.room_no,F.name floor');
		$this->db->join('rooms RM', 'RM.id = R.room_id', 'LEFT');
		$this->db->join('floors F', 'F.id = RM.floor_id', 'LEFT');
		$result = $this->db->get('rel_orders_prices R');
        return $result->result();
    }
    
    function update_room($update,$order_id){
		$this->db->where('order_id',$order_id);
		$this->db->update('rel_orders_prices',$update);
	}
	
	function get_room_of_order($id)
    {
		$this->db->where('order_id',$id);
		$result = $this->db->get('rel_orders_prices');
        return $result->row();
    }
   
   function get_all_new()
    {
				 
				  $this->db->where('O.is_new',0);
				  $this->db->order_by('O.ordered_on','DESC');	
				  $this->db->select('O.*,R.title room, G.firstname,G.lastname');
				  $this->db->join('room_types R', 'R.id = O.room_type_id', 'LEFT');	
				  $this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');	
		$result = $this->db->get('orders O');
        return $result->result();
    }
	
	 function get_canceled_new()
    {
				 
				  $this->db->where('O.is_cancel_view',0);
				  $this->db->where('O.is_cancel_by_guest',1);
				  $this->db->order_by('O.ordered_on','DESC');	
				  $this->db->select('O.*,R.title room, G.firstname,G.lastname');
				  $this->db->join('room_types R', 'R.id = O.room_type_id', 'LEFT');	
				  $this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');	
		$result = $this->db->get('orders O');
        return $result->result();
    }
	
	function new_order_viewed(){
		$this->db->where('is_new',0);
		$this->db->set('is_new',1);
		$this->db->update('orders');
	}
	
	function new_canceled_viewed(){
		$this->db->where('is_cancel_view',0);
		$this->db->set('is_cancel_view',1);
		$this->db->update('orders');
	}
	function get_paid_services($id)
    {
			   $this->db->where('R.room_type_id', $id);	
			    $this->db->where('S.status',1);	
		       $this->db->join('rel_room_types_services R', 'S.id = R.service_id', 'LEFT');
		return $this->db->get('services S')->result();
    }
	function get_taxes_for_booking()
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
	
	function save_order($save)
    {
			   	
		       $this->db->insert('orders',$save);
		return $this->db->insert_id();
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
}