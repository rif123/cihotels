<?php
class Testimonials extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('testimonial_model'));
	}
	
	function index()
	{
		
		$data['page_title']	= lang('testimonials');
		
		$data['testimonials']	= $this->testimonial_model->get_all();
		$this->render_admin('testimonials/list', $data);		
	}
	
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['testimonial']			= $this->testimonial_model->get_all();
		$data['page_title']				= lang('testimonial');
		//default values are empty if the customer is new
		$data['id']							= '';
		$data['title']							= '';
		$data['auther_name']				= '';
		$data['testimonial']				= '';
		$data['auther_image']				= '';
		$data['rating']						= '';
		$data['country']						= '';
		if ($id)
		{	
			$data['testimonial']			=	$testimonial		= $this->testimonial_model->get($id);
			if (!$testimonial)
			{
				$this->session->set_flashdata('error', lang('testimonial_not_found'));
				redirect('admin/testimonials');
			}
			
			//set values to db values
			$data['id']						= $testimonial->id;
			$data['title']					= $testimonial->title;
			$data['auther_name']				= $testimonial->auther_name;
			$data['testimonial']				= $testimonial->testimonial;
			$data['auther_image']				= $testimonial->auther_image;
			$data['rating']						= $testimonial->rating;
			$data['country']					= $testimonial->country;
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		$this->form_validation->set_rules('auther_name', 'lang:auther_name', 'trim|required');
		$this->form_validation->set_rules('testimonial', 'lang:testimonial', 'trim|required');
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('testimonials/form', $data);		
		}
		else
		{
			$this->load->library('upload');	
				if(!empty($_FILES['auther_image']['name'])){
						$_FILES['userfile']['name']= time().rand(1,988).'.'.substr(strrchr($_FILES['auther_image']['name'],'.'),1);	
						$_FILES['userfile']['tmp_name']= $_FILES['auther_image']['tmp_name'];
						$_FILES['userfile']['type']= $_FILES['auther_image']['type'];
						$_FILES['userfile']['error']= $_FILES['auther_image']['error'];
						$_FILES['userfile']['size']= $_FILES['auther_image']['size'];
						
						$save['auther_image'] = $_FILES['userfile']['name'];
						
						$this->upload->initialize($this->set_upload_options());
						$flag = $this->upload->do_upload();
						$this->upload->data();
						
						if(file_exists(BASEPATH.'../assets/admin/uploads/images/'.$this->input->post('auther_image')) && $flag)
							unlink(BASEPATH.'../assets/admin/uploads/images/'.$this->input->post('old_auther_image'));
				}
				
			$save['id']					= $id;
			$save['auther_name']				= $this->input->post('auther_name');
			$save['title']				= $this->input->post('title');
			$save['testimonial']				= $this->input->post('testimonial');
			$save['rating']						= $this->input->post('rating');
			$save['country']					= $this->input->post('country');
			
			
			$p_key	=	$this->testimonial_model->save($save);
			
			if($id){
				$this->session->set_flashdata('message', lang('testimonial_update'));
			}else{
				$this->session->set_flashdata('message', lang('testimonial_save'));
			}
			
			redirect('admin/testimonials');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$testimonial	= $this->testimonial_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$testimonial)
			{
				$this->session->set_flashdata('error', lang('testimonial_not_found'));
				redirect('admin/testimonials');
			}
			else
			{
				$file = BASEPATH.'../assets/admin/uploads/images/'.$testimonial->auther_image;
						if (file_exists($file)) {
							unlink($file);
						}
				//if the customer is legit, delete them
				$delete	= $this->testimonial_model->delete($id);
				
				$this->session->set_flashdata('message', lang('testimonial_delete'));
				redirect('admin/testimonials');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('testimonial_not_found'));
				redirect('admin/testimonials');
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