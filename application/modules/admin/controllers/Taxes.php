<?php
class Taxes extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('tax_model'));
	}
	
	function index()
	{
		
		$data['page_title']	= lang('tax_manager');
		
		$data['taxes']	= $this->tax_model->get_all();
		$this->render_admin('taxes/list', $data);		
	}
	
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['tax']	= $this->tax_model->get_all();
		$data['page_title']		= lang('tax_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['name']				= '';
		$data['code']				= '';
		$data['type']				= '';
		$data['rate']				= '';
		if ($id)
		{	
			$data['tax']			=	$tax		= $this->tax_model->get($id);
			if (!$tax)
			{
				$this->session->set_flashdata('error', lang('tax_not_found'));
				redirect('admin/taxes');
			}
			
			//set values to db values
			$data['id']					= $tax->id;
			$data['name']				= $tax->name;
			$data['code']				= $tax->code;
			$data['type']				= $tax->type;
			$data['rate']				= $tax->rate;
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		$this->form_validation->set_rules('code', 'lang:code', 'trim|required');
		$this->form_validation->set_rules('type', 'lang:type', 'required');
		$this->form_validation->set_rules('rate', 'lang:tax_rate', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('taxes/form', $data);		
		}
		else
		{
			$save['id']					= $id;
			$save['name']				= $this->input->post('name');
			$save['code']				= $this->input->post('code');
			$save['type']				= $this->input->post('type');
			$save['rate']				= $this->input->post('rate');
			
			$p_key	=	$this->tax_model->save($save);
			
			if($id){
				$this->session->set_flashdata('message', lang('tax_update'));
			}else{
				$this->session->set_flashdata('message', lang('tax_save'));
			}
			
			redirect('admin/taxes');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$tax	= $this->tax_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$tax)
			{
				$this->session->set_flashdata('error', lang('tax_not_found'));
				redirect('admin/taxes');
			}
			else
			{
				//if the customer is legit, delete them
				$delete	= $this->tax_model->delete($id);
				
				$this->session->set_flashdata('message', lang('tax_delete'));
				redirect('admin/taxes');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('tax_not_found'));
				redirect('admin/taxes');
		}
	}
	
	
}