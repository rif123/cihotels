<?php
class Housekepping_status extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('housekeping_status_model'));
		
	}
	
	function index()
	{	
		$data['page_title']	= lang('housekeping_status');
		$data['housekeping_status']	= $this->housekeping_status_model->get_all();
		$this->render_admin('housekeping_status/list', $data);		
	}
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('housekeping_status_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['title']				= '';
		$data['short_description']	= '';
		$data['status']				= '';
		
		if ($id)
		{	
			$data['housekeping_status']			=	$housekeping_status		= $this->housekeping_status_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$housekeping_status)
			{
				$this->session->set_flashdata('error', lang('housekeping_status_not_found'));
				redirect('admin/housekeping_status');
			}
			
			//set values to db values
			$data['id']					= $housekeping_status->id;
			$data['title']				= $housekeping_status->title;
			$data['short_description']	= $housekeping_status->short_description;
			$data['status']				= $housekeping_status->status;
			
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('housekeping_status/form', $data);		
		}
		else
		{
			$save['id']					= $id;
			$save['title']				= $this->input->post('title');
			$save['short_description']	= $this->input->post('short_description');;
			$save['status']				= $this->input->post('status');;
		
			$this->housekeping_status_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('housekeping_status_update'));
			}else{
				$this->session->set_flashdata('message', lang('housekeping_status_save'));
			}
			
			redirect('admin/housekepping_status');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$housekeping_status	= $this->housekeping_status_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$housekeping_status)
			{
				$this->session->set_flashdata('error', lang('housekeping_status_not_found'));
				redirect('admin/housekeping_status');
			}
			else
			{
				$delete	= $this->housekeping_status_model->delete($id);
				
				$this->session->set_flashdata('message', lang('housekeping_status_delete'));
				redirect('admin/housekeping_status');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('housekeping_status_not_found'));
				redirect('admin/housekeping_status');
		}
	}
	
}