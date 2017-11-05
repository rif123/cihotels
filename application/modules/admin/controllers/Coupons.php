<?php
class Coupons extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('coupon_model','room_type_model','guest_model','service_model'));
	}
	
	function index()
	{
		
		$data['page_title']	= lang('coupon_management');
		
		$data['coupons']	= $this->coupon_model->get_all();
		//$data['states']	= $this->room_model->get_states();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('coupons/list', $data);		
	}
	
	function view($id,$tab=false){
		
		$data['room_type']			=	$room_type		= $this->service_model->get($id);
		$data['page_title']	= lang('view')." ".lang('room_type') ;
		$this->render_admin('room_types/view', $data);
	}
	
	function form($id = false)
	{
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['room_types']	= $this->room_type_model->get_all();
		$data['guests']	= $this->guest_model->get_all();
		$data['services']	= $this->service_model->get_all();
		$data['page_title']		= lang('coupon_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['title']				= '';
		$data['description']		= '';
		$data['image']				= '';
		$data['code']				= '';
		$data['type']				= '';
		$data['date']				= '';
		$data['value']				= '';
		$data['date_from']			= '';
		$data['date_to']			= '';
		$data['min_amount']				= '';
		$data['max_amount']				= '';
		$data['include_user']		= array();
		$data['exclude_user']		= array();
		$data['include_room_type']	= array();
		$data['exclude_room_type']	= array();
		$data['limit_per_user']		= '';
		$data['limit_per_coupon']	= '';
		$data['paid_services']		= array();
			
			
		if ($id)
		{	
			$data['coupon']			=	$coupon		= $this->coupon_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$coupon)
			{
				$this->session->set_flashdata('error', lang('coupon_not_found'));
				redirect('admin/coupons');
			}
			
			//set values to db values
			$data['id']					= $coupon->id;
			$data['title']				= $coupon->title;
			$data['description']		= $coupon->description;
			$data['image']				= $coupon->image;
			$data['code']				= $coupon->code;
			$data['type']				= $coupon->type;
			$data['date']				= $coupon->date_from.' / '.$coupon->date_to;
			$data['value']				= $coupon->value;
			$data['date_from']			= $coupon->date_from;
			$data['date_to']			= $coupon->date_to;
			$data['min_amount']				= $coupon->min_amount;
			$data['max_amount']				= $coupon->max_amount;
			$data['include_user']		= json_decode($coupon->include_user);
			$data['exclude_user']		= json_decode($coupon->exclude_user);
			$data['include_room_type']	= json_decode($coupon->include_room_type);
			$data['exclude_room_type']	= json_decode($coupon->exclude_room_type);
			$data['limit_per_user']		= $coupon->limit_per_user;
			$data['limit_per_coupon']	= $coupon->limit_per_coupon;
			$data['paid_services']		= json_decode($coupon->paid_services);
			
		}
		
		$this->form_validation->set_rules('title', 'lang:offer_title', 'trim|required');
		$this->form_validation->set_rules('code', 'lang:coupon_code', 'trim|required');
		$this->form_validation->set_rules('type', 'lang:coupon_type', 'trim|required');
		$this->form_validation->set_rules('date', 'lang:coupon_period', 'trim|required');
		$this->form_validation->set_rules('limit_per_user', 'lang:limit_per_user', '');
		$this->form_validation->set_rules('limit_per_coupon', 'lang:limit_per_coupon', '');
		
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('coupons/form', $data);		
		}
		else
		{
			$this->load->library('upload');	
				if(!empty($_FILES['image']['name'])){
						$_FILES['userfile']['name']= time().rand(1,988).'.'.substr(strrchr($_FILES['image']['name'],'.'),1);	
						$_FILES['userfile']['tmp_name']= $_FILES['image']['tmp_name'];
						$_FILES['userfile']['type']= $_FILES['image']['type'];
						$_FILES['userfile']['error']= $_FILES['image']['error'];
						$_FILES['userfile']['size']= $_FILES['image']['size'];
						
						$save['image'] = $_FILES['userfile']['name'];
						
						$this->upload->initialize($this->set_upload_options());
						$flag = $this->upload->do_upload();
						$this->upload->data();
						
						if(file_exists(BASEPATH.'../assets/admin/uploads/coupons/'.$this->input->post('old_image')) && $flag)
							unlink(BASEPATH.'../assets/admin/uploads/coupons/'.$this->input->post('old_image'));
				}
			$date	=	explode('/',$_POST['date']);
			$save['id']					= $id;
			$save['title']				= $this->input->post('title');
			$save['description']		= $this->input->post('description');
			$save['code']				= strtolower($this->input->post('code'));
			$save['type']				= $this->input->post('type');
			$save['value']				= $this->input->post('value');
			$save['date_from']			= date('Y-m-d H:i:s', strtotime($date[0]));
			$save['date_to']			= date('Y-m-d H:i:s', strtotime($date[1]));
			$save['min_amount']			= $this->input->post('min_amount');
			$save['max_amount']			= $this->input->post('max_amount');
			$save['include_user']		= json_encode($this->input->post('include_user'));
			$save['exclude_user']		= json_encode($this->input->post('exclude_user'));
			$save['include_room_type']	= json_encode($this->input->post('include_room_type'));
			$save['exclude_room_type']	= json_encode($this->input->post('exclude_room_type'));
			$save['limit_per_user']		= $this->input->post('limit_per_user');
			$save['limit_per_coupon']	= $this->input->post('limit_per_coupon');
			$save['paid_services']		= json_encode($this->input->post('paid_services'));
			///echo '<pre>'; print_r($_POST);
			//echo '<pre>'; print_r($save);die;
			$p_key	=	$this->coupon_model->save($save);
				
			
			if($id){
				$this->session->set_flashdata('message', lang('coupon_update'));
			}else{
				$this->session->set_flashdata('message', lang('coupon_save'));
			}
			redirect('admin/coupons');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$coupon	= $this->coupon_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$coupon)
			{
				$this->session->set_flashdata('error', lang('coupon_not_found'));
				redirect('admin/coupons');
			}
			else
			{
				$file = BASEPATH.'../assets/admin/uploads/coupons/'.$coupon->image;
						if (file_exists($file)) {
							unlink($file);
						}
				//if the customer is legit, delete them
				$delete	= $this->coupon_model->delete($id);
				
				$this->session->set_flashdata('message', lang('coupon_delete'));
				redirect('admin/coupons');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('coupon_not_found'));
				redirect('admin/coupons');
		}
	}
	
	private function set_upload_options()
	{  //  upload an image and document options
		$config = array();
		$config['upload_path'] = BASEPATH.'../assets/admin/uploads/coupons/';
		$config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf';
		$config['max_size'] = '0'; // 0 = no file size limit
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['overwrite'] = TRUE;
		return $config;
	}
	
}