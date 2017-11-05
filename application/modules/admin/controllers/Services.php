<?php
class Services extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('service_model','room_type_model'));
	}
	
	function index()
	{
		
		$data['page_title']	= lang('services');
		
		$data['services']	= $this->service_model->get_all();
		//$data['states']	= $this->room_model->get_states();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('services/list', $data);		
	}
	
	function view($id,$tab=false){
		
		$data['room_type']			=	$room_type		= $this->service_model->get($id);
		$data['page_title']	= lang('view')." ".lang('room_type') ;
		$this->render_admin('room_types/view', $data);
	}
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['room_types']	= $this->room_type_model->get_all();
		$data['page_title']		= lang('service_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['title']				= '';
		$data['description']		= '';
		$data['short_description']	= '';
		$data['price_type']			= '';
		$data['price']				= '';
		$data['status']				= '';
		$data['romm_services']		=	array();
		
		if ($id)
		{	
			$data['service']			=	$service		= $this->service_model->get($id);
			$rs							=	$this->service_model->get_room_types_services($id);
				foreach($rs as $r){
				$data['romm_services'][]	=	$r->room_type_id;
				}
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$service)
			{
				$this->session->set_flashdata('error', lang('service_not_found'));
				redirect('admin/services');
			}
			
			//set values to db values
			$data['id']					= $service->id;
			$data['title']				= $service->title;
			$data['description']		= $service->description;
			$data['short_description']	= $service->short_description;
			$data['price_type']			= $service->price_type;
			$data['price']				= $service->price;
			$data['status']				= $service->status;
			
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		$this->form_validation->set_rules('price_type', 'lang:price_type', 'trim|required');
		$this->form_validation->set_rules('price', 'lang:price', 'trim|required');
		$this->form_validation->set_rules('status', 'lang:status', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('services/form', $data);		
		}
		else
		{
			$save['id']					= $id;
			$save['title']				= $this->input->post('title');
			$save['description']		= $this->input->post('description');
			$save['short_description']	= $this->input->post('short_description');
			$save['price_type']			= $this->input->post('price_type');
			$save['price']				= $this->input->post('price');
			$save['status']				= $this->input->post('status');
			
			$p_key	=	$this->service_model->save($save);
				$room_types	=	$_POST['room_types'];
				$this->service_model->delete_room_types_services($p_key);
				if(!empty($room_types)){
					$i=0;
					foreach($room_types as $rt){
						$save_rt[$i]['service_id']	=	$p_key;
						$save_rt[$i]['room_type_id']	=	$rt;
						$i++;
					}
					$this->service_model->save_service_room_type($save_rt);
				}
			
			if($id){
				$this->session->set_flashdata('message', lang('service_update'));
			}else{
				$this->session->set_flashdata('message', lang('service_save'));
			}
			
			redirect('admin/services');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$service	= $this->service_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$service)
			{
				$this->session->set_flashdata('error', lang('service_not_found'));
				redirect('admin/services');
			}
			else
			{
				//if the customer is legit, delete them
				$delete	= $this->service_model->delete($id);
				
				$this->session->set_flashdata('message', lang('service_delete'));
				redirect('admin/services');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('service_not_found'));
				redirect('admin/services');
		}
	}
	
	
}