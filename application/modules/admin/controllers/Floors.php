<?php

class Floors extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('floor_model'));
	}
	
	function index()
	{
		$admin = $this->session->userdata('admin');
		
		$data['page_title']	= lang('floors');
		$data['floors']	= $this->floor_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('floors/list', $data);		
	}
	
	function view($id,$tab=false){
		
		$admin = $this->session->userdata('admin');
		$data['floor']			=	$floor		= $this->floor_model->get($id);
		$data['page_title']	= lang('view')." ".lang('floor') ;
		$this->render_admin('floors/view', $data);
	}
	function form($id = false)
	{
		$admin = $this->session->userdata('admin');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('floor_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['name']				= '';
		$data['floor_no']			= '';
		$data['active']				= '';
		$data['description']		= '';
		
		if ($id)
		{	
			$data['floor']			=	$floor		= $this->floor_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$floor)
			{
				$this->session->set_flashdata('error', lang('floor_not_found'));
				redirect('admin/groups');
			}
			
			//set values to db values
			$data['id']					= $floor->id;
			$data['name']				= $floor->name;
			$data['floor_no']			= $floor->floor_no;
			$data['active']				= $floor->active;
			$data['description']		= $floor->description;
			
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('floors/form', $data);		
		}
		else
		{
			$save['id']				= $id;
			$save['name']			= $this->input->post('name');
			$save['floor_no']			= $this->input->post('floor_no');
			$save['active']			= $this->input->post('active');
			$save['description']		= $this->input->post('description');
			
			$this->floor_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('floor_update'));
			}else{
				$this->session->set_flashdata('message', lang('floor_save'));
			}
			
			redirect('admin/floors');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$floor	= $this->floor_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$floor)
			{
				$this->session->set_flashdata('error', lang('floor_not_found'));
				redirect('admin/floors');
			}
			else
			{
				//if the customer is legit, delete them
				$delete	= $this->floor_model->delete($id);
				
				$this->session->set_flashdata('message', lang('floor_delete'));
				redirect('admin/floors');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('floor_not_found'));
				redirect('admin/floors');
		}
	}
	
	
}