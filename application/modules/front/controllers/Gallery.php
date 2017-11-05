<?php
class Gallery extends Front_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('gallery_model','homepage_model'));
	}
	
	function index()
	{
		
		$data['page_title']		= lang('gallery');
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
		$data['gallery']		= $this->gallery_model->get_gallery();
		$data['images']			= $this->gallery_model->get_images();
			//echo '<pre>'; print_r($data['coupons']);die;
		$this->render('gallery/gallery', $data);		
	}
	
	
}