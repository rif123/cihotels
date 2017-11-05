<?php
class Amenities extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('amenities_model'));
	}
	
	function index()
	{	
		$data['page_title']	= lang('amenities');
		$data['amenities']	= $this->amenities_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('amenities/list', $data);		
	}
	
	function view($id,$tab=false){
		
		$admin = $this->session->userdata('admin');
		$data['amenities']			=	$amenities		= $this->amenities_model->get($id);
		$data['page_title']	= lang('view')." ".lang('amenity') ;
		$this->render_admin('amenities/view', $data);
	}
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('amenity_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['name']				= '';
		$data['image']				= '';
		$data['active']				= '';
		$data['description']		= '';
		
		if ($id)
		{	
			$data['amenity']			=	$amenity		= $this->amenities_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$amenity)
			{
				$this->session->set_flashdata('error', lang('amenity_not_found'));
				redirect('admin/amenities');
			}
			
			//set values to db values
			$data['id']					= $amenity->id;
			$data['name']				= $amenity->name;
			$data['image']				= $amenity->image;
			$data['active']				= $amenity->active;
			$data['description']		= $amenity->description;
			
		}
		
		$this->form_validation->set_rules('name', 'lang:name', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('amenities/form', $data);		
		}
		else
		{
			if($_FILES['image'] ['name'] !='')
			{ 
				$config['upload_path'] = './assets/admin/uploads/amenities/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '10000';
				$config['max_width']  = '10000';
				$config['max_height']  = '6000';
		
				$this->load->library('upload', $config);
		
				if ( !$img = $this->upload->do_upload('image'))
					{

					}
					else
					{
						$file = BASEPATH.'../assets/admin/uploads/amenities/'.$data['image'];
						if (file_exists($file)) {
							unlink($file);
						}
						$img_data = array('upload_data' => $this->upload->data());
						$save['image'] = $img_data['upload_data']['file_name'];
					}
				
			}
			
			$save['id']				= $id;
			$save['name']			= $this->input->post('name');
			$save['active']			= $this->input->post('active');
			$save['description']		= $this->input->post('description');
			
			$this->amenities_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('amenity_update'));
			}else{
				$this->session->set_flashdata('message', lang('amenity_save'));
			}
			
			redirect('admin/amenities');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$amenities	= $this->amenities_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$amenities)
			{
				$this->session->set_flashdata('error', lang('amenity_not_found'));
				redirect('admin/amenities');
			}
			else
			{
				//if the customer is legit, delete them
				$file = BASEPATH.'../assets/admin/uploads/amenities/'.$amenities->image;
						if (file_exists($file)) {
							unlink($file);
						}
				$delete	= $this->amenities_model->delete($id);
				
				$this->session->set_flashdata('message', lang('amenity_delete'));
				redirect('admin/amenities');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('amenity_not_found'));
				redirect('admin/amenities');
		}
	}
	
	
}