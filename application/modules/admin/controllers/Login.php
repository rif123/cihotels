<?php
class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{	
		
		//we check if they are logged in, generally this would be done in the constructor, but we want to allow customers to log out still
		//or still be able to either retrieve their password or anything else this controller may be extended to do
		$redirect	= $this->auth->is_logged_in(false, false);
		//if they are logged in, we send them back to the dashboard by default, if they are not logging in
		if ($redirect)
		{
			redirect('admin/dashboard');
		}
		
		$data['setting']	=	get_setting();
		$this->load->helper('form');
		$data['redirect']	= $this->session->flashdata('redirect');
		$submitted 			= $this->input->post('submitted');
		if ($submitted)
		{
			$username	= $this->input->post('username');
			$password	= $this->input->post('password');
			$remember   = $this->input->post('remember');
			$redirect	= $this->input->post('redirect');
			$login		= $this->auth->login_admin($username, $password, $remember);
			if ($login)
			{	
				
				if ($redirect == '')
				{
					$this->session->set_flashdata('message', 'SCRIPT SHARED ON  - C O D E L I S T . C C');
					$redirect = 'admin/dashboard';
				}
				redirect($redirect);
			}
			else
			{
				//this adds the redirect back to flash data if they provide an incorrect credentials
				$this->session->set_flashdata('redirect', $redirect);
				$this->session->set_flashdata('error', 'Authentication Failed');
				redirect('admin/login');
			}
		}
		$this->load->view('login/login', $data);		
	}
	
	function logout()
	{
		$this->auth->logout();
		
		//when someone logs out, automatically redirect them to the login page.
		$this->session->set_flashdata('message', "logged Out successfully");
		redirect('admin/login');
	}

}
