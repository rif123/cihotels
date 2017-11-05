<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
		//$this->is_logged_in();
		//$this->load->model(array('menus_model','page_model','category_model','posts_model'));
		$this->load->model(array('menus_model','page_model','room_type_model'));
		$this->load->library('form_validation');
	}
	
	//Banner Group/ Group's banners
	function index($id=false)
	{
		$menu = ($id)?$this->menus_model->get($id):false;
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//validate form input
			$this->form_validation->set_rules('title', 'Menu Title', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$save = array('id'=>$id,
							  'title'=>$this->input->post('name'),
							  'slug'=>$this->input->post('description'),
							  'position'=>$this->input->post('position'),
							  'content'=>$this->input->post('content'));
				
				if(empty($id)){
				   $slug = $this->create_unique_slug('menus',$this->input->post('title'));
				   $save['slug'] = $slug;
				}
				
				if ($this->menus_model->save($save)){
					if($id)
						$this->session->set_flashdata('message', 'Menu Updated!');
					else
						$this->session->set_flashdata('message', 'Menu Created!');
				}
				redirect('admin/menus', 'refresh');
			}
		}
		
		$data['menus'] = $this->menus_model->get_all();
		
		if($id)
			$data['main'] = $menu;
		else
			$data['main'] = (isset($data['menus'][0]))?$data['menus'][0]:false;
		
		$data['highestmenu'] = 0;
		if(!empty($data['main']->content)){
			
			$mn_array = (array)json_decode($data['main']->content,true);
			foreach($mn_array as $mn)
			{
				if($mn['id']>$data['highestmenu'])
					$data['highestmenu'] = $mn['id'];
			}
		}
		
		$data['id'] = ($data['main'])?$data['main']->id:false;
		$data['pages'] = $this->page_model->get_pages();
		$data['room_types'] = $this->room_type_model->get_all();
		$data['categories'] = array();//$this->category_model->get_categories();
		$data['posts'] = array();//$this->posts_model->get_all(true);
			//echo '<pre>'; print_r($data['categories']);die;
		$data['page_title']	= lang('menus') ;
		$this->render_admin('menus/menus', $data);
	}
	
	
	//Banner Group Form
	function form($id=false)
	{
		if($id){
			$data = (array)$this->menus_model->get($id);
		}else{
			$data['id'] = $id;
			$data['title'] = '';
			$data['description'] = '';
			$data['status'] = '';
		}
		
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//validate form input
			$this->form_validation->set_rules('title', 'Menu Title', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$save = array('id'=>$id,
							  'title'=>$this->input->post('title'),
							  'slug'=>$this->input->post('description'),
							  'position'=>$this->input->post('position'),
							  'content'=>$this->input->post('content'));
				
				if(empty($id)){
				   $slug = $this->create_unique_slug('menus',$this->input->post('title'));
				   $save['slug'] = $slug;
				}
				
				if ($this->menus_model->save($save)){
					if($id)
						$this->session->set_flashdata('message', 'Menu Updated!');
					else
						$this->session->set_flashdata('message', 'Menu Created!');
				}
				redirect('admin/menus', 'refresh');
			}
		}
		
	   	//Define Page Title
		$data['page_title']	= lang('menu_form') ;
		$this->render_admin('menus/menus_form', $data);
	}
	
	function create_unique_slug($table,$title)
	{
		$slug = $this->create_slug($title);
		$k=1;
		for($i=1;$i<=$k;$i++){
			$flag_check = $this->check_slug_unique($table,$slug);
			if($flag_check){
			   $slug.='-'.$i;
			   $k++;
			}else	
				break;
		}
		
		return $slug;
	}
	
	
	function create_slug($string){
	   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	   return strtolower($slug);
	}
	
	function check_slug_unique($table,$slug)
	{
		$flag = false;
		$query = $this->db->get_where($table,array('slug'=>$slug));
		if($query->num_rows()>0)
			$flag = true;
			
		return $flag;	
	}
	
	
	function ajax_save()
	{
		$return = array();
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//echo '<pre>';print_r($_POST);exit;
			$id = $_POST['id'];
			$this->form_validation->set_rules('title', 'Menu Title', 'required');
			$this->form_validation->set_rules('position', 'Menu Postion', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$save = array('id'=>$id,
							  'title'=>$this->input->post('title'),
							  'position'=>$this->input->post('position'),
							  'content'=>json_encode($this->input->post('content')),);
				
				if(empty($id)){
				   $slug = $this->create_unique_slug('menus',$this->input->post('title'));
				   $save['slug'] = $slug;
				}
				
				if ($this->menus_model->save($save)){
					$return['status'] = 'success';
					if($id)
						$return['result'] = 'Menu Updated!';
					else
						$return['result'] = 'Menu Created!';
				}
			}else{
				$return['status'] = 'error';
				$return['result'] = validation_errors();
			}
		}
		
		echo json_encode($return);exit;
	}
	
	function delete_group($id=false)
	{
		if(!$id)
			redirect(admin_url('menus'));
		
		$this->menus_model->delete($id);
		$this->session->set_flashdata('message','Menu Deleted!');
		redirect(admin_url('admin/menus'));
	}



}


