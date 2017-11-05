<?php
Class Price_manager_model extends CI_Model
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
				 $this->db->select('P.*,R.title');	
				  $this->db->join('room_types R', 'R.id = P.room_type_id', 'LEFT');	
		$result = $this->db->get('price_manager P');
        return $result->result();
    }
	
	function get($id)
    {
		$this->db->where('id', $id);
		$result = $this->db->get('price_manager');
        return $result->row();
    }
	
	
    function save($save)
    {
        if ($save['id'])
        {
            $this->db->where('id', $save['id']);
            $this->db->update('price_manager', $save);
            return $save['id'];
        }
        else
        {
            $this->db->insert('price_manager', $save);
            return $this->db->insert_id();
        }
    }
	 function save_special_price($save){
		 	$this->db->insert('special_price', $save);
            return $this->db->insert_id();
	 }
	 function get_special_prices($id){
	 				$this->db->order_by('date_from','ASC');
					$this->db->where('room_type_id',$id);
		 	return $this->db->get('special_price')->result();
            
	 }
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('price_manager');
    }
	function delete_spl_price($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('special_price');
    }
	
    function get_room_type_price($id){
		$this->db->where('room_type_id', $id);
		$result = $this->db->get('price_manager');
        return $result->row();
	}
   
   	function check_daterange(){
		  if(!empty($_POST['id'])){
		  	$this->db->where('id !-', $_POST['id']);
		  }		
		  $this->db->where('date(date_to) >=', $_POST['start_date']);
		  $this->db->where('date(date_from) <=', $_POST['start_date']);
		$result = $this->db->get('special_price');
        return $result->row();
	}
}