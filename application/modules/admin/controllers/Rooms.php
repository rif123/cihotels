<?php
class Rooms extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('room_model','floor_model','room_type_model','amenities_model','housekeeping_model','housekeping_status_model','employee_model','booking_model'));
	}
	
	function index()
	{
		$admin = $this->session->userdata('admin');
		
		$data['page_title']	= lang('rooms');
		$data['booked_rooms_today']	= $this->room_model->get_booked_room();
		$data['floors']	= $this->floor_model->get_all();
		$data['room_types']	= $this->room_type_model->get_all();
		$data['rooms']	= $this->room_model->get_all();
		$data['states']	= $this->room_model->get_states();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('rooms/list', $data);		
	}
	
	function check_room_number(){
		if(!empty($_POST['id'])){
			$id	=	$_POST['id'];
			$room	= $this->room_model->get_by_room_no($_POST['value'],$id);
			if(!empty($room)){
				echo 1;exit;
			}
		}else{
			$id=0;
			$room	= $this->room_model->get_by_room_no($_POST['value'],$id);
			if(!empty($room)){
				echo 1;exit;
			}
		}
	}
	function housekeeping($id)
	{	
		$data['housekeeping_status_all']	= $this->housekeping_status_model->get_all();
		$data['employees']	= $this->employee_model->get_all();
		$data['room_id']	=	$id;
		$this->load->library('form_validation');
			if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			
			$this->form_validation->set_rules('room_id', 'lang:room_id', 'required');
			$this->form_validation->set_rules('date', 'lang:date', 'required');
			$this->form_validation->set_rules('housekeeping_status', 'lang:housekeping_status', 'required');			 
			if ($this->form_validation->run()==true)
            {
				$save['id']						= false;
				$save['room_id']				= $this->input->post('room_id');
				$save['housekeeping_status']	= $this->input->post('housekeeping_status');
				$save['room_availblity']		= $this->input->post('room_availblity');
				$save['remark']					= $this->input->post('remark');
				$save['assigned_to']			= $this->input->post('assigned_to');
				$save['date']					= $this->input->post('date');
				$this->housekeeping_model->save($save);
		        $this->session->set_flashdata('message', lang('housekeping_status_save'));
				redirect('admin/rooms/housekeeping/'.$save['room_id']);
			}
			
		}
		$data['payments']		=	$this->booking_model->get_payment($id);	
		$data['page_title']		= lang('housekeeping');
		$data['housekeeping']	= $this->housekeeping_model->get_all_by_room($id);
		$this->render_admin('rooms/housekeeping', $data);		
	}
	
	
	function edit_housekeeping()
	{	
		
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//validate form input
			$this->load->library('form_validation');
			$this->form_validation->set_rules('room_id', 'lang:room_id', 'required');
			$this->form_validation->set_rules('date', 'lang:date', 'required');
			$this->form_validation->set_rules('housekeeping_status', 'lang:housekeping_status', 'required');			 
			if ($this->form_validation->run()==true)
            {
				$save['id']						= $this->input->post('id');
				$save['room_id']				= $this->input->post('room_id');
				$save['housekeeping_status']	= $this->input->post('housekeeping_status');
				$save['room_availblity']		= $this->input->post('room_availblity');
				$save['remark']					= $this->input->post('remark');
				$save['assigned_to']			= $this->input->post('assigned_to');
				$save['date']					= $this->input->post('date');
				$this->housekeeping_model->save($save);
		        $this->session->set_flashdata('message', lang('housekeping_status_update'));
				echo 1;exit;
			}else{
			
			echo '
				<div class="alert alert-danger alert-dismissable">
												<i class="fa fa-ban"></i>
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
												<b>Alert!</b>'.validation_errors().'
											</div>
				';
			}
		}
		
	}

	function view($id,$tab=false){
		
		$data['room_type']			=	$room_type		= $this->room_type_model->get($id);
		$data['page_title']	= lang('view')." ".lang('room_type') ;
		$this->render_admin('room_types/view', $data);
	}
	function form($id = false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['floors']	= $this->floor_model->get_all();
		$data['room_types']	= $this->room_type_model->get_all();
		$data['page_title']		= lang('room_form');
		
		//default values are empty if the customer is new
		$data['id']					= '';
		$data['room_no']			= '';
		$data['floor_id']			= '';
		$data['room_type_id']		= '';
		
		if ($id)
		{	
			$data['room']			=	$room		= $this->room_model->get($id);
			
				
			//echo '<pre>'; print_r($data['room_amenities']);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$room)
			{
				$this->session->set_flashdata('error', lang('room_not_found'));
				redirect('admin/rooms');
			}
			
			//set values to db values
			$data['id']					= $room->id;
			$data['room_no']			= $room->room_no;
			$data['floor_id']			= $room->floor_id;
			$data['room_type_id']		= $room->room_type_id;
					
		}
		
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			//echo '<pre>'; print_r($_POST);die;
			$rn				=	$this->input->post('room_number');
			$floor_id		=	$this->input->post('floor_id');
			$room_type_id	=	$this->input->post('room_type_id');
			
			
			
			if(!empty($rn)){
				$i=0;
				foreach($rn as $new){
					$room	= $this->room_model->get_by_room_no($new,$id);
					if(empty($room)){
						$save['id']					=	 $id;
						$save['room_no']			= $new;
						$save['floor_id']			= $floor_id;
						$save['room_type_id']		= $room_type_id[$i];	
						$p_key	=	$this->room_model->save($save);
					}	
				$i++;
				}
			}
			
			
			if($id){
				$this->session->set_flashdata('message', lang('room_update'));
			}else{
				$this->session->set_flashdata('message', lang('room_save'));
			}
			
			redirect('admin/rooms');
		}	
		
			$this->render_admin('rooms/form', $data);		
			
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$room	= $this->room_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$room)
			{
				$this->session->set_flashdata('error', lang('room_not_found'));
				redirect('admin/rooms');
			}
			else
			{
				//if the customer is legit, delete them
				$delete	= $this->room_model->delete($id);
				
				$this->session->set_flashdata('message', lang('room_delete'));
				redirect('admin/rooms');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
			$this->session->set_flashdata('error', lang('room_not_found'));
				redirect('admin/rooms');
		}
	}
	
	
}