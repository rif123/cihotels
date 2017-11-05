<?php
class Homepage extends Front_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('homepage_model','login_model','account_model'));
	}
	
	function index()
	{
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;
		$data['page_title']		= lang('home');
		$data['banners']		= $this->homepage_model->get_banners();
		$data['testimonials']	= $this->homepage_model->get_testimonials();	// get 6 testimonials
		$data['room_types']		= $this->homepage_model->get_room_types();
		$data['coupons']		= $this->homepage_model->get_coupons();		
		$this->render('homepage/homepage', $data);		
	}
	
		
	function login(){
		//echo '<pre>'; print_r($_POST);die;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
		
		if ($this->form_validation->run() == TRUE)
		{
			
			$email		=	$this->input->post('email');
			$password	=	$this->input->post('password');
			$return 	=	$this->login_model->auth($email,$password,'','');
			if($return){
				echo 1;die;
			}else{
				echo 'Email or Password invalid';
			}
			
		}else{
			echo validation_errors();
		}
	}	
	
	function signup(){
		$id	=	false;
		//echo '<pre>'; print_r($_POST);die;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|required');
		$this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|required');
		$this->form_validation->set_rules('email', 'lanng:email', 'trim|required|max_length[128]|is_unique[guests.email]');
		$this->form_validation->set_rules('mobile', 'lang:mobile', 'trim|required|max_length[32]');
				
		$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirm', 'lang:password_confirm', 'required|matches[password]');

		if ($this->form_validation->run() == TRUE)
		{
			$password	=	$this->input->post('password');
			$save['id']					= $id;
			$save['firstname']			= $this->input->post('firstname');
			$save['lastname']			= $this->input->post('lastname');
			$save['email']				= $this->input->post('email');
			$save['mobile']				= $this->input->post('mobile');
			$save['password']			= sha1($this->input->post('password'));
			$save['added']				= date('Y-m-d H:i:s');
			
			//echo '<pre>';print_r($save);die;
			$id	=	$this->account_model->save_guest($save);
			$row	=	$this->homepage_model->get_template(1);
			
			$row['subject'] = str_replace('{site_name}', $this->setting->name, $row['subject']);
			$row['content'] = str_replace('{site_name}', $this->setting->name, $row['content']);
			$row['content'] = str_replace('{customer_name}', $save['firstname'], $row['content']);
			
			$msg 				 = html_entity_decode($row['content'],ENT_QUOTES, 'UTF-8');
			$params['recipient'] = $save['email'];
			$params['subject'] 	 = $row['subject'];
			$params['message']   = $msg;
			$this->mailer->send($params);
			
			$this->session->set_flashdata('message', 'You Signup In Successfully');
			if($id){
				$return 	=	$this->login_model->auth($save['email'],$password,'','');
			}
			if($return){
				echo 1;die;
			}else{
				echo 'Something Went Wrong Try Again...!';
			}
			
		}else{
			echo validation_errors();
		}
	}	
	
	function logout(){
		$this->login_model->logout();
		$this->session->set_flashdata('message', "You Logout Successfully");
		redirect('front/homepage/');
	}
	
	function change_currency(){
		$currency		= $this->homepage_model->get_currency_by_currency_code($_POST['currency_code']);
		$this->session->set_userdata('currency',$_POST['currency_code']);
		$this->session->set_userdata('currency_sybmol',$currency->currrency_symbol);
		$this->session->set_flashdata('message', "Currency changed to ".$_POST['currency_code']);
		
		$from = $this->setting->currency_code;
		$sess_curruncy = $this->session->userdata('currency');	
		if(!empty($sess_curruncy)){
			$to = $this->session->userdata('currency');
		}else{
			$to = $from;
		}
		
			$from_Currency = urlencode($from);
			$to_Currency = urlencode($to);
				if($from_Currency==$to_Currency){
					$value	= 1;
				}else{
					$encode_amount = 1;
					$get = file_get_contents("https://www.google.com/finance/converter?a=$encode_amount&from=$from_Currency&to=$to_Currency");
					$get = explode("<span class=bld>",$get);
					$get = explode("</span>",$get[1]);
					
					$value = preg_replace("/[^0-9\.]/", null, $get[0]);
				}
			$this->session->set_userdata('currency_result',$value);
		
		echo 1;exit;
	}
	
	function switch_language($language = "") {
			//echo $_POST['id'];
			if($_POST['id']==0){
				$this->session->set_userdata(array('lang'       => 'english'));
			}
			$lang	=	$this->homepage_model->get_language_id($_POST['id']);
			if($lang){
				$this->session->set_userdata(array(
                            'lang'       => $lang->name
                    ));
			}
			$this->session->set_flashdata('message', lang('language_change'));
			echo 1;exit;
			//echo '<pre>'; print_r($this->session->all_userdata());die;
    }
	
	function get_password_link(){
		//echo '<pre>'; print_r($_POST);die;
		$email = $this->input->post('email');
		$token['token'] = time().sha1(uniqid(mt_rand(), true));	
		$reset = $this->homepage_model->edit_admin_to_save_code($email, $token);
		if ($reset)
		{						
			echo 1;exit;
		}
	}
	
	function reset_password($code){
		$this->load->helper('form');
		$user	=	$this->homepage_model->get_admin_by_code($code);
		$data['user']	=	$user;
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'Confirm Password', 'required|matches[password]');
			
			
			if ($this->form_validation->run()== TRUE)
			{
			
				$pass = array(
				'token'=>"expired",
				'password'=>sha1($this->input->post('password'))
				);
				
				$email = $this->input->post('email');
				$this->homepage_model->save_password($pass, $user->email);
				$this->session->set_flashdata('message', "Password Updated");
				redirect(site_url(''));
			}
		}
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;
		$data['page_title']		= lang('reset_password');
		$this->render('homepage/reset', $data);
	}
	
	function sendmail(){
		$message	=	'Good Morning..';	
		$msg 				 = html_entity_decode($message,ENT_QUOTES, 'UTF-8');
		$params['recipient'] = 'mukeshgodha1991@gmail.com';
		$params['subject'] 	 = "Hotel Test";
		$params['message']   = $msg;
		$this->mailer->send($params);
	
	}
	
	function page($id)
	{
		$data['page']			=	$page	=	 $this->homepage_model->get_page($id);
			//echo '<pre>'; print_r($data['page']);die;
		$data['meta_description']	=	$page->meta_description;
		$data['meta_keywords']		=	$page->meta_keywords;
		$data['page_title']			=  (empty($page->meta_title))?$page->title:$page->meta_title;
		
		//$data['testimonials']	= $this->testimonial_model->get_all();
		$this->render('homepage/page', $data);		
	}
		
	
}