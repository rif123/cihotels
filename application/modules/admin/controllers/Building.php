<?php

class Building extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('Building_model'));
	}
	
	function index()
	{
        $admin = $this->session->userdata('admin');
		$data['page_title']	= lang('building');
		$data['floors']	= $this->Building_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('Building/list', $data);		
	}
	function form($id = false)
	{
		$admin = $this->session->userdata('admin');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('building');
		//default values are empty if the customer is new
		$data['idBuilding']					= '';
		$data['nameBuilding']					= '';
		
		if ($id)
		{	
           
			$data['floor']			=	$floor		= $this->Building_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$floor)
			{
				$this->session->set_flashdata('error', lang('Building_not_found'));
				redirect('admin/groups');
			}
			
			//set values to db values
			$data['idBuilding']			= $floor->idBuilding;
            $data['nameBuilding']		=  $floor->nameBuilding;
           
        }
		$this->form_validation->set_rules('nameBuilding', 'nameBuilding', 'required');		    
        if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('Building/form', $data);		
		}
		else
		{
			$save['idBuilding']	    = $id;
            $save['nameBuilding']	=  $this->input->post('nameBuilding');
			$this->Building_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('building_update'));
			}else{
				$this->session->set_flashdata('message', lang('building_save'));
			}
			
			redirect('admin/building');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$floor	= $this->Building_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$floor)
			{
				$this->session->set_flashdata('error', lang('Building_not_found'));
				redirect('admin/floors');
			}
			else
			{
				//if the customer is legit, delete them
				$delete	= $this->Building_model->delete($id);
				$this->session->set_flashdata('message', lang('building_delete'));
				redirect('admin/building');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('Building_not_found'));
				redirect('admin/floors');
		}
	}
	
	
}