<?php
class Pages extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Page_model');
	}
		
	function index()
	{
		$data['page_title']	= lang('pages');
		$data['pages']		= $this->Page_model->get_pages();
		//echo '<pre>'; print_r($data['pages']);die;
		$this->render_admin('pages/pages', $data);	
	}
	
	/********************************************************************
	edit page
	********************************************************************/
	function form($id = false)
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		//set the default values
		$data['id']					= '';
		$data['title']				= '';
		$data['slug']				= '';
		$data['short_description']	= '';
		$data['description']		='';
		$data['meta_title']			= '';
		$data['meta_description']	= '';
		$data['meta_keywords']		= '';
		
		$data['page_title']	= lang('page_form');
		$data['pages']		= $this->Page_model->get_pages();
		
		if($id)
		{
			
			$page			= $this->Page_model->get_page($id);

			if(!$page)
			{
				//page does not exist
				$this->session->set_flashdata('error', lang('error_page_not_found'));
				redirect('admin/pages');
			}
			
			
			//set values to db values
			$data['id']					= $page->id;
			$data['title']				= $page->title;
			$data['slug']				= $page->slug;
			$data['short_description']	= $page->short_description;
			$data['description']		= $page->description;
			$data['meta_title']			= $page->meta_title;
			$data['meta_description']	= $page->meta_description;
			$data['meta_keywords']		= $page->meta_keywords;
			
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		$this->form_validation->set_rules('slug', 'lang:slug', 'trim');
		$this->form_validation->set_rules('meta_title', 'lang:seo_title', 'trim');
		$this->form_validation->set_rules('meta_description', 'lang:meta_description', 'trim');
		$this->form_validation->set_rules('description', 'lang:description', 'trim');
		
		// Validate the form
		if($this->form_validation->run() == false)
		{
			$this->render_admin('pages/page_form', $data);
		}
		else
		{
			$this->load->helper('text');
			
			//first check the slug field
			$slug = $this->input->post('slug');
			
			//if it's empty assign the name field
			if(empty($slug) || $slug=='')
			{
				$slug = $this->input->post('title');
			}
			
			$slug	= url_title(convert_accented_characters($slug), 'dash', TRUE);
			
			//validate the slug
			if($id)
			{
				$slug		= $this->Page_model->validate_slug($slug, $page->id);
				$route_id	= $page->route_id;
			}
			else
			{
				$slug			= $this->Page_model->validate_slug($slug);
			}
			
			
			$save = array();
			$save['id']					= $id;
			$save['title']				= $this->input->post('title');
			$save['slug']				= $this->input->post('slug');
			$save['short_description']	= $this->input->post('short_description');
			$save['description']		= $this->input->post('description');
			$save['meta_title']			= $this->input->post('meta_title');
			$save['meta_description']	= $this->input->post('meta_description');
			$save['meta_keywords']		= $this->input->post('meta_keywords');
			$save['slug']				= $slug;
			
			
			//save the page
			$page_id	= $this->Page_model->save($save);
			
			$this->session->set_flashdata('message', lang('message_saved_page'));
			
			//go back to the page list
			redirect('admin/pages');
		}
	}
	
	
	/********************************************************************
	delete page
	********************************************************************/
	function delete($id)
	{
		
		$page	= $this->Page_model->get_page($id);
		if($page)
		{
			
			$this->Page_model->delete_page($id);
			$this->session->set_flashdata('message', lang('message_deleted_page'));
		}
		else
		{
			$this->session->set_flashdata('error', lang('error_page_not_found'));
		}
		
		redirect('admin/pages');
	}
}	