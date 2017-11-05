<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Front_Controller extends MX_Controller
{
	
    function __construct()
    {
        parent::__construct();
		$this->load->helper('language');
		if($this->session->userdata('lang')!="")
		{
			$this->lang->load('admin',$this->session->userdata('lang'));
		}else{
			$this->lang->load('admin', 'english');
		}
		$this->setting	=	get_setting();
		$this->front_user	=	get_front_user();
		//echo '<pre>'; print_r($this->setting);die;
		$CI =& get_instance();
		$cur_symbol =  $CI->session->userdata('currency_sybmol');
		if(empty($cur_symbol)){
					$currency_symbol	=	$this->setting->currency_symbol;
						$this->session->set_userdata(array(
                            'currency_sybmol'       => $currency_symbol));
		}	
		
			
		//echo '<pre>'; print_r($this->setting);die;
	    //if SSL is enabled in config force it here.
        if (config_item('ssl_support') && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off'))
		{
			$CI =& get_instance();
			$CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
			redirect($CI->uri->uri_string());
		}

    }
	

	public function render($page=false,$data=false)
	{
		
		$this->load->view('front/template/header',$data);
		
		//$this->load->view('front/template/sidebar',$data);
		$this->load->view($page,$data);
		$this->load->view('front/template/footer',$data);
	}
    
}



?>