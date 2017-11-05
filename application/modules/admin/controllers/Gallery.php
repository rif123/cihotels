<?php
class Gallery extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('gallery_model'));
	}
	
	function index()
	{	
		$data['page_title']	= lang('gallery');
		$data['gallery']			= $this->gallery_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('gallery/list', $data);		
	}
	
	
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('gallery_form');
		//default values are empty if the customer is new
		$data['id']						= '';
		$data['title']					= '';
		$data['images']					= array();
		
		if ($id)
		{	
			$data['gallery']			=	$gallery		= $this->gallery_model->get($id);
			$data['images']			=	$images		= $this->gallery_model->get_images($id);
			
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$gallery)
			{
				$this->session->set_flashdata('error', lang('gallery_not_found'));
				redirect('admin/gallery');
			}
			
			//set values to db values
			$data['id']					= $gallery->id;
			$data['title']				= $gallery->title;
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('gallery/form', $data);		
		}
		else
		{
			$save['id']				= $id;
			$save['title']			= $this->input->post('title');
			
			$p_key	=	$this->gallery_model->save($save);
			
			$images	=	array();
			
			$upload_data	=	 array();
			$files = $_FILES;
			$save_img	=	array();
			if(!empty($files)){				
			$cpt = count($_FILES['image']['name']);
					for($i=0; $i<$cpt; $i++)
					{   
						if(!empty($files['image']['name'][$i])){
							$_FILES['userfile']['name']= 	$file_name	=	time().rand(1,988).'.'.substr(strrchr($files['image']['name'][$i],'.'),1);
							$_FILES['userfile']['type']= $files['image']['type'][$i];
							$_FILES['userfile']['tmp_name']= $files['image']['tmp_name'][$i];
							$_FILES['userfile']['error']= $files['image']['error'][$i];
							$_FILES['userfile']['size']= $files['image']['size'][$i];
							
							//$file_name	= time().rand(1,988).'.jpg';
							$save_img['gallery_id']	=	$p_key;
							$save_img['caption']	=	$_POST['caption'][$i];
							$save_img['image']		=	$file_name;
							$this->gallery_model->save_images($save_img);
							
							
							$config['upload_path'] = 'assets/admin/uploads/gallery/full';
							$config['allowed_types'] = 'jpg|png|jpeg';
							$config['max_size']	= '10000';
							$config['max_width']  = '10000';
							$config['max_height']  = '6000';
							//$config['file_name'] = $file_name;
							$this->load->library('upload',$config);
							 
					
							if ($this->upload->do_upload())
							{
								$upload_data	= $this->upload->data();
							}
							if($this->upload->display_errors() != '')
							{
								$data['error'] = $this->upload->display_errors();
								echo '<pre>'; print_r($data['error']);die;
							}	
							
							$this->load->library('image_lib');
									//this is the medium image
									$config['image_library'] = 'gd2';
									$config['source_image'] = 'assets/admin/uploads/gallery/full/'.$upload_data['file_name'];
									$config['new_image']	= 'assets/admin/uploads/gallery/medium/'.$upload_data['file_name'];
									$config['maintain_ratio'] = FALSE;
									$config['width'] = 600;
									$config['height'] = 500;
									$this->image_lib->initialize($config);
									$this->image_lib->resize();
									$this->image_lib->clear();
						
									//small image
									$config['image_library'] = 'gd2';
									$config['source_image'] = 'assets/admin/uploads/gallery/medium/'.$upload_data['file_name'];
									$config['new_image']	= 'assets/admin/uploads/gallery/small/'.$upload_data['file_name'];
									$config['maintain_ratio'] = FALSE;
									$config['width'] = 235;
									$config['height'] = 235;
									$this->image_lib->initialize($config); 
									$this->image_lib->resize();
									$this->image_lib->clear();
						
									//cropped thumbnail
									$config['image_library'] = 'gd2';
									$config['source_image'] = 'assets/admin/uploads/gallery/small/'.$upload_data['file_name'];
									$config['new_image']	= 'assets/admin/uploads/gallery/thumbnails/'.$upload_data['file_name'];
									$config['maintain_ratio'] = FALSE;
									$config['width'] = 268;
									$config['height'] = 249;
									$this->image_lib->initialize($config); 	
									$this->image_lib->resize();	
									$this->image_lib->clear();
							}		
					}
						
			}//End Files Is Not Empt
			
			
			if($id){
				$this->session->set_flashdata('message', lang('gallery_update'));
			}else{
				$this->session->set_flashdata('message', lang('gallery_save'));
			}
			
			redirect('admin/gallery');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$gallery	= $this->gallery_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$gallery)
			{
				$this->session->set_flashdata('error', lang('gallery_not_found'));
				redirect('admin/gallery');
			}
			else
			{
				$images	= $this->gallery_model->get_images($id);
					
					foreach($images as $img){
						$this->gallery_model->delete_image($img->id);
						
						$full 	= BASEPATH.'../assets/admin/uploads/gallery/full/'.$img->image;
						$medium 	= BASEPATH.'../assets/admin/uploads/gallery/medium/'.$img->image;
						$small 		= BASEPATH.'../assets/admin/uploads/gallery/small/'.$img->image;
						$thumbnails = BASEPATH.'../assets/admin/uploads/gallery/thumbnails/'.$img->image;
							
							if (file_exists($full)) {
								unlink($full);
							}
							if (file_exists($medium)) {
								unlink($medium);
							}
							if (file_exists($small)) {
								unlink($small);
							}
							if (file_exists($thumbnails)) {
								unlink($thumbnails);
							}
					}
				
				$delete	= $this->gallery_model->delete($id);
				
				$this->session->set_flashdata('message', lang('gallery_delete'));
				redirect('admin/gallery');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('gallery_not_found'));
				redirect('admin/gallery');
		}
	}
	
	function updateimg(){
		//echo '<pre>'; print_r($_POST);
		$id			=	$_POST['id'];	
		$gallery	=	$this->gallery_model->get_image($id);
		//echo '<pre>-->'; print_r($gallery);die;
		$full 	= BASEPATH.'../assets/admin/uploads/gallery/full/'.$gallery->image;
		$medium 	= BASEPATH.'../assets/admin/uploads/gallery/medium/'.$gallery->image;
		$small 		= BASEPATH.'../assets/admin/uploads/gallery/small/'.$gallery->image;
		$thumbnails = BASEPATH.'../assets/admin/uploads/gallery/thumbnails/'.$gallery->image;
			if (file_exists($full)) {
				unlink($full);
			}
			if (file_exists($medium)) {
				unlink($medium);
			}
			if (file_exists($small)) {
				unlink($small);
			}
			if (file_exists($thumbnails)) {
				unlink($thumbnails);
			}
		//echo '<pre>'; print_r($save);die;
		$this->gallery_model->delete_image($id);
	}	
	
	
	function edit_image($id){
		$gallery	=	$this->gallery_model->get_image($id);
		$full 	= BASEPATH.'../assets/admin/uploads/gallery/full/'.$gallery->image;
		$medium 	= BASEPATH.'../assets/admin/uploads/gallery/medium/'.$gallery->image;
		$small 		= BASEPATH.'../assets/admin/uploads/gallery/small/'.$gallery->image;
		$thumbnails = BASEPATH.'../assets/admin/uploads/gallery/thumbnails/'.$gallery->image;
			if (file_exists($full)) {
				unlink($full);
			}
			if (file_exists($medium)) {
				unlink($medium);
			}
			if (file_exists($small)) {
				unlink($small);
			}
			if (file_exists($thumbnails)) {
				unlink($thumbnails);
			}
			
		$files = $_FILES;
			$save_img	=	array();
			if(!empty($files)){				
			$cpt = count($_FILES['image']['name']);
					for($i=0; $i<$cpt; $i++)
					{   
						if(!empty($files['image']['name'][$i])){
							$_FILES['userfile']['name']= 	$file_name	=	time().rand(1,988).'.'.substr(strrchr($files['image']['name'][$i],'.'),1);
							$_FILES['userfile']['type']= $files['image']['type'][$i];
							$_FILES['userfile']['tmp_name']= $files['image']['tmp_name'][$i];
							$_FILES['userfile']['error']= $files['image']['error'][$i];
							$_FILES['userfile']['size']= $files['image']['size'][$i];
							
							//$file_name	= time().rand(1,988).'.jpg';
							$save_img['image']		=	$file_name;
							$this->gallery_model->update_images($save_img,$id);
							
							
							$config['upload_path'] = 'assets/admin/uploads/gallery/full';
							$config['allowed_types'] = 'jpg|png|jpeg';
							$config['max_size']	= '10000';
							$config['max_width']  = '10000';
							$config['max_height']  = '6000';
							//$config['file_name'] = $file_name;
							$this->load->library('upload',$config);
							 
					
							if ($this->upload->do_upload())
							{
								$upload_data	= $this->upload->data();
							}
							if($this->upload->display_errors() != '')
							{
								$data['error'] = $this->upload->display_errors();
								//echo '<pre>'; print_r($data['error']);die;
							}	
							
							$this->load->library('image_lib');
									//this is the medium image
									$config['image_library'] = 'gd2';
									$config['source_image'] = 'assets/admin/uploads/gallery/full/'.$upload_data['file_name'];
									$config['new_image']	= 'assets/admin/uploads/gallery/medium/'.$upload_data['file_name'];
									$config['maintain_ratio'] = FALSE;
									$config['width'] = 600;
									$config['height'] = 500;
									$this->image_lib->initialize($config);
									$this->image_lib->resize();
									$this->image_lib->clear();
						
									//small image
									$config['image_library'] = 'gd2';
									$config['source_image'] = 'assets/admin/uploads/gallery/medium/'.$upload_data['file_name'];
									$config['new_image']	= 'assets/admin/uploads/gallery/small/'.$upload_data['file_name'];
									$config['maintain_ratio'] = FALSE;
									$config['width'] = 235;
									$config['height'] = 235;
									$this->image_lib->initialize($config); 
									$this->image_lib->resize();
									$this->image_lib->clear();
						
									//cropped thumbnail
									$config['image_library'] = 'gd2';
									$config['source_image'] = 'assets/admin/uploads/gallery/small/'.$upload_data['file_name'];
									$config['new_image']	= 'assets/admin/uploads/gallery/thumbnails/'.$upload_data['file_name'];
									$config['maintain_ratio'] = FALSE;
									$config['width'] = 268;
									$config['height'] = 249;
									$this->image_lib->initialize($config); 	
									$this->image_lib->resize();	
									$this->image_lib->clear();
							$this->session->set_flashdata('message', lang('image_updated'));
							}		
					}
						
			}//End Files Is Not Empt
			
	}
	
	function edit_caption(){
			$id							=	$_POST['id'];
			$caption					=	$_POST['val'];
			$save_img['caption']		=	$caption;
			$this->gallery_model->update_images($save_img,$id);
	}
	
	function view($id){
		$data['page_title']		= lang('gallery');
		$data['gallery']			=	$gallery		= $this->gallery_model->get($id);
			$data['images']			=	$images		= $this->gallery_model->get_images($id);
		$this->render_admin('gallery/view',$data);
	}
}