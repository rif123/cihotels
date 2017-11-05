<?php
class Room_types extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('room_type_model','amenities_model'));
	}
	
	function index()
	{
		$admin = $this->session->userdata('admin');
		
		$data['page_title']	= lang('room_types');
		$data['room_types']	= $this->room_type_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('room_types/list', $data);		
	}
	
	function view($id,$tab=false){
		
		$data['room_type']			=	$room_type		= $this->room_type_model->get($id);
		$data['page_title']	= lang('view')." ".lang('room_type') ;
		$this->render_admin('room_types/view', $data);
	}
	function form($id = false)
	{
		//echo '<pre>'; print_r($_POST);die;
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['amenities']	= $this->amenities_model->get_all();
		$data['page_title']		= lang('room_type_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['title']				= '';
		$data['slug']				= '';
		$data['shortcode']			= '';
		$data['description']		= '';
		$data['base_occupancy']		= '';
		$data['higher_occupancy']	= '';
		$data['extra_bed']			= '';
		$data['extra_beds']			= '';
		$data['kids_occupancy']		= '';
		$data['base_price']			= '';
		$data['additional_person']	= '';
		$data['extra_bed_price']	= '';
		$data['room_amenities']	= array();
		$data['images']	= array();
		if ($id)
		{	
			$data['room_type']			=	$room_type		= $this->room_type_model->get($id);
			$amenities		= $this->room_type_model->get_amenities($id);
			
			
			
			foreach($amenities as $am){
				$data['room_amenities'][]	=	$am->amenity_id;
			}
				
			//echo '<pre>'; print_r($data['room_amenities']);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$room_type)
			{
				$this->session->set_flashdata('error', lang('room_type_not_found'));
				redirect('admin/room_types');
			}
			
			//set values to db values
			$data['id']					= $room_type->id;
			$data['title']				= $room_type->title;
			$data['slug']				= $room_type->slug;
			$data['shortcode']			= $room_type->shortcode;
			$data['description']		= $room_type->description;
			$data['base_occupancy']		= $room_type->base_occupancy;
			$data['higher_occupancy']	= $room_type->higher_occupancy;
			$data['extra_bed']			= $room_type->extra_bed;
			$data['extra_beds']			= $room_type->extra_beds;
			$data['kids_occupancy']		= $room_type->kids_occupancy;
			$data['base_price']			= $room_type->base_price;
			$data['additional_person']	= $room_type->additional_person;
			$data['extra_bed_price']	= $room_type->extra_bed_price;
			
			$data['images']				= $this->room_type_model->get_images($id);
		}
		
		$this->form_validation->set_rules('title', 'lang:title', 'trim|required');
		$this->form_validation->set_rules('shortcode', 'lang:shortcode', 'trim|required');
		// $this->form_validation->set_rules('base_occupancy', 'lang:base_occupancy', 'trim|required');
		// $this->form_validation->set_rules('higher_occupancy', 'lang:higher_occupancy', 'trim|required');
		// $this->form_validation->set_rules('kids_occupancy', 'lang:kids_occupancy', 'trim|required');
		$this->form_validation->set_rules('base_price', 'lang:base_price', 'trim|required');
		// $this->form_validation->set_rules('additional_person', 'lang:additional_person', 'trim|required');
		// $this->form_validation->set_rules('extra_bed_price', 'lang:extra_bed_price', 'trim|required');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('room_types/form', $data);		
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
			if($id)
			{
				$slug		= $this->room_type_model->validate_slug($slug, $id);
			}
			else
			{
				$slug			= $this->room_type_model->validate_slug($slug);
			}
			//echo	$slug;die; 
			
			//echo '<pre>'; print_r($_POST);die;
			$save['id']					= $id;
			$save['title']				= $this->input->post('title');
			$save['slug']				= $slug;
			$save['shortcode']			= $this->input->post('shortcode');
			$save['description']		= $this->input->post('description');
			$save['base_occupancy']		= $this->input->post('base_occupancy');
			$save['higher_occupancy']	= $this->input->post('higher_occupancy');
			$save['extra_bed']			= $this->input->post('extra_bed');
			$save['extra_beds']			= $this->input->post('extra_beds');
			$save['kids_occupancy']		= $this->input->post('kids_occupancy');
			$save['base_price']			= $this->input->post('base_price');
			$save['additional_person']	= $this->input->post('additional_person');
			$save['extra_bed_price']	= $this->input->post('extra_bed_price');
			
			$p_key	=	$this->room_type_model->save($save);
				$amenities	=	$this->input->post('amenity');
				$this->room_type_model->delete_roomtype($p_key);
				if(!empty($amenities)){
					$i=0;
					foreach($amenities as $ind	=> $val){
							$save_amenity[$i]['amenity_id']	=	$ind;
							$save_amenity[$i]['room_type_id']		=	$p_key;
					$i++;
					}
					$this->room_type_model->save_amenity($save_amenity);
				}
			
				$upload_data	=	 array();
				$files 			= 	 $_FILES;
				$save_img		=	 array();
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
								$save_img['room_type_id']	=	$p_key;
								$save_img['image']		=	$file_name;
								$this->room_type_model->save_images($save_img);
								
								
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
				$this->session->set_flashdata('message', lang('room_type_update'));
			}else{
				$this->session->set_flashdata('message', lang('room_type_save'));
			}
			
			redirect('admin/room_types/form/'.$p_key.'?show=image');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$room_type	= $this->room_type_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$room_type)
			{
				$this->session->set_flashdata('error', lang('room_type_not_found'));
				redirect('admin/room_types');
			}
			else
			{
				//if the customer is legit, delete them
				$delete	= $this->room_type_model->delete($id);
				$images				= $this->room_type_model->get_images($id);	
				foreach($images as $img){
						$this->room_type_model->delete_image($img->id);
						
						$full 		= BASEPATH.'../assets/admin/uploads/gallery/full/'.$img->image;
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
					
				$this->session->set_flashdata('message', lang('room_type_delete'));
				redirect('admin/room_types');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('room_type_not_found'));
				redirect('admin/room_types');
		}
	}
	function updateimg(){
		//echo '<pre>'; print_r($_POST);
		$id			=	$_POST['id'];	
		$gallery	=	$this->room_type_model->get_image($id);
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
		$this->room_type_model->delete_image($id);
	}	
	
	
	function edit_image($id){
		$gallery	=	$this->room_type_model->get_image($id);
		$full 		= BASEPATH.'../assets/admin/uploads/gallery/full/'.$gallery->image;
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
							$this->room_type_model->update_images($save_img,$id);
							
							
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
	
	function featured(){
		//echo '<pre>'; print_r($_POST);die;
		//update set 0 to all by room_type_id
		$value	=	0;
		$this->room_type_model->unset_featured($value,$_POST['room_type_id']);
		
		//set featured
		$this->room_type_model->set_featured($_POST['id']);
	
	}
	
}