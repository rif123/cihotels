<?php
Class Homepage_model extends CI_Model
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
    function get_banners()
    {
			  $this->db->where('enable_date <=', date('Y-m-d'));	
			   $this->db->where('disable_date >=', date('Y-m-d'));
		return $this->db->get('banners')->result();
    }
	
	function get_images($id)
    {
		$this->db->where('room_type_id', $id);
		$this->db->order_by('is_featured', 'DESC');
		$result = $this->db->get('room_types_images');
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
   
   function get_page($id){
					$this->db->where('id',$id);
			return 	$this->db->get('pages')->row();	
   }
   
   function get_languages(){
   	
		return 	$this->db->get('language')->result();
   }
   function get_language_id($id)
	{
				$this->db->where('id',$id);
		return $this->db->get('language')->row();
	}
	
	 private function get_admin_by_email($email)
    {
        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $result = $this->db->get('guests');
        $result = $result->row_array();

        if (sizeof($result) > 0)
        {
            return $result; 
        }
        else
        {
            return false;
        }
    }
	function edit_admin_to_save_code($email,$token) //save randon string in admin by email
	 {
	 			
	 $admin_email = $this->get_admin_by_email($email);
		
		if ($admin_email['email'])
        {	
			$res = $this->db->where('id', '4')->get('mail_templates');
			$row = $res->row_array();
		
			//print_r($row);die;
			$result = $this->db->where('id', '1')->get('settings');
			$settings = $result->row();
			//echo '<pre>'; print_r($settings->name);die;
			$link = site_url('front/homepage/reset_password/' . $token['token']);
			
			
			//working code
			$row['content'] = str_replace('{password_reset_link}', $link, $row['content']);
			$row['subject'] = str_replace('{site_name}', $settings->name, $row['subject']);
			
			
			// {site_name}
			$row['subject'] = str_replace('{site_name}', $settings->name, $row['subject']);
			$row['content'] = str_replace('{site_name}', $settings->name, $row['content']);
			$row['content'] = str_replace('{customer_name}', $admin_email['firstname'], $row['content']);
				
				$this->db->where('email',$admin_email['email']);
				$this->db->update('guests', $token);
				
				$msg 				 = html_entity_decode($row['content'],ENT_QUOTES, 'UTF-8');
				$params['recipient'] = $admin_email['email'];
				$params['subject'] 	 = $row['subject'];
				$params['message']   = $msg;
				$this->mailer->send($params);
				return TRUE;
		}else{
            return false;
        }		
	 }
	 function save_password($save,$email)
	{
		$this->db->where('email',$email);
		$this->db->update('guests', $save);
		
	}
	 function get_admin_by_code($code)
	{
		$this->db->where("token", $code);
		$this->db->select("email");
		 $this->db->limit(1);
		$result = $this->db->get('guests')->row(); 
		
		 if (sizeof($result) > 0)
        {
            return $result; 
        }
        else
        {
			$this->session->set_flashdata('error', "Reset Password Failed");
			redirect('');
         
        }
	}
}