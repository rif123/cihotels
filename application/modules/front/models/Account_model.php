<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Account_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

	function get_bookings()
    {
		$front_user	=	$this->session->userdata('front_user');
		$this->db->order_by('O.id','DESC');
		$this->db->where('O.guest_id',$front_user['id']);
		$this->db->select('O.*,G.firstname,G.lastname,G.mobile,RT.title room_type,C.currrency_symbol cs');
		$this->db->join('room_types RT', 'RT.id = O.room_type_id', 'LEFT');
		$this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');
		$this->db->join('currency C', 'C.currency_code = O.currency', 'LEFT');
		$result = $this->db->get('orders O');
        return $result->result();
    }
	function get_order($id)
    {
		$front_user	=	$this->session->userdata('front_user');
		$this->db->order_by('O.id','DESC');
		$this->db->where('O.id',$id);
		$this->db->where('O.guest_id',$front_user['id']);
		$this->db->select('O.*,G.firstname,G.lastname,G.mobile,RT.title room_type,C.currrency_symbol cs');
		$this->db->join('room_types RT', 'RT.id = O.room_type_id', 'LEFT');
		$this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');
		$this->db->join('currency C', 'C.currency_code = O.currency', 'LEFT');
		$result = $this->db->get('orders O');
        return $result->row();
    }
	function get_user($id)
    {
		$this->db->where('G.id', $id);
		$this->db->select('G.*,C.name country,S.name state,CT.name city');
		$this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
		$this->db->join('cities CT', 'CT.id = G.city_id', 'LEFT');
		$this->db->join('states S', 'S.id = G.state_id', 'LEFT');
		$result = $this->db->get('guests G');
        return $result->row();
    }
	
	function save_guest($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('guests', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('guests', $save);
            return $this->db->insert_id();
        }
    }
	
	function get_payments($id)
    {
		$front_user	=	$this->session->userdata('front_user');
		$this->db->group_by('P.id');
		$this->db->order_by('P.invoice','DESC');
		$this->db->where('O.guest_id',$front_user['id']);
		$this->db->where('O.id',$id);
		$this->db->select('P.*,G.firstname,G.lastname,G.address as guest_address,G.mobile guest_phone,G.email guest_email,C.name guest_country,S.name guest_state,CT.name guest_city,CR.currrency_symbol cs');
		$this->db->join('orders O', 'O.id = P.order_id', 'LEFT');
		$this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');	
		$this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
	 	$this->db->join('states S', 'S.id = G.state_id', 'LEFT');
	    $this->db->join('cities CT', 'CT.id = G.city_id', 'LEFT');
	    $this->db->join('currency CR', 'CR.currency_code = O.currency', 'LEFT');
		$result = $this->db->get('payment P');
        return $result->result();
    }   
	
	function get_payments_all(){
		$front_user	=	$this->session->userdata('front_user');
		$this->db->group_by('P.id');
		$this->db->order_by('P.invoice','DESC');
		$this->db->where('O.guest_id',$front_user['id']);
		$this->db->select('P.*,G.firstname,G.lastname,G.address as guest_address,G.mobile guest_phone,G.email guest_email,C.name guest_country,S.name guest_state,CT.name guest_city,CR.currrency_symbol cs');
		$this->db->join('orders O', 'O.id = P.order_id', 'LEFT');
		$this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');	
		$this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
	 	$this->db->join('states S', 'S.id = G.state_id', 'LEFT');
	    $this->db->join('cities CT', 'CT.id = G.city_id', 'LEFT');
	    $this->db->join('currency CR', 'CR.currency_code = O.currency', 'LEFT');
		$result = $this->db->get('payment P');
        return $result->result();
	
	}
}
