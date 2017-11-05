<?php
class Expenses extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('expenses_model','expenses_category_model'));
	}
	
	function index()
	{
		
		$data['page_title']	= lang('expenses');
		
		$data['expanses']	= $this->expenses_model->get_all();
		$this->render_admin('expanses/list', $data);		
	}
	
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['expenses_category']	= $this->expenses_category_model->get_all();
		$data['page_title']				= lang('expenses_form');
		//default values are empty if the customer is new
		$data['id']							= '';
		$data['date']						= '';
		$data['title']						= '';
		$data['expanses_category_id']		= '';
		$data['amount']						= '';
		$data['attachment']					= '';
		$data['remarks']					= '';
		if ($id)
		{	
			$data['expanses']			=	$expanses		= $this->expenses_model->get($id);
			if (!$expanses)
			{
				$this->session->set_flashdata('error', lang('expanses_not_found'));
				redirect('admin/expanses');
			}
			
			//set values to db values
			$data['id']							= $expanses->id;
			$data['date']						= $expanses->date;
			$data['title']						= $expanses->title;
			$data['expanses_category_id']		= $expanses->expanses_category_id;
			$data['amount']						= $expanses->amount;
			$data['attachment']					= $expanses->attachment;
			$data['remarks']					= $expanses->remarks;
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		$this->form_validation->set_rules('expanses_category_id', 'lang:expenses_category', 'trim|required');
		$this->form_validation->set_rules('date', 'lang:date', 'trim|required');
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('expanses/form', $data);		
		}
		else
		{
			$this->load->library('upload');	
				if(!empty($_FILES['attachment']['name'])){
						$_FILES['userfile']['name']= time().rand(1,988).'.'.substr(strrchr($_FILES['attachment']['name'],'.'),1);	
						$_FILES['userfile']['tmp_name']= $_FILES['attachment']['tmp_name'];
						$_FILES['userfile']['type']= $_FILES['attachment']['type'];
						$_FILES['userfile']['error']= $_FILES['attachment']['error'];
						$_FILES['userfile']['size']= $_FILES['attachment']['size'];
						
						$save['attachment'] = $_FILES['userfile']['name'];
						
						$this->upload->initialize($this->set_upload_options());
						$flag = $this->upload->do_upload();
						$this->upload->data();
						
						if(file_exists(BASEPATH.'../assets/admin/uploads/images/'.$_FILES['attachment']['name']) && $flag)
							unlink(BASEPATH.'../assets/admin/uploads/images/'.$this->input->post('old_attachment'));
				}
				
			$save['id']					= $id;
			$save['date']					= $this->input->post('date');
			$save['title']						= $this->input->post('title');
			$save['expanses_category_id']		= $this->input->post('expanses_category_id');
			$save['amount']						= $this->input->post('amount');
			$save['remarks']					= $this->input->post('remarks');
			
			$p_key	=	$this->expenses_model->save($save);
			
			if($id){
				$this->session->set_flashdata('message', lang('expenses_update'));
			}else{
				$this->session->set_flashdata('message', lang('expenses_save'));
			}
			
			redirect('admin/expenses');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$expanses	= $this->expenses_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$expanses)
			{
				$this->session->set_flashdata('error', lang('expanses_not_found'));
				redirect('admin/expenses');
			}
			else
			{
				$file = BASEPATH.'../assets/admin/uploads/images/'.$expanses->attachment;
						if (file_exists($file)) {
							unlink($file);
						}
				//if the customer is legit, delete them
				$delete	= $this->expenses_model->delete($id);
				
				$this->session->set_flashdata('message', lang('expenses_delete'));
				redirect('admin/expenses');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('expanses_not_found'));
				redirect('admin/expenses');
		}
	}
	
	private function set_upload_options()
	{  //  upload an image and document options
		$config = array();
		$config['upload_path'] = BASEPATH.'../assets/admin/uploads/images/';
		$config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf';
		$config['max_size'] = '0'; // 0 = no file size limit
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['overwrite'] = TRUE;
		return $config;
	}
}