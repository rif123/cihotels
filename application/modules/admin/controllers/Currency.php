<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('currency_model'));
		$this->load->library('form_validation');
	}
	
	function index()
	{
		$data['page_title'] = lang('currency');
		$data['currency'] = $this->currency_model->get_all();
		$this->render_admin('currency/currency', $data);
	}
	
	function form($id=false)
	{	
		if($id){
			$data = (array)$this->currency_model->get_currency_by_id($id);
			//echo '<pre>'; print_r($data);die;
		}else{
			$data['id'] = '';
			$data['name'] = '';
			$data['iso_alpha2'] = '';
			$data['iso_alpha3'] = '';
			$data['iso_numeric'] = '';
			$data['currency_code'] = '';
			$data['currency_name'] = '';
			$data['currrency_symbol'] = '';
			$data['flag'] = '';
			$data['status'] = '';
		}
		
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//validate form input
			$this->form_validation->set_rules('name', 'lang:name', 'required');
			$this->form_validation->set_rules('currency_code', 'lang:currency_code', '');
			
			if ($this->form_validation->run() == true)
			{	
				$photo = array();
					if($_FILES['flag'] ['name'] !='')
					{ 
						
					
						$config['upload_path'] = './assets/uploads/flags/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']	= '10000';
						$config['max_width']  = '10000';
						$config['max_height']  = '6000';
						$config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG';
						$config['width'] = '30';     
						$config['height'] = '20'; 
						$this->load->library('upload', $config);
				
						if ( !$img = $this->upload->do_upload('flag'))
							{
								$error = array('error' => $this->upload->display_errors());
								echo '<pre>'; print_r($error);exit;
							}
							else
							{
								$img_data = array('upload_data' => $this->upload->data());
								$save['flag'] = $img_data['upload_data']['file_name'];
								
							}
						
					}
				
							$save['id']				=	$id;
							$save['name']			=	$this->input->post('name');
							$save['iso_alpha2']		=	$this->input->post('iso_alpha2');
							$save['iso_alpha3']		=	$this->input->post('iso_alpha3');
							$save['iso_numeric']	=	$this->input->post('iso_numeric');
							$save['currency_code']	=	$this->input->post('currency_code');
							$save['currency_name']	=	$this->input->post('currency_name');
							$save['currrency_symbol']=	$this->input->post('currrency_symbol');
							$save['status']			=	$this->input->post('status');
							$save['iso_alpha3'] 	=	$this->input->post('status');
				//echo '<pre>'; print_r($save);die;
				
				if ($this->currency_model->save($save)){
					if($id)
						$this->session->set_flashdata('message',lang('currency_updated'));
					else
						$this->session->set_flashdata('message',lang('currency_created'));
				}
				redirect('admin/currency', 'refresh');
			}
		}
		
	   	//Define Page Title
		$data['page_title'] = lang('currency') ." ".lang('form');;
		$this->render_admin('currency/currency_form', $data);
		
	}
	
	function delete($id=false)
	{
		if(!$id)
			redirect('admin/currency');
		
		$data = $this->currency_model->delete($id);
		$this->session->set_flashdata('message',lang('currency_deleted'));
		redirect('admin/currency');
	}
	

}

