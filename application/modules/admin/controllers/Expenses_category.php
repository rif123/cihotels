<?php
class Expenses_category extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('expenses_category_model'));
	}
	
	function index()
	{
		
		$data['page_title']	= lang('expenses_category');
		
		$data['expenses_category']	= $this->expenses_category_model->get_all();
		$this->render_admin('expenses_category/list', $data);		
	}
	
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['expenses_category']			= $this->expenses_category_model->get_all();
		$data['page_title']		= lang('expenses_category_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['name']				= '';
		if ($id)
		{	
			$data['expenses_category']			=	$expenses_category		= $this->expenses_category_model->get($id);
			if (!$expenses_category)
			{
				$this->session->set_flashdata('error', lang('expenses_category_not_found'));
				redirect('admin/expenses_category');
			}
			
			//set values to db values
			$data['id']					= $expenses_category->id;
			$data['name']				= $expenses_category->name;
			
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('expenses_category/form', $data);		
		}
		else
		{
			$save['id']					= $id;
			$save['name']				= $this->input->post('name');
			
			$p_key	=	$this->expenses_category_model->save($save);
			
			if($id){
				$this->session->set_flashdata('message', lang('expenses_category_update'));
			}else{
				$this->session->set_flashdata('message', lang('expenses_category_save'));
			}
			
			redirect('admin/expenses_category');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$expenses_category	= $this->expenses_category_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$expenses_category)
			{
				$this->session->set_flashdata('error', lang('expenses_category_not_found'));
				redirect('admin/expenses_category');
			}
			else
			{
				//if the customer is legit, delete them
				$delete	= $this->expenses_category_model->delete($id);
				
				$this->session->set_flashdata('message', lang('expenses_category_delete'));
				redirect('admin/expenses_category');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('expenses_category_not_found'));
				redirect('admin/expenses_category');
		}
	}
	
	
}