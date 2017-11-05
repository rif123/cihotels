<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->auth->check_session();
		//$this->load->model("account_model");
	}
	

	
	function index($id = false)
	{	
		show_404();
		$data['langs'] = $this->language_model->get_all();
		$data['settings'] = $this->setting_model->get_setting();	
		//	echo '<pre>'; print_r($data['settings']);die;	
		$data['countries'] = $this->currency_model->get_all();
		$data['cities']   = $this->city_model->get_all();
		
		$data['groups'] = $this->patient_model->get_blood_group();
		
		$admin_se = $this->session->userdata('admin');
		if(!isset($admin_se['id']) || empty($admin_se['id'])){
			redirect('admin');
		}else{
			$id = $admin_se['id'];
		}
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		$data['page_title']		= lang('user_account');
		
		//default values are empty if the customer is new
		$data['id']		= '';
		$data['name']	= '';
		$data['email']		= '';
		$data['username']	= '';
		$data['image']		= '';
		
		
		if ($id)
		{	
			$this->admin_id		= $id;
			$data['admin']		=		$admin			= $this->auth->get_admin($id);
			//if the administrator does not exist, redirect them to the admin list with an error
			if (!$admin)
			{
				$this->session->set_flashdata('message', lang('admin_not_found'));
				redirect('admin/dashboard');
			}
			//set values to db values
			$data['id']			= $admin->id;
			$data['name']	= $admin->name;
			$data['email']		= $admin->email;
			$data['username']	= $admin->username;
			$data['access']		= $admin->user_role;
			$data['image']		= $admin->image;
			$data['timezone']		= $admin->timezone;
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|max_length[32]');
		$this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]');
		$this->form_validation->set_rules('username', 'lang:username', 'trim|required|max_length[128]|callback_check_username');
		
		
		//if this is a new account require a password, or if they have entered either a password or a password confirmation
		if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id)
		{
			$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]|sha1');
			$this->form_validation->set_rules('confirm', 'lang:confirm_password', 'required|matches[password]');
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			if($admin_se['user_role']==2){
				$data['body'] = 'account/patient_profile';
				$this->load->view('template/main', $data);
			}else{
				$data['body'] = 'account/admin_form';
				$this->load->view('template/main', $data);
			}
		}
		else
		{
			$save['id']		= $id;
			$save['name']	= $this->input->post('name');
			$save['email']		= $this->input->post('email');
			$save['username']	= $admin->username;
			$save['timezone'] = $this->input->post('timezone');
			if ($this->input->post('password') != '' || !$id)
			{
				$save['password']	= $this->input->post('password');
			}
			//echo '<pre>'; print_r($save);die;
            
            if($this->config->item('demo_site')){
                $this->session->set_flashdata('error',lang('demo_mode'));
            } else {
                $this->auth->save($save);
                $this->session->set_flashdata('message',lang('admin_saved'));
            }
            
			//go back to the customer list
			redirect(base_url('admin/dashboard'));
		}
	}

	
	
	function profile($id = false)
	{	
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		$admin = $this->session->userdata('admin');
		//echo '<pre>'; print_r($admin);die;
		//if the administrator does not exist, redirect them to the admin list with an error
		if (!$admin)
		{
			$this->session->set_flashdata('message', lang('admin_not_found'));
			redirect('admin/dashboard');
		}
			//set values to db values
		$data['id']			= $admin['id'];
		
		//default values are empty if the customer is new
		$data['id']		= '';
		$data['name']	= '';
		$data['email']		= '';
		$data['username']	= '';
		$data['image']		= '';
				
		
		if ($admin)
		{	
			//if the administrator does not exist, redirect them to the admin list with an error
			if (!$admin)
			{
				$this->session->set_flashdata('message', lang('admin_not_found'));
				redirect($this->config->item('admin_folder').'/admin');
			}
			$user	=	$this->auth->get_admin($admin['id']);
			//set values to db values
			$data['id']				= $user->id;
			$data['firstname']		= $user->firstname;
			$data['lastname']		= $user->lastname;
			$data['email']			= $user->email;
			$data['username']		= $user->username;
			//echo '<pre>'; print_r($_POST);die;
			
		$this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|max_length[32]');
		$this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|max_length[32]');
		//$this->form_validation->set_rules('email', 'lang:email', 'trim|required|valid_email|max_length[128]');
		$this->form_validation->set_rules('username', 'lang:username', 'trim|required');
		if($this->input->post('email') == $this->input->post('oldemail')) {
		  	$this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[128]|required');
		} else {
		  $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[128]|is_unique[users.email]');
		}
		//echo '<pre>'; print_r($_POST);die;
		//if this is a new account require a password, or if they have entered either a password or a password confirmation
		if ($this->input->post('password') != '' || $this->input->post('confirm') != '')
		{
			$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'lang:password_confirm', 'required|matches[password]');
		}
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['page_title']		= lang('my_profile');
			$this->render_admin('account/admin_form', $data);
		}
		else
		{
		
			$photo = array();
					
					if(!empty($_FILES['img'] ['name']))
					{ 
						
					
						$config['upload_path'] = './assets/uploads/images/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['max_size']	= '10000';
						$config['max_width']  = '10000';
						$config['max_height']  = '6000';
				
						$this->load->library('upload', $config);
				
						if ( !$img = $this->upload->do_upload('img')){
							
						}else{
								$img_data = array('upload_data' => $this->upload->data());
						}
						
						$save['image'] = $img_data['upload_data']['file_name'];
					}
		
		
		
			$save['id']				= $admin['id'];
			$save['firstname']			= $this->input->post('firstname');
			$save['lastname']			= $this->input->post('lastname');
			$save['username']		= $this->input->post('username');
			$save['email']			= $this->input->post('email');
			//echo '<pre>'; print_r($save);die;
			if ($this->input->post('password') != '')
			{
				$save['password']	= sha1($this->input->post('password'));
			}
			
			
            if($this->config->item('demo_site')){
                $this->session->set_flashdata('error',lang('demo_mode'));
            } else {
                $this->auth->save($save);
                $this->session->set_flashdata('message',lang('profile_updated'));
            }
            
            
			redirect('admin/account/profile');
		}
	}
	}

	
	function check_username($str)
	{
		$admin = $this->session->userdata('admin');
		$email = $this->auth->check_username($str, $admin['id']);
		if ($email)
		{
			$this->form_validation->set_message('check_username', lang('username_is_taken'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function check_username_user()
	{	
		$admin = $this->session->userdata('admin');
		$str	=	 $_POST['username'];
		$username = $this->auth->check_username($str, $admin['id']);
		if ($username)
		{
			echo 1;exit;
		}
		else
		{
			echo 0;exit;
		}
	}
	function get_age(){
		$from = new DateTime($_POST['date']);
		$to   = new DateTime('today');
		echo $from->diff($to)->y;
		
		# procedural
		//echo date_diff(date_create($_POST['date']), date_create('today'))->y;
	}
	
}