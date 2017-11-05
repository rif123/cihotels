<?php
class Price_manager extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('price_manager_model','room_type_model'));
	}
	
	function index()
	{	
		$data['page_title']	= lang('price_manager');
		$data['prices']	= $this->price_manager_model->get_all();
			//echo '<pre>'; print_r($data['floors']);
		$this->render_admin('price_manager/list', $data);		
	}
	
	
	function form($id = false,$tab=false)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['room_types']	= $this->room_type_model->get_all();
		$data['page_title']		= lang('price_manager_form');
		//default values are empty if the customer is new
		$data['tab']					= $tab;
		$data['id']					= '';
		$data['name']				= '';
		$data['spl_prices']			=	array();
		if ($id)
		{	
			
			$data['price']			=	$price		= $this->price_manager_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$price)
			{
				$this->session->set_flashdata('error', lang('price_manager_not_found'));
				redirect('admin/price_manager');
			}
			
			//set values to db values
			$data['id']				= $price->id;
			$data['room_type_id']	= $price->room_type_id;
			$data['mon']			= $price->mon;
			$data['tue']			= $price->tue;
			$data['wed']			= $price->wed;
			$data['thu']			= $price->thu;
			$data['fri']			= $price->fri;
			$data['sat']			= $price->sat;
			$data['sun']			= $price->sun;
			
			$data['spl_prices']	=	$this->price_manager_model->get_special_prices($data['room_type_id']);
		}
		if(!$id){
		$this->form_validation->set_rules('room_type_id', 'lang:room_type', 'trim|required');
		}
		$this->form_validation->set_rules('mon', 'lang:mon', 'trim|required');
		$this->form_validation->set_rules('tue', 'lang:tue', 'trim|required');
		$this->form_validation->set_rules('wed', 'lang:wed', 'trim|required');
		$this->form_validation->set_rules('thu', 'lang:thu', 'trim|required');
		$this->form_validation->set_rules('fri', 'lang:fri', 'trim|required');
		$this->form_validation->set_rules('sat', 'lang:sat', 'trim|required');
		$this->form_validation->set_rules('sun', 'lang:sun', 'trim|required');
		
		$this->form_validation->set_rules('title', 'lang:title', '');
		$this->form_validation->set_rules('spl_mon', 'lang:mon', '');
		$this->form_validation->set_rules('spl_tue', 'lang:tue', '');
		$this->form_validation->set_rules('spl_wed', 'lang:wed', '');
		$this->form_validation->set_rules('spl_thu', 'lang:thu', '');
		$this->form_validation->set_rules('spl_fri', 'lang:fri', '');
		$this->form_validation->set_rules('spl_sat', 'lang:sat', '');
		$this->form_validation->set_rules('spl_sun', 'lang:sun', '');
				
		if ($this->form_validation->run() == FALSE)
		{
			$this->render_admin('price_manager/form', $data);		
		}
		else
		{
			$save['id']				= $id;
			if($id){
				$save['room_type_id']			= $data['room_type_id'];
			}else{
				$save['room_type_id']			= $this->input->post('room_type_id');
			}
			$save['mon']			= $this->input->post('mon');
			$save['tue']			= $this->input->post('tue');
			$save['wed']			= $this->input->post('wed');
			$save['thu']			= $this->input->post('thu');
			$save['fri']			= $this->input->post('fri');
			$save['sat']			= $this->input->post('sat');
			$save['sun']			= $this->input->post('sun');
			
			//echo '<pre>'; print_r($save);die;
			$p_key	=	$this->price_manager_model->save($save);
				if(!empty($_POST['title'])){
					$date	=	explode('/',$_POST['date']);
					if($id){
						$save_spl['room_type_id']			= $data['room_type_id'];
					}else{
						$save_spl['room_type_id']			= $this->input->post('room_type_id');
					}
					$save_spl['title']			= $this->input->post('title');
					$save_spl['date_from']		= date('Y-m-d H:i:s', strtotime($date[0]));
					$save_spl['date_to']		= date('Y-m-d H:i:s', strtotime($date[1]));
					$save_spl['mon']			= $this->input->post('spl_mon');
					$save_spl['tue']			= $this->input->post('spl_tue');
					$save_spl['wed']			= $this->input->post('spl_wed');
					$save_spl['thu']			= $this->input->post('spl_thu');
					$save_spl['fri']			= $this->input->post('spl_fri');
					$save_spl['sat']			= $this->input->post('spl_sat');
					$save_spl['sun']			= $this->input->post('spl_sun');
					$this->price_manager_model->save_special_price($save_spl);
				}
			if($id){
				$this->session->set_flashdata('message', lang('price_manager_update'));
			}else{
				$this->session->set_flashdata('message', lang('price_manager_save'));
			}
			
			redirect('admin/price_manager');
		}
	}
	
	function delete($id = false)
	{
		if ($id)
		{	
			$price_manager	= $this->price_manager_model->get($id);
			//if the customer does not exist, redirect them to the customer list with an error
			if (!$price_manager)
			{
				$this->session->set_flashdata('error', lang('price_manager_not_found'));
				redirect('admin/price_manager');
			}
			else
			{
				$delete	= $this->price_manager_model->delete($id);
				
				$this->session->set_flashdata('message', lang('price_manager_delete'));
				redirect('admin/price_manager');
			}
		}
		else
		{
			//if they do not provide an id send them to the customer list page with an error
				$this->session->set_flashdata('error', lang('price_manager_not_found'));
				redirect('admin/price_manager');
		}
	}
	
	function delete_spl_price($id,$room_type_id){
		if($id){
				$delete	= $this->price_manager_model->delete_spl_price($id);
				
				$this->session->set_flashdata('message', lang('spl_price_delete'));
				redirect('admin/price_manager/form/'.$room_type_id.'/1');
		}
	}
	
	function get_room_type_data(){
		$room_type_id	=	$_POST['id'];
		$price	= $this->price_manager_model->get_room_type_price($room_type_id);
			//echo '<pre>'; print_r($price);die;
			if(!empty($price)){
				$price_array	=	 array('mon'=>$price->mon,
									 		'tue'=>$price->tue,
											'wed'=>$price->wed,
											'thu'=>$price->thu,
											'fri'=>$price->fri,
											'sat'=>$price->sat,
											'sun'=>$price->sun,
									 );
			}else{
				$price	= $this->room_type_model->get($room_type_id);
				$price_array	=	 array('mon'=>$price->base_price,
									 		'tue'=>$price->base_price,
											'wed'=>$price->base_price,
											'thu'=>$price->base_price,
											'fri'=>$price->base_price,
											'sat'=>$price->base_price,
											'sun'=>$price->base_price,
									 );
			}
			echo json_encode($price_array);
	}
	
	function check_start_date(){
		
		$price	= $this->price_manager_model->check_daterange();
		//echo '<pre>'; print_r($price);die;
		if(empty($price)){
			echo 0;die;
		}else{
			echo 1;die;
		}
	}
}