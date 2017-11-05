<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailer
{
    var $CI;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->helper('url');
    }
    
	
	function send($params)
	{
		$CI =& get_instance();
			// If using SMTP
			//echo '<pre>'; print_r($params);die;
			$settings	=	get_setting();
			//$settings = $this->setting_model->get_setting();
			//echo '<pre>'; print_r($settings);die;
					if(empty($settings->smtp_host) || empty($settings->smtp_user) || empty($settings->smtp_pass) || empty($settings->smtp_port)){
						$this->session->set_flashdata('error', "SMTP Settings Required");
						redirect('admin/settings');
					}
						/*
						$config = array(
    							'smtp_host' => $settings->smtp_host,
    							'smtp_port' => $settings->smtp_port,
    							'smtp_user' => $settings->smtp_user,
    							'smtp_pass' => $settings->smtp_pass,
								'smtp_crypto' => 'security',
    							'crlf' 		=> "\r\n",    							
    							'protocol'	=> 'smtp',
						);*/						
				// Send email 
				$config['useragent'] = $settings->name;
				$config['mailtype'] = "html";
				$config['newline'] = "\r\n";
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				
    			$CI->load->library('email',$config);
				$CI->email->from($settings->smtp_mail, $settings->name);
				$CI->email->to($params['recipient']);

				$CI->email->subject($params['subject']);
				$CI->email->message($params['message']);
				    if(isset($params['attached_file'])){ 
				    	$CI->email->attach($params['attached_file']);
				    }
				$CI->email->send();
		//echo $CI->email->print_debugger();;die;
    	
	
	}
}