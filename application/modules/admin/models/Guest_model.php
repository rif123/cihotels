<?php
Class Guest_model extends CI_Model
{

    var $CI;
	var $table = 'guests';
    var $column_order = array(null, 'firstname','lastname','email'); //set column field database for datatable orderable
    var $column_search = array('firstname','lastname','email','country'); //set column field database for datatable searchable 
    var $order = array('id' => 'asc'); // default order 

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();
        $this->CI->load->database(); 
        $this->CI->load->helper('url');
		
		
    }
	
    function get_all()
    {
		$this->db->select('G.*,C.name country');
		$this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
		$result = $this->db->get('guests G');
        return $result->result();
    }
	
	
	
	function get_vip(){
				$this->db->where('vip',1);
		return $this->db->get('guests')->result();
	}
    
	function get($id)
    {
		$this->db->where('G.id', $id);
		$this->db->select('G.*,C.name country,S.name state,CT.name city');
		$this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
		$this->db->join('cities CT', 'CT.id = G.city_id', 'LEFT');
		$this->db->join('states S', 'S.id = G.state_id', 'LEFT');
		$result = $this->db->get('guests G');
        return $result->row();
    }
	
	
   
    
    function save($save)
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
	 
    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('guests');
    }
	
	
	 private function _get_datatables_query()
    {
        /*$this->db->get($this->table);
		//$this->db->select('guests.*,countries.name as country');
		$this->db->join('countries', 'countries.id = guests.country_id', 'LEFT');
		$i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }*/
		
    }

    function get_datatables()
    {
        //$this->_get_datatables_query();
        //echo '<pre>'; print_r($_POST);die;
		if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
		
		if($_POST['length'] != -1){
        	$this->db->limit($_POST['length'], $_POST['start']);
        }
		if(!empty($_POST['search']['value'])) // if datatable send POST for search
            {
                    $this->db->like('G.firstname', $_POST['search']['value']);
					$this->db->or_like('G.lastname', $_POST['search']['value']);
					$this->db->or_like('C.name', $_POST['search']['value']);
					$this->db->or_like('G.mobile', $_POST['search']['value']);
            }
		$this->db->select('G.*,C.name country');
		$this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
		return $query = $this->db->get('guests G')->result();
	    
    }

    function count_filtered()
    {
        return count($this->get_datatables());
      
    }

    public function count_all()
    {
        $this->db->from('guests');
        return $this->db->count_all_results();
    }
    
 	function get_bookings($id)
    {
		  $this->db->where('O.guest_id', $id);
		  $this->db->order_by('O.ordered_on','DESC');	
		  $this->db->select('O.*,R.title room, G.firstname,G.lastname,G.address as guest_address,G.mobile guest_phone,G.email guest_email,C.name guest_country,S.name guest_state,CT.name guest_city,CR.currrency_symbol cs');
		  $this->db->join('room_types R', 'R.id = O.room_type_id', 'LEFT');
		  $this->db->join('guests G', 'G.id = O.guest_id', 'LEFT');	
		  $this->db->join('countries C', 'C.id = G.country_id', 'LEFT');
		  $this->db->join('states S', 'S.id = G.state_id', 'LEFT');
		  $this->db->join('cities CT', 'CT.id = G.city_id', 'LEFT');
		  $this->db->join('currency CR', 'CR.currency_code = O.currency', 'LEFT');	
		$result = $this->db->get('orders O');

        return $result->result();
    }
	
	function get_payments($id)
    {
		$this->db->group_by('P.id');
		$this->db->where('O.guest_id',$id);
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