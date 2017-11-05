<?php
class Departments extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('department_model'));
	}
	
	function index()
	{	
		$data['page_title']	= lang('departments');
		$data['departments']	= $this->department_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('departments/list', $data);		
	}
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('department_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['name']				= '';
		
		if ($id)
		{	
			$data['department']			=	$department		= $this->department_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$department)
			{
				$this->session->set_flashdata('error', lang('department_not_found'));
				redirect('admin/departments');
			}
			
			//set values to db values
			$data['id']					= $department->id;
			$data['name']				= $department->name;
			
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('departments/form', $data);		
		}
		else
		{
			$save['id']				= $id;
			$save['name']			= $this->input->post('name');
		
			$this->department_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('department_update'));
			}else{
				$this->session->set_flashdata('message', lang('department_save'));
			}
			
			redirect('admin/departments');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$department	= $this->department_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$department)
			{
				$this->session->set_flashdata('error', lang('department_not_found'));
				redirect('admin/departments');
			}
			else
			{
				$delete	= $this->department_model->delete($id);
				
				$this->session->set_flashdata('message', lang('department_delete'));
				redirect('admin/departments');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('department_not_found'));
				redirect('admin/departments');
		}
	}
	
	
}