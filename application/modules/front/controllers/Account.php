<?php
class Account extends Front_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('homepage_model','book_model','account_model','location_model'));
	}
	
	function index()
	{
		//echo sha1('mukesh@2427atn*');die;
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
		$data['bookings']	=	$this->account_model->get_bookings();	
		$this->render('book/room_types', $data);		
		$this->render('book/view', $data);		
	}
	
	
	function bookings()
	{
		$data['bookings']	=	$this->account_model->get_bookings();
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
		$data['page_title']	=	lang('bookings');		
		$this->render('account/bookings', $data);		
	}
	
	function cancel($id){
		$data['bookings']	=	$this->account_model->get_order($id);
		if(empty($data['bookings'])){
			show_404();
		}
		if(!empty($_POST['cancel'])){	//cancel booking
			$save['status']				=	2;
			$save['is_cancel_by_guest']	=	1;
			$this->book_model->update_order($save,$id);
			$this->mail_cancel($id);
			$this->session->set_flashdata('message', 'Your Booking Is Canceled');
			redirect('front/account/bookings');
		}
		
		$data['page_title']	=	lang('cancel_booking');		
		$this->render('account/cancel_booking', $data);
	}
	
	function payments($id){
		$data['booking']	=	$this->account_model->get_order($id);
		$data['payments']	=	$this->account_model->get_payments($id);
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
		$data['page_title']	=	lang('payments');		
		$this->render('account/payments', $data);
	}
	
	function order($id){
		//echo '<pre>'; print_r($this->session->all_userdata());die;
		$data['order']	=	$this->account_model->get_order($id);
		if(!empty($data['order'])){
			$data['taxes']	=	$this->book_model->get_taxes($id);
			$data['services']	=	$this->book_model->get_services($id);
			$data['prices']	=	$this->book_model->get_prices($id);
			$data['page_title']	=	lang('order');
			$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
			//echo '<pre>'; print_r($data['taxes']);die;
			$this->render('account/order', $data);
		}else{
			$this->session->set_flashdata('error', "No Booking Finds..");
			redirect('front/account/bookings');
		}
	}
	
	function pdf($id){
		$this->load->helper('dompdf_helper');
		$this->load->helper('download');
		
		$data['order']	=	$this->account_model->get_order($id);
		if(!empty($data['order'])){
			$data['taxes']	=	$this->book_model->get_taxes($id);
			$data['services']	=	$this->book_model->get_services($id);
			$data['prices']	=	$this->book_model->get_prices($id);
			//echo '<pre>'; print_r($data['taxes']);die;
			$html = $this->load->view('book/pdf', $data,true);		
			pdf_create($html, 'Order_'.$data['order']->order_no);
		}
	}
	
	function profile()
	{
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
		$data['countries']	= $this->location_model->get_countries();	
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('profile');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['firstname']			= '';
		$data['lastname']			= '';
		$data['gender']				= '';
		$data['password']			= '';
		$data['dob']				= '';
		$data['email']				= '';
		$data['country_id']			= '';
		$data['state_id']			= '';
		$data['city_id']			= '';
		$data['address']			= '';
		$data['mobile']				= '';
		$data['id_type']			= '';
		$data['id_no']				= '';
		$data['id_upload']			= '';
		$data['remark']				= '';
		$data['vip']				= '';
		
		$id	=	$this->front_user['id'];
		
		if ($id)
		{	
			$data['user']			=	$guest		= $this->account_model->get_user($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$guest)
			{
				$this->session->set_flashdata('error', 'Something went wrong');
				redirect('');
			}
			
			$data['id']					= $guest->id;
			$data['firstname']			= $guest->firstname;
			$data['lastname']			= $guest->lastname;
			$data['gender']				= $guest->gender;
			$data['dob']				= $guest->dob;
			$data['email']				= $guest->email;
			//$data['password']			= $guest->password;
			$data['country_id']			= $guest->country_id;
			$data['state_id']			= $guest->state_id;
			$data['city_id']			= $guest->city_id;
			$data['address']			= $guest->address;
			$data['mobile']				= $guest->mobile;
			$data['id_type']			= $guest->id_type;
			$data['id_no']				= $guest->id_no;
			$data['id_upload']			= $guest->id_upload;
			$data['remark']				= $guest->remark;
			$data['vip']				= $guest->vip;
		}
		
		$this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|required');
		$this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|required');
		
		if($this->input->post('email') == $this->input->post('old_email')) {
		  	$this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[128]|required');
		} else {
		  $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[128]|is_unique[guests.email]');
		}
		
		$this->form_validation->set_rules('mobile', 'lang:mobile', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('gender', 'lang:gender', 'required');
				
		//if this is a new account require a password, or if they have entered either a password or a password confirmation
		if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id)
		{
			$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'lang:password_confirm', 'required|matches[password]');
		}
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render('account/profile', $data);
		}
		else
		{
			$this->load->library('upload');	
				if(!empty($_FILES['id_upload']['name'])){
						$_FILES['userfile']['name']= time().rand(1,988).'.'.substr(strrchr($_FILES['id_upload']['name'],'.'),1);	
						$_FILES['userfile']['tmp_name']= $_FILES['id_upload']['tmp_name'];
						$_FILES['userfile']['type']= $_FILES['id_upload']['type'];
						$_FILES['userfile']['error']= $_FILES['id_upload']['error'];
						$_FILES['userfile']['size']= $_FILES['id_upload']['size'];
						
						$save['id_upload'] = $_FILES['userfile']['name'];
						
						$this->upload->initialize($this->set_upload_options());
						$flag = $this->upload->do_upload();
						$this->upload->data();
						
						if(file_exists(BASEPATH.'../assets/admin/uploads/ids/'.$this->input->post('old_id')) && $flag)
							unlink(BASEPATH.'../assets/admin/uploads/ids/'.$this->input->post('old_id'));
				}

			
			$save['id']					= $id;
			$save['firstname']			= $this->input->post('firstname');
			$save['lastname']			= $this->input->post('lastname');
			$save['gender']				= $this->input->post('gender');
			$save['dob']				= $this->input->post('dob');
			$save['email']				= $this->input->post('email');
			$save['country_id']			= $this->input->post('country_id');
			$save['state_id']			= $this->input->post('region_id');
			$save['city_id']			= $this->input->post('city_id');
			$save['address']			= $this->input->post('address');
			$save['mobile']				= $this->input->post('mobile');
			$save['id_type']			= $this->input->post('id_type');
			$save['id_no']				= $this->input->post('id_no');
			//$save['id_upload']			= $this->input->post('id_upload');
			$save['remark']				= $this->input->post('remark');
			
			if ($this->input->post('password') != '' || !$id)
			{
				$save['password']	= sha1($this->input->post('password'));
			}
			
			//echo '<pre>';print_r($save);die;
			$this->account_model->save_guest($save);
			$this->session->set_flashdata('message', 'Your Profile Updated');
			redirect('front/account/profile');
		}
	}
	
	function logout(){
		$this->session->unset_userdata('front_user');
		$this->session->set_flashdata('message', "Your Logout Success");
		redirect();
	}
	
	function get_states()
	{
		$states		=	$this->location_model->get_zones($_POST['country_id']);
		echo '<option value="">--'.lang('select_region').'--</option>';
		foreach($states as $new){
			echo '<option value="'.$new->id.'">'.$new->name.'</option>';
		}
	}
	
	function get_cities()
	{
		$cities		=	$this->location_model->get_zone_areas($_POST['state_id']);
		echo '<option value="">--'.lang('select_city').'--</option>';
		foreach($cities as $new){
			echo '<option value="'.$new->id.'">'.$new->name.'</option>';
		}
	}
	
	
	
	private function set_upload_options()
	{  //  upload an image and document options
		$config = array();
		$config['upload_path'] = BASEPATH.'../assets/admin/uploads/ids/';
		$config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf';
		$config['max_size'] = '0'; // 0 = no file size limit
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['overwrite'] = TRUE;
		return $config;
	}
	
	function mail_cancel($order_id){
		$data['order']	=	$order	=	$this->book_model->get_order($order_id);
		$data['taxes']	=	$this->book_model->get_taxes($order_id);
		$data['services']	=	$this->book_model->get_services($order_id);
		$data['prices']	=	$this->book_model->get_prices($order_id);
		$html = $this->load->view('book/mail', $data,true);
		
		$row	=	$this->homepage_model->get_template(5);
		$row['subject'] = str_replace('{site_name}', $this->setting->name, $row['subject']);
		$row['content'] = str_replace('{customer_name}', $order->firstname, $row['content']);
		$row['content'] = str_replace('{site_name}', $this->setting->name, $row['content']);
		$row['content'] = str_replace('{order_summary}', $html, $row['content']);
		
		$msg 				 = html_entity_decode($row['content'],ENT_QUOTES, 'UTF-8');
		$params['recipient'] = $order->email;
		$params['subject'] 	 = $row['subject'];
		$params['message']   = $msg;
		$this->mailer->send($params);
			return true;
	}	
}