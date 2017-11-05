<?php
class Housekeeping extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('housekeeping_model','room_model','housekeping_status_model','employee_model'));
	}
	
	function index()
	{	
		$data['page_title']		= lang('housekeeping');
		$data['housekeeping']	= $this->housekeeping_model->get_all();
		$this->render_admin('housekeeping/list', $data);		
	}
	function view($id)
	{	
		$data['page_title']		= lang('housekeeping');
		$data['housekeeping']	= $this->housekeeping_model->get($id);
		$this->render_admin('housekeeping/view', $data);		
	}
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('housekeeping_form');
		
		$data['rooms']					= $this->room_model->get_all();
		$data['housekeeping_status_all']	= $this->housekeping_status_model->get_all();
		$data['employees']	= $this->employee_model->get_all();
		//default values are empty if the housekeeping is new
		$data['id']						= '';
		$data['room_id']				= '';
		$data['housekeeping_status']	= '';
		$data['room_availblity']		= '';
		$data['remark']					= '';
		$data['assigned_to']			= '';
		
		if ($id)
		{	
			$data['housekeeping']			=	$housekeeping		= $this->housekeeping_model->get($id);
			//if the housekeeping does not exist, redirect them to the customer list with an error
			if (!$housekeeping)
			{
				$this->session->set_flashdata('error', lang('housekeeping_not_found'));
				redirect('admin/housekeeping');
			}
			
			//set values to db values
			$data['id']						= $housekeeping->id;
			$data['room_id']				= $housekeeping->room_id;
			$data['housekeeping_status']	= $housekeeping->housekeeping_status;
			$data['room_availblity']		= $housekeeping->room_availblity;
			$data['remark']					= $housekeeping->remark;
			$data['assigned_to']			= $housekeeping->assigned_to;
			
		}
		
		$this->form_validation->set_rules('room_id', 'lang:room_id', 'required');
		$this->form_validation->set_rules('housekeeping_status', 'lang:housekeping_status', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('housekeeping/form', $data);		
		}
		else
		{
			$save['id']						= $id;
			$save['room_id']				= $this->input->post('room_id');
			$save['housekeeping_status']	= $this->input->post('housekeeping_status');
			$save['room_availblity']		= $this->input->post('room_availblity');
			$save['remark']					= $this->input->post('remark');
			$save['assigned_to']			= $this->input->post('assigned_to');
			
			$this->housekeeping_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('housekeeping_update'));
			}else{
				$this->session->set_flashdata('message', lang('housekeeping_save'));
			}
			
			redirect('admin/housekeeping');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$housekeeping	= $this->housekeeping_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$housekeeping)
			{
				$this->session->set_flashdata('error', lang('housekeeping_not_found'));
				redirect('admin/rooms');
			}
			else
			{
				$delete	= $this->housekeeping_model->delete($id);
				$this->session->set_flashdata('message', lang('housekeeping_delete'));
					redirect('admin/rooms/housekeeping/'.$housekeeping->room_id);
			}
		}
		else
		{
				//if they do not provide an id send them to the customer list page with an error
				$this->session->set_flashdata('error', lang('housekeeping_not_found'));
				redirect('admin/rooms');
		}
	}
	
}