<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Forgot extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model("forgot_model");
		$this->load->helper('form');
	}

	function index()
	{
	$data['setting']	=	get_setting();
	$this->load->helper('url');
	$this->load->library('email');
	$data['page_title']	=  'Forgot Password';
	$token['token'] = time().sha1(uniqid(mt_rand(), true));
	$submitted = $this->input->post('submitted');
		if ($submitted)
		{
			
			$email = $this->input->post('email');
			
			$reset = $this->forgot_model->edit_admin_to_save_code($email, $token);
			
			if ($reset)
			{						
				$this->session->set_flashdata('message', 'Reset Password Link Send To Email');
				redirect('admin/login');
			}
			else
			{
				$this->session->set_flashdata('error','Email Not Found');
				redirect('admin/forgot');
			}
				
		}	
		
	$this->load->view('forgot/forgot_password',$data);
	}	
	
	
	
	
	function reset_password()
	{
	$code = $this->uri->segment(4);
	$user	=	$this->forgot_model->get_admin_by_code($code);
	$data['page_title']	=  "Change Password";
	$data['setting']	=	get_setting();
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
				$this->forgot_model->save_password($pass, $user->email);
				$this->session->set_flashdata('message', "Password Updated");
				redirect(site_url('admin/login'));
			}
		}	
	$this->load->view('forgot/reset_password', $data);
	}
	
	
	
	
	
}