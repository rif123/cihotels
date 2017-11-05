<?php
class Settings extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('setting_model','language_model','currency_model','tax_model'));
		//echo '<pre>'; print_r($_SESSION);die;
	}
	
	
	
	function index()
	{
		$fonts			=	json_decode(file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCmvcRx-h8aQxpKJ8-y3otFEiQH_7ylz5U'));
		$data['fonts']	=	$fonts->items;
		//echo '<pre>'; print_r($data['fonts']);die;
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('settings');
		$data['languages']		= $this->language_model->get_all();
		$data['currency']		= $this->currency_model->get_all();
		$data['taxes']			= $this->tax_model->get_all();
		
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['name']				= '';
		$data['maintenance_mode']				= 0;
		
		$data['setting']			=	$setting		= $this->setting_model->get();
		
		if (!empty($setting))
		{	
			
			//set values to db values
			$data['id']								= $setting->id;
			$data['name']							= $setting->name;
			$data['maintenance_mode']				= $setting->maintenance_mode;
			$data['room_block_period']							= $setting->room_block_start_date.' / '.$setting->room_block_end_date;
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('settings/form', $data);		
		}
		else
		{
			$this->load->library('upload');	
				if(!empty($_FILES['logo']['name'])){
						$_FILES['userfile']['name']= time().rand(1,988).'.'.substr(strrchr($_FILES['logo']['name'],'.'),1);	
						$_FILES['userfile']['tmp_name']= $_FILES['logo']['tmp_name'];
						$_FILES['userfile']['type']= $_FILES['logo']['type'];
						$_FILES['userfile']['error']= $_FILES['logo']['error'];
						$_FILES['userfile']['size']= $_FILES['logo']['size'];
						
						$save['logo'] = $_FILES['userfile']['name'];
						
						$this->upload->initialize($this->set_upload_options());
						$flag = $this->upload->do_upload();
						$this->upload->data();
						
						if(file_exists(BASEPATH.'../assets/admin/uploads/images/'.$this->input->post('old_logo')) && $flag)
							unlink(BASEPATH.'../assets/admin/uploads/images/'.$this->input->post('old_logo'));
				}
			$room_block_period	=	explode('/',$_POST['room_block_period']);	
			$save['id']				= $this->input->post('id');
			$save['name']			= $this->input->post('name');
			$save['address']		= $this->input->post('address');
			$save['email']			= $this->input->post('email');
			$save['phone']			= $this->input->post('phone');
			$save['fax']			= $this->input->post('fax');
			$save['footer_text']	= $this->input->post('footer_text');
			$save['language']		= $this->input->post('language');
			$save['currency']		= $this->input->post('currency');
			$save['date_format']			= $this->input->post('date_format');
			$save['timezone']			= $this->input->post('timezone');
			$save['minimum_booking']			= $this->input->post('minimum_booking');
			$save['advance_payment']			= $this->input->post('advance_payment');
			$save['taxes']			= json_encode($this->input->post('taxes'));
			$save['check_in_time']			= $this->input->post('check_in_time');
			$save['check_out_time']			= $this->input->post('check_out_time');
			$save['time_format']			= $this->input->post('time_format');
			$save['maintenance_mode']			= $this->input->post('maintenance_mode');
			$save['maintenance_message']			= $this->input->post('maintenance_message');
			$save['smtp_mail']			= $this->input->post('smtp_mail');
			$save['smtp_host']			= $this->input->post('smtp_host');
			$save['smtp_user']			= $this->input->post('smtp_user');
			$save['smtp_pass']			= $this->input->post('smtp_pass');
			$save['smtp_port']			= $this->input->post('smtp_port');
			$save['invoice']			= $this->input->post('invoice');
			$save['room_block_start_date']			= date('Y-m-d', strtotime($room_block_period[0]));
			$save['room_block_end_date']			= date('Y-m-d', strtotime($room_block_period[1]));
			
			$save['paypal']					= $this->input->post('paypal');
			$save['stripe']					= $this->input->post('stripe');
			$save['pay_on_arrival']			= $this->input->post('pay_on_arrival');
			
			$save['paypal_sandbox']			= $this->input->post('paypal_sandbox');
			$save['paypal_business_email']	= $this->input->post('paypal_business_email');
			$save['stripe_key']				= $this->input->post('stripe_key');
			$save['stripe_api_key']			= $this->input->post('stripe_api_key');
			
			$save['facebook_link']					= $this->input->post('facebook_link');
			$save['twitter_link']					= $this->input->post('twitter_link');
			$save['google_plus_link']					= $this->input->post('google_plus_link');
			$save['linkedin_link']					= $this->input->post('linkedin_link');
			
			$save['cancellation_policy']					= $this->input->post('cancellation_policy');
			
			
			
			
			$save['content_section_title']			= $this->input->post('content_section_title');
			$save['content_section_description']			= $this->input->post('content_section_description');
			
		
			$save['meta_description']			= $this->input->post('meta_description');
			$save['meta_keywords']				= $this->input->post('meta_keywords');
			
			//echo '<pre>'; print_r($save);die;
			$this->setting_model->save($save);
			$this->session->set_flashdata('message', lang('setting_update'));
			redirect('admin/settings');
		}
	}
	
	function export(){
		 $this->load->dbutil();
		 $prefs = array(     
					'format'      => 'zip',             
					'filename'    => 'db_backup.sql'
		 );
	  	$backup =& $this->dbutil->backup($prefs); 
	  	$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
	  	$this->load->helper('download');
		force_download($db_name, $backup);
	}
	
	private function set_upload_options()
	{  //  upload an image and document options
		$config = array();
		$config['upload_path'] = BASEPATH.'../assets/admin/uploads/images/';
		$config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG';
		$config['max_size'] = '0'; // 0 = no file size limit
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['overwrite'] = TRUE;
		return $config;
	}
	
}