<?php
class Employees extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('employee_model','department_model','designation_model','location_model'));
	}
	
	function index()
	{	
		$data['page_title']	= lang('employees');
		$data['employees']	= $this->employee_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('employees/list', $data);	
     	
	}
	
	
	function form($id = false)
	{
	    
        if($this->config->item('demo_site')){
            $this->session->set_flashdata('error',lang('demo_mode'));
            redirect('admin/employees');
        }   
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title']			= lang('employee_form');
		$data['departments']		= $this->department_model->get_all();
		$data['designations']		= $this->designation_model->get_all();
		$data['countries']	= $this->location_model->get_countries();
		//default values are empty if the customer is new
		$data['id']						= '';
		$data['title']					= '';
		$data['firstname']				= '';
		$data['lastname']				= '';
		$data['username']				= '';
		$data['email']					= '';
		$data['phone']					= '';
		$data['department_id']			= '';
		$data['designation_id']			= '';
		$data['gender']					= '';
		$data['dob']					= '';
		$data['country_id']				= '';
		$data['state_id']				= '';
		$data['city_id']				= '';
		$data['address']				= '';
		$data['id_type']				= '';
		$data['id_no']					= '';
		$data['id_upload']				= '';
		$data['salary']					= '';
		$data['join_date']				= '';
		$data['remarks']				= '';
		$data['shift']					= '';
	
		if ($id)
		{	
			$data['employee']			=	$employee		= $this->employee_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$employee)
			{
				$this->session->set_flashdata('error', lang('employee_not_found'));
				redirect('admin/employees');
			}
            
           
			
			//set values to db values
			$data['id']						= $employee->id;
			$data['title']					= $employee->title;
			$data['firstname']				= $employee->firstname;
			$data['lastname']				= $employee->lastname;
			$data['username']				= $employee->username;
			$data['email']					= $employee->email;
			$data['phone']					= $employee->phone;
			$data['department_id']			= $employee->department_id;
			$data['designation_id']			= $employee->designation_id;
			$data['gender']					= $employee->gender;
			$data['dob']					= $employee->dob;
			$data['country_id']				= $employee->country_id;
			$data['state_id']				= $employee->state_id;
			$data['city_id']				= $employee->city_id;
			$data['address']				= $employee->address;
			$data['id_type']				= $employee->id_type;
			$data['id_no']					= $employee->id_no;
			$data['id_upload']				= $employee->id_upload;
			$data['salary']					= $employee->salary;
			$data['join_date']				= $employee->join_date;
			$data['remarks']				= $employee->remarks;
			$data['shift']					= $employee->shift_from.' / '.$employee->shift_to;
			
		}
		
		$this->form_validation->set_rules('firstname', 'lang:firstname', 'trim|required');
		$this->form_validation->set_rules('lastname', 'lang:lastname', 'trim|required');
		
		if($this->input->post('email') == $this->input->post('old_email')) {
		  	$this->form_validation->set_rules('email', 'lanng:email', 'trim|required|max_length[128]|required');
		} else {
		  $this->form_validation->set_rules('email', 'lanng:email', 'trim|required|max_length[128]|is_unique[users.email]');
		}
		
		if ($this->input->post('password') != '' || $this->input->post('password_confirm') != '' || !$id)
		{
			$this->form_validation->set_rules('password', 'lang:password', 'required|min_length[6]');
			$this->form_validation->set_rules('password_confirm', 'lang:password_confirm', 'required|matches[password]');
		}
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('employees/form', $data);		
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

			$date	=	explode('/',$_POST['shift']);
			if(!$id){
				$data['username']				= $this->input->post('username');
				$data['added']				= date("Y-m-d H:i:s");
			}
			if ($this->input->post('password') != '' || !$id)
			{
				$save['password']	= sha1($this->input->post('password'));
			}
			
			$save['id']						= $id;
			$save['title']					= $this->input->post('title');
			$save['gender']					= $this->input->post('gender');
			$save['firstname']				= $this->input->post('firstname');
			$save['lastname']				= $this->input->post('lastname');
			
			$save['email']					= $this->input->post('email');
			$save['phone']					= $this->input->post('phone');
			$save['department_id']			= $this->input->post('department_id');
			$save['designation_id']			= $this->input->post('designation_id');
			//$save['gender']					= $this->input->post('gender');
			$save['dob']					= $this->input->post('dob');
			$save['country_id']				= $this->input->post('country_id');
			$save['state_id']				= $this->input->post('region_id');
			$save['city_id']				= $this->input->post('city_id');
			$save['address']				= $this->input->post('address');
			$save['id_type']				= $this->input->post('id_type');
			$save['id_no']					= $this->input->post('id_no');
			$save['salary']					= $this->input->post('salary');
			$save['join_date']				= $this->input->post('join_date');
			$save['remarks']				= $this->input->post('remarks');
			
			$save['shift_from']			= date('Y-m-d H:i:s', strtotime($date[0]));
			$save['shift_to']			= date('Y-m-d H:i:s', strtotime($date[1]));
		
			$save['active']					= 1;
			$save['user_role']				= 2;
			
			$this->employee_model->save($save);
			if($id){
				$this->session->set_flashdata('message', lang('employee_update'));
			}else{
				$this->session->set_flashdata('message', lang('employee_save'));
			}
			redirect('admin/employees');
		}
	}
	
	function delete($id = false)
	{
	    if($this->config->item('demo_site')){
                $this->session->set_flashdata('error',lang('demo_mode'));
                redirect('admin/employees');
        }   
		if ($id)
		{	
			$employee	= $this->employee_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$employee)
			{
				$this->session->set_flashdata('error', lang('employee_not_found'));
				redirect('admin/employees');
			}
			else
			{
				$file = BASEPATH.'../assets/admin/uploads/ids/'.$employee->id_upload;
						if (file_exists($file)) {
							unlink($file);
						}
				$delete	= $this->employee_model->delete($id);
				
				$this->session->set_flashdata('message', lang('employee_delete'));
				redirect('admin/employees');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('employee_not_found'));
				redirect('admin/employees');
		}
	}
	
	function check_username(){
		$username	=	$_POST['username'];
		$result	=	$this->employee_model->check_username($username);
		if(!empty($result)){
			echo 1;
		}
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