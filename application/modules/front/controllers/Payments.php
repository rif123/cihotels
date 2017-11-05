<?php
class Payments extends Front_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('homepage_model','book_model','account_model','location_model'));
	}
	
	function index(){
		$data['payments']	=	$this->account_model->get_payments_all();
		$data['page_title']	=	lang('payments');		
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
		$this->render('account/payments_all', $data);
	}
	
}