<?php
class Designation extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('designation_model'));
	}
	
	function index()
	{	
		$data['page_title']	= lang('designations');
		$data['designations']	= $this->designation_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('designations/list', $data);		
	}
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('designation_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['name']				= '';
		
		if ($id)
		{	
			$data['designation']			=	$designation		= $this->designation_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$designation)
			{
				$this->session->set_flashdata('error', lang('designation_not_found'));
				redirect('admin/designations');
			}
			
			//set values to db values
			$data['id']					= $designation->id;
			$data['name']				= $designation->name;
			
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('designations/form', $data);		
		}
		else
		{
			$save['id']				= $id;
			$save['name']			= $this->input->post('name');
		
			$this->designation_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('designation_update'));
			}else{
				$this->session->set_flashdata('message', lang('designation_save'));
			}
			
			redirect('admin/designation');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$designation	= $this->designation_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$designation)
			{
				$this->session->set_flashdata('error', lang('designation_not_found'));
				redirect('admin/designation');
			}
			else
			{
				$delete	= $this->designation_model->delete($id);
				
				$this->session->set_flashdata('message', lang('designation_delete'));
				redirect('admin/designation');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('designation_not_found'));
				redirect('admin/designation');
		}
	}
	
	
}