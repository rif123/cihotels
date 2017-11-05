<?php
class Guests extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('guest_model','location_model','dashboard_model'));
	}
	
	function index()
	{
		$admin = $this->session->userdata('admin');
		$data['orders']		=	$this->dashboard_model->get_orders();
		$data['income']		=	$this->dashboard_model->get_total_income();	
		$data['page_title']	= lang('guests');
		$data['guests']	= $this->guest_model->get_all();
		$data['vip']	= $this->guest_model->get_vip();
			//echo '<pre>'; print_r($this->setting);
		$this->render_admin('guests/list', $data);		
	}
	 public function ajax_list()
    {
        $list = $this->guest_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $guest) {
			if($guest->vip==1){
				$content	=	'<i class="fa fa-user"></i> '.lang('vip');
			}else{
				$content	=	'<i class="fa fa-check"></i> '.lang('add_to_vip');
			}
			$no++;
            $row = array();
            $row[] = $no;
            $row[] = $guest->firstname." ".$guest->lastname;
            $row[] = $guest->country;
            $row[] = $guest->email;
            $row[] = $guest->mobile;
            $options	=	'<div class="btn-group" style="float:right"><a class="btn btn-success" href="'.site_url('admin/guests/vip/'.$guest->id.'/'.$guest->vip).'" >'.$content.'</a> <a class="btn btn-default" href="'.site_url('admin/guests/view/'.$guest->id).'"><i class="fa fa-eye"></i>'.lang('view').'</a> <a class="btn btn-primary" href="'.site_url('admin/guests/form/'.$guest->id).'>"><i class="fa fa-edit"></i> '.lang('edit').'</a><a class="btn btn-danger" href="'.site_url('admin/guests/delete/'.$guest->id).'" onclick="return areyousure(this);"><i class="fa fa-trash"></i> '.lang('delete').'</a> </div>';
			$row[] =   $options;
            
            $data[] = $row;
        }
		//echo '<pre>'; print_r($this->guest_model->count_filtered());die;
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->guest_model->count_all(),
                        "recordsFiltered" => $this->guest_model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
	
	function view($id,$tab=false){
		
		$data['guest']			=	$guest		= $this->guest_model->get($id);
		$data['payments']			= 	$this->guest_model->get_payments($id);
		$data['bookings']		=	$this->guest_model->get_bookings($id);
		
		$data['page_title']	= lang('view')." ".lang('guest') ;
		$this->render_admin('guests/view', $data);
	}
	function form($id = false)
	{
		$data['countries']	= $this->location_model->get_countries();	
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']		= lang('guest_form');
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['firstname']			= '';
		$data['lastname']			= '';
		$data['gender']				= '';
		$data['password']			= '';
		$data['dob']				= '';
		$data['email']				= '';
		$data['country_id']			= '';
		$data['state_id']			= '';
		$data['city_id']			= '';
		$data['address']			= '';
		$data['mobile']				= '';
		$data['id_type']			= '';
		$data['id_no']				= '';
		$data['id_upload']			= '';
		$data['remark']				= '';
		$data['vip']				= '';
		
		if ($id)
		{	
			$data['guest']			=	$guest		= $this->guest_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$guest)
			{
				$this->session->set_flashdata('error', lang('guest_not_found'));
				redirect('admin/guests');
			}
			
			$data['id']					= $guest->id;
			$data['firstname']			= $guest->firstname;
			$data['lastname']			= $guest->lastname;
			$data['gender']				= $guest->gender;
			$data['dob']				= $guest->dob;
			$data['email']				= $guest->email;
			//$data['password']			= $guest->password;
			$data['country_id']			= $guest->country_id;
			$data['state_id']			= $guest->state_id;
			$data['city_id']			= $guest->city_id;
			$data['address']			= $guest->address;
			$data['mobile']				= $guest->mobile;
			$data['id_type']			= $guest->id_type;
			$data['id_no']				= $guest->id_no;
			$data['id_upload']			= $guest->id_upload;
			$data['remark']				= $guest->remark;
			$data['vip']				= $guest->vip;
		}
		
		$this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|required');
		$this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|required');
		
		if($this->input->post('email') == $this->input->post('old_email')) {
		  	$this->form_validation->set_rules('email', 'lanng:email', 'trim|required|max_length[128]|required');
		} else {
		  $this->form_validation->set_rules('email', 'lanng:email', 'trim|required|max_length[128]|is_unique[guests.email]');
		}
		
		$this->form_validation->set_rules('mobile', 'lang:mobile', 'trim|required|max_length[32]');
		$this->form_validation->set_rules('gender', 'lang:gender', 'required');
				
		//if this is a new account require a password, or if they have entered either a password or a password confirmation
		if ($this->input->post('password') != '' || $this->input->post('confirm') != '' || !$id)
		{
			$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
			$this->form_validation->set_rules('confirm', 'lang:password_confirm', 'required|matches[password]');
		}
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('guests/form', $data);		
		}
		else
		{
			$this->load->library('upload');	
				if(!empty($_FILES['id_upload']['name'])){
						$_FILES['userfile']['name']= time().rand(1,988).'.'.substr(strrchr($_FILES['id_upload']['name'],'.'),1);	
						$_FILES['userfile']['tmp_name']= $_FILES['id_upload']['tmp_name'];
						$_FILES['userfile']['type']= $_FILES['id_upload']['type'];
						$_FILES['userfile']['error']= $_FILES['id_upload']['error'];
						$_FILES['userfile']['size']= $_FILES['id_upload']['size'];
						
						$save['id_upload'] = $_FILES['userfile']['name'];
						
						$this->upload->initialize($this->set_upload_options());
						$flag = $this->upload->do_upload();
						$this->upload->data();
						
						if(file_exists(BASEPATH.'../assets/admin/uploads/ids/'.$this->input->post('old_id')) && $flag)
							unlink(BASEPATH.'../assets/admin/uploads/ids/'.$this->input->post('old_id'));
				}

			
			$save['id']					= $id;
			$save['firstname']			= $this->input->post('firstname');
			$save['lastname']			= $this->input->post('lastname');
			$save['gender']				= $this->input->post('gender');
			$save['dob']				= $this->input->post('dob');
			$save['email']				= $this->input->post('email');
			$save['country_id']			= $this->input->post('country_id');
			$save['state_id']			= $this->input->post('region_id');
			$save['city_id']			= $this->input->post('city_id');
			$save['address']			= $this->input->post('address');
			$save['mobile']				= $this->input->post('mobile');
			$save['id_type']			= $this->input->post('id_type');
			$save['id_no']				= $this->input->post('id_no');
			//$save['id_upload']			= $this->input->post('id_upload');
			$save['remark']				= $this->input->post('remark');
			$save['vip']				= $this->input->post('vip');
			
			if ($this->input->post('password') != '' || !$id)
			{
				$save['password']	= sha1($this->input->post('password'));
			}
			
			if(!$id){
				$save['added']				= date('Y-m-d H:i:s');
			}
			
			//echo '<pre>';print_r($save);die;
			$this->guest_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('guest_update'));
			}else{
				$this->session->set_flashdata('message', lang('guest_save'));
			}
			
			redirect('admin/guests');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$guest	= $this->guest_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$guest)
			{
				$this->session->set_flashdata('error', lang('guest_not_found'));
				redirect('admin/guests');
			}
			else
			{
				$file = BASEPATH.'../assets/admin/uploads/ids/'.$guest->id_upload;
						if (file_exists($file)) {
							unlink($file);
						}
				//if the customer is legit, delete them
				$delete	= $this->guest_model->delete($id);
				
				$this->session->set_flashdata('message', lang('guest_delete'));
				redirect('admin/guests');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('guest_not_found'));
				redirect('admin/guests');
		}
	}
	function get_states()
	{
		$states		=	$this->location_model->get_zones($_POST['country_id']);
		echo '<option value="">--'.lang('select_region').'--</option>';
		foreach($states as $new){
			echo '<option value="'.$new->id.'">'.$new->name.'</option>';
		}
	}
	
	function get_cities()
	{
		$cities		=	$this->location_model->get_zone_areas($_POST['state_id']);
		echo '<option value="">--'.lang('select_city').'--</option>';
		foreach($cities as $new){
			echo '<option value="'.$new->id.'">'.$new->name.'</option>';
		}
	}
	
	function vip($id,$value){
		if($value==1){
			$save['vip']	=	0;
			$save['id']	=	$id;
			$this->session->set_flashdata('message', lang('guest_removed_from_vip'));
		}
		if($value==0){
			$save['vip']	=	1;
			$save['id']	=	$id;
			$this->session->set_flashdata('message', lang('guest_added_to_vip'));
		}
		if(!empty($save)){
			$this->guest_model->save($save);
		}	
		redirect('admin/guests');
	}
	private function set_upload_options()
	{  //  upload an image and document options
		$config = array();
		$config['upload_path'] = BASEPATH.'../assets/admin/uploads/ids/';
		$config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf';
		$config['max_size'] = '0'; // 0 = no file size limit
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['overwrite'] = TRUE;
		return $config;
	}
}