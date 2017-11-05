<?php
class Bookings extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('booking_model','room_type_model','guest_model'));
		$this->load->library('form_validation');
	}
	
	function add(){
		//echo '<pre>'; print_r($this->setting);die;
		$data['guests']	= $this->guest_model->get_all();
		$data['room_types']	= $this->room_type_model->get_all();
		$this->session->unset_userdata('booking_data');
		$this->session->unset_userdata('coupon_data');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			$this->form_validation->set_rules('guest_id', 'lang:guest', 'required');
			$this->form_validation->set_rules('room_type_id', 'lang:room', '');
			$this->form_validation->set_rules('check_in', 'lang:check_in', 'required');
			$this->form_validation->set_rules('check_out', 'lang:check_out', 'required');
			$this->form_validation->set_rules('total', 'lang:total', 'required');
			
			if ($this->form_validation->run() == true)
			{	
							$room_type	=	$this->room_type_model->get($_POST['room_type_id']);
							$sess_curruncy = $this->session->userdata('currency');	
							$currency = $this->setting->currency_code;
							
							$paid_services	=	$this->input->post('paid_services');	
							 $nights	=	GetDays($_POST['check_in'],$_POST['check_out'])-1;	
							 if($nights==0){
							 	$nights=1;
							 }
							 $base_price	=	get_price($_POST['check_in'],$_POST['check_out'],$_POST['room_type_id'],$_POST['adults'],$_POST['kids']);
							 $amount		=	$base_price['total_price'];
							 //$amount	=	$room_type->base_price * $_POST['adults'] * $nights;		//oLd
							 $taxamount	=	get_tax_amount($amount);
							 $total		=	$amount+$taxamount;
							if(!empty($paid_services)){
								$booking_data['paid_service_amount']		=	get_paid_service_amount_all($paid_services,$_POST['adults'],$nights);
								$total	=	$total+$booking_data['paid_service_amount'];
							}	
							$booking_data['order_no']		=	time().$_POST['guest_id'];
							$booking_data['check_in']		=	$this->input->post('check_in');
							$booking_data['check_out']		=	$this->input->post('check_out');
							$booking_data['guest_id']		=	$_POST['guest_id'];
							$booking_data['adults']			=	$this->input->post('adults');
							$booking_data['kids']			=	$this->input->post('kids');
							$booking_data['room_type_id']	=	$this->input->post('room_type_id');
							$booking_data['ordered_on']		=	date('Y-m-d H:i:s');
							$booking_data['base_price']		=	$room_type->base_price;
							$booking_data['additional_person_amount']		=	$base_price['additional_person_amount'];
							$booking_data['additional_person']		=	$base_price['additional_person'];
							$booking_data['amount']			=	round($amount,2);
							$booking_data['taxamount']		=	round($taxamount,2);
							$booking_data['totalamount']	=	round($total,2);
							$booking_data['nights']			=	$nights;
							$booking_data['currency']		=	$currency;
							$booking_data['currency_unit']	=	get_currency_unit();
							$booking_data['paid_services']	=	$paid_services;
							$booking_data['room_type']		=	$room_type->title;;
							$booking_data['base_price_details']		=	$base_price;
							//echo '<pre>'; print_r($booking_data);die;
							$this->session->set_userdata('booking_data',$booking_data);
							redirect('admin/bookings/save');
			}
			
			
		}	
		
		$data['page_title'] = lang('booking') ." ".lang('form');;	
		$this->render_admin('bookings/add', $data);
	}
	
	function save(){
		//echo '<pre>'; print_r($_POST);die;
		$data['guests']	= $this->guest_model->get_all();
		$data['room_types']	= $this->room_type_model->get_all();
		$data['coupon_data']		=	$coupon_data	=	$this->session->userdata('coupon_data');
		$data['booking_data']	=	$booking_data	=	$this->session->userdata('booking_data');
		$data['booking']		=	$this->session->userdata('booking_data');
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			//echo '<pre>'; print_r($_POST);die;
			$coupon_apply	=	$this->input->post('coupon_apply');
			$coupon	=	strtolower($this->input->post('coupon'));
			
				if(!empty($coupon))
				{
					$result	=	apply_coupon_admin_booking($coupon);	
					
				}
				
				if(!empty($_POST['book'])){
					
					$currency = $this->setting->currency_code;
					$discount				=	0;
					$freeservice_amount		=	0;
					if(!empty($coupon_data['discount'])){
						$discount	=	$coupon_data['discount'];
					}
					
					if(!empty($coupon_data['services_total'])){
						$freeservice_amount	=	$coupon_data['services_total'];
					}
					
					$save['order_no']		=	$booking_data['order_no'];
					$save['check_in']		=	$booking_data['check_in'];
					$save['check_out']		=	$booking_data['check_out'];
					$save['guest_id']		=	$booking_data['guest_id'];
					$save['adults']			=	$booking_data['adults'];
					$save['kids']			=	$booking_data['kids'];
					$save['room_type_id']	=	$booking_data['room_type_id'];
					$save['payment_status']	=	2;	//default payment status will be pending
					$save['ordered_on']		=	date('Y-m-d H:i:s');
					$save['base_price']		=	$booking_data['base_price'];
					$save['additional_person_amount']		=	$booking_data['additional_person_amount'];
					$save['additional_person']		=	$booking_data['additional_person'];
					$save['amount']			=	$booking_data['amount'];
					$save['taxamount']		=	$booking_data['taxamount'];
					$save['paid_service_amount']		=	@$booking_data['paid_service_amount'];
					if(!empty($coupon_data)){
							$save['coupon']						=	@$coupon_data['code'];
							$save['totalamount']				=	$booking_data['totalamount']	-	$discount	-	$freeservice_amount;
							$save['coupon_discount']			=	@$coupon_data['discount'];
							$save['after_coupon_totalamount']	=	@$coupon_data['totalamount'];
						
						if(!empty($coupon_data['paid_service_applied'])){
							$save['free_paid_services']		=	json_encode($coupon_data['paid_service_applied']);
							$save['free_paid_services_title']		=	$coupon_data['services'];
							$save['free_paid_services_amount']		=	$coupon_data['services_total'];
						}
					}else{
							$save['totalamount']	=	$booking_data['totalamount'];
					}
					$save['nights']			=	$booking_data['nights'];
					$save['currency']		=	$currency;
					$save['currency_unit']	=	get_currency_unit();
					
					//echo '<pre>-->3'; print_r($save);die;
					
					$paid_services	=	@$booking_data['paid_services'];
					
					$p_key	=	$this->booking_model->save_order($save);
						//Save Payment
						
					$save['room_type']			=	@$booking_data['room_type'];
					$save['order_id']			=	$p_key;
					$save['payment_gateway']	=	@$_POST['payment_gateway'];
					$save['price_details']		=	$booking_data['base_price_details']['price_details'];
					//Unset Session 
					$this->session->unset_userdata('booking_data');
					$this->session->unset_userdata('coupon_data');
					
					
					$taxes			= $this->booking_model->get_taxes_for_booking();
					//echo '<pre>-->3'; print_r($taxes);die;
							
							$i=1;
							foreach($taxes as $t){
								$save_tax[$i]['order_id']	= $p_key;;	
								$save_tax[$i]['tax_id']		= $t->id;	
								$save_tax[$i]['amount']		= get_tax_amount_by_tax($t->id,$save['amount']);	
							$i++;
							}
							if(!empty($save_tax)){
								$this->booking_model->save_taxes($save_tax);
							}
										
							if(!empty($paid_services)){
								$i=0;
								foreach($paid_services as $new){
									$save_service[$i]['order_id']		= $p_key;;	
									$save_service[$i]['service_id']		= $new;	
									$save_service[$i]['amount']			= get_paid_service_amount($new,$save['adults'],$save['nights']);
								$i++;
								}
								$this->booking_model->save_service($save_service);
							}
							
							if(!empty($save['price_details'])){
								
								$pds	=	$save['price_details'];
								$i=0;
								foreach($pds as $ind	=> $val){
									$save_price[$i]['order_id']		=	$p_key;
									$save_price[$i]['date']			=	$ind;
									$save_price[$i]['price']		=	$val['price'];
									if($val['add_person'] > 0){
										$save_price[$i]['additional_person']		=	$val['add_person'];
										$save_price[$i]['additional_person_price']		=	$val['add_person_price'];
									}else{
										$save_price[$i]['additional_person']		=	0;
										$save_price[$i]['additional_person_price']		=	0;
									}
									$save_price[$i]['total']		=	$val['price']+@$save_price[$i]['additional_person_price']*@$save_price[$i]['additional_person'];
								$i++;
								}
								$this->booking_model->save_price($save_price);
							}
					//send mail
					$this->mail_booking($p_key);		
					$this->session->set_flashdata('message',lang('booking_saved'));					
					redirect('admin/bookings');
				}
			
		}
		$data['page_title'] = lang('booking') ." ".lang('form');;	
		$this->render_admin('bookings/next_page', $data);
	}
	function booking_status(){
		$save['status']	=	$_POST['status'];
		$this->booking_model->update_order($save,$_POST['id']);
		if($save['status']==2){
			$this->mail_cancel($_POST['id']);
		}
	}
	function payment_status(){
		$save['payment_status']	=	$_POST['status'];
		$this->booking_model->update_order($save,$_POST['id']);
	}
	function check_availability(){
		//echo '<pre>'; print_r($_POST);die;
		$result	=	check_availability_ajax($_POST['check_in'],$_POST['check_out'],$_POST['adults'],$_POST['kids'],$_POST['room_type_id']);
		if($result==1){
			echo 1;exit;
		}else{
			echo $result;exit;
		}
	}
	 
	 function get_booking_data(){
	 	//echo '<pre>'; print_r($_POST);die;
		$this->session->unset_userdata('coupon_data');	//unset old coupons data
		$data['taxes']			= $this->booking_model->get_taxes_for_booking();
		if(!empty($_POST['room_type_id'])){
			$data['services']			= $this->booking_model->get_paid_services($_POST['room_type_id']);
		}
		//echo '<pre>'; print_r($data['services']);
	 	$this->load->view('bookings/price_data', $data);
	 }
	function index()
	{	
		$data['page_title']		= lang('bookings');
		$data['bookings']		= $this->booking_model->get_all();
		$data['room_types']		= $this->room_type_model->get_all();
			//echo '<pre>'; print_r($data['bookings']);
		$this->render_admin('bookings/list', $data);		
	}
	
	function booking($id)
	{	
		$data['active']	=	0;
		if($this->uri->segment(5)=='payment'){
			$data['active']	=	1;
		}
		if($this->uri->segment(5)=='room'){
			$data['active']	=	2;
		}
		$data['page_title']	= lang('booking');
		$data['totalpaid']	= $this->booking_model->get_order_total($id);
		$data['booking']	= $this->booking_model->get($id);
		$data['taxes']	=	$this->booking_model->get_taxes($id);
		$data['services']	=	$this->booking_model->get_services($id);
		$data['prices']		=	$this->booking_model->get_prices($id);
		$data['payments']		=	$this->booking_model->get_payment($id);
			
		$data['rooms']	=		room_alot($data['booking']->check_in,$data['booking']->check_out,$data['booking']->room_type_id);
		$data['order_room']		=	$this->booking_model->get_room_of_order($data['booking']->id);
			//echo '<pre>'; print_r($data['prices']);die;
		$this->render_admin('bookings/booking', $data);		
	}	
	
	 
	 function payment()
	{	
		
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//validate form input
			$this->form_validation->set_rules('order_id', 'lang:order', 'required');
			$this->form_validation->set_rules('invoice_no', 'lang:invoice', '');
			$this->form_validation->set_rules('amount', 'lang:amount', 'required');
			
			if ($this->form_validation->run() == true)
			{	
						$totalpaid	= $this->booking_model->get_order_total($_POST['order_id']);
						$booking	= $this->booking_model->get($_POST['order_id']);
						$pending	=	$booking->totalamount-$totalpaid->total;
						if($_POST['amount'] > $pending){
							$this->session->set_flashdata('error',lang('amount_greater_to_pending'));
							redirect('admin/bookings/booking/'.$_POST['order_id'].'/payment', 'refresh');	
						}
						
						$save['order_id']	=	$this->input->post('order_id');
						$save['date_time']	=	date('Y-m-d H:i:s');
						$save['payment_method']		=	$this->input->post('payment_method');
						$save['amount']		=	$this->input->post('amount');;
						$save['invoice']	=	$this->input->post('invoice_no');
						$save['added_date']	=	$this->input->post('added_date');
					//echo '<pre>'; print_r($save);die;
				$this->booking_model->save_payment($save);
				$this->session->set_flashdata('message',lang('payment_updated'));
				redirect('admin/bookings/booking/'.$save['order_id'].'/payment', 'refresh');
			}
		}
		
	   	//Define Page Title
		
	}
	
	
	function newbookings()
	{	
		$data['page_title']		= lang('new').' '.lang('bookings');
		$data['bookings']		= $this->booking_model->get_all_new();
		$data['room_types']		= $this->room_type_model->get_all();
		$this->booking_model->new_order_viewed();
			//echo '<pre>'; print_r($data['bookings']);
		$this->render_admin('bookings/newbookings.php', $data);		
	}
	
	function newcanceled()
	{	
		$data['page_title']		= lang('new').' '.lang('canceled_booking');
		$data['bookings']		= $this->booking_model->get_canceled_new();
		$data['room_types']		= $this->room_type_model->get_all();
		$this->booking_model->new_canceled_viewed();
			//echo '<pre>'; print_r($data['bookings']);
		$this->render_admin('bookings/newbookings.php', $data);		
	}
	
	function edit_payment()
	{	
		
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//validate form input
			$this->form_validation->set_rules('id', 'lang:order', 'required');
			$this->form_validation->set_rules('amount', 'lang:amount', 'required');
			$this->form_validation->set_rules('payment_method', 'lang:payment_method', 'required');
			
			if ($this->form_validation->run() == true)
			{	
				$id							=	$this->input->post('id');
				$save['payment_method']		=	$this->input->post('payment_method');
				$save['amount']				=	$this->input->post('amount');
				$save['added_date']	=	$this->input->post('added_date');
					//echo '<pre>'; print_r($save);die;
				$this->booking_model->update_payment($save,$id);
				$this->session->set_flashdata('message',lang('payment_updated'));
				//redirect('admin/bookings/booking/'.$save['order_id'].'/payment', 'refresh');
				echo 1;die;
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
		
	   	//Define Page Title
		
	}
	
	function alotroom(){
		if($this->input->server('REQUEST_METHOD')==='POST'){
			
			//validate form input
			$this->form_validation->set_rules('order_id', 'lang:order', 'required');
			$this->form_validation->set_rules('room_id', 'lang:room_id', 'required');
			
			if ($this->form_validation->run() == true)
			{	
				$order_id						=	$this->input->post('order_id');
				$save['room_id']				=	$this->input->post('room_id');
					//echo '<pre>'; print_r($save);die;
				$this->booking_model->update_room($save,$order_id);
				$this->mail_room($order_id);
				$this->session->set_flashdata('message',lang('room_saved_for_order'));
				redirect('admin/bookings/booking/'.$order_id.'/room', 'refresh');
			}else{
				$this->session->set_flashdata('error','Something Went Wrong');
				redirect('admin/bookings/booking/'.$order_id.'/room', 'refresh');
			
			}
		}
	}
	
	function add_service_price(){
		//echo '<pre>'; print_r($_POST);die;
		$id		=	$_POST['id'];
		$nights	=	$_POST['nights'];
		$adults	=	$_POST['adults'];
		$total	=	$_POST['total'];
		$service_amount	=	get_paid_service_amount($id,$adults,$nights);
		$service_amount	=	rate_exchange($service_amount);
		echo $total+$service_amount;
	}
	function less_service_price(){
		//echo '<pre>'; print_r($_POST);die;
		$id		=	$_POST['id'];
		$nights	=	$_POST['nights'];
		$adults	=	$_POST['adults'];
		$total	=	$_POST['total'];
		
		$service_amount	=	get_paid_service_amount($id,$adults,$nights);
		$service_amount	=	rate_exchange($service_amount);
		echo $total-$service_amount;exit;
	}
	function apply_coupon(){
		//echo '<pre>'; print_r($_POST);die;
		$coupon		=	strtolower($this->input->post('coupon'));
		$guest_id	=		$this->input->post('guest_id');
				if(!empty($coupon))
				{
					$result	=	apply_coupon_ajax($coupon,$guest_id);	
					if($result==1){
						echo 1;exit;
					}else{
						echo $result;exit;
					}
				}
			
	}
	function mail_cancel($order_id){
		$data['order']	=	$order	=	$this->booking_model->get_order($order_id);
		$data['taxes']	=	$this->booking_model->get_taxes($order_id);
		$data['services']	=	$this->booking_model->get_services($order_id);
		$data['prices']		=	$this->booking_model->get_prices($order_id);

		$html = $this->load->view('bookings/mail', $data,true);
		
		$row	=	$this->booking_model->get_template(5);
		$row['subject'] = str_replace('{site_name}', $this->setting->name, $row['subject']);
		$row['content'] = str_replace('{customer_name}', $order->firstname, $row['content']);
		$row['content'] = str_replace('{site_name}', $this->setting->name, $row['content']);
		$row['content'] = str_replace('{order_summary}', $html, $row['content']);
		
		$msg 				 = html_entity_decode($row['content'],ENT_QUOTES, 'UTF-8');
		$params['recipient'] = $order->email;
		$params['subject'] 	 = $row['subject'];
		$params['message']   = $msg;
		$this->mailer->send($params);
			return true;
	}	
	
	function mail_booking($order_id){
		$data['order']	=	$order	=	$this->booking_model->get_order($order_id);
		$data['taxes']	=	$this->booking_model->get_taxes($order_id);
		$data['services']	=	$this->booking_model->get_services($order_id);
		$data['prices']		=	$this->booking_model->get_prices($order_id);

		$html = $this->load->view('bookings/mail', $data,true);
		
		$row	=	$this->booking_model->get_template(2);
		$row['subject'] = str_replace('{site_name}', $this->setting->name, $row['subject']);
		$row['content'] = str_replace('{customer_name}', $order->firstname, $row['content']);
		$row['content'] = str_replace('{site_name}', $this->setting->name, $row['content']);
		$row['content'] = str_replace('{order_summary}', $html, $row['content']);
		
		$msg 				 = html_entity_decode($row['content'],ENT_QUOTES, 'UTF-8');
		$params['recipient'] = $order->email;
		$params['subject'] 	 = $row['subject'];
		$params['message']   = $msg;
		$this->mailer->send($params);
		return true;
	}	
	
	function mail_room($order_id){
		$data['order']	=	$order	=	$this->booking_model->get_order($order_id);
		$data['taxes']	=	$this->booking_model->get_taxes($order_id);
		$data['services']	=	$this->booking_model->get_services($order_id);
		$data['prices']		=	$this->booking_model->get_prices($order_id);

		$html = $this->load->view('bookings/room_mail', $data,true);
		
		$row	=	$this->booking_model->get_template(3);
		$row['subject'] = str_replace('{site_name}', $this->setting->name, $row['subject']);
		$row['subject'] = str_replace('{booking_number}', $order->order_no, $row['subject']);
		$row['content'] = str_replace('{customer_name}', $order->firstname, $row['content']);
		$row['content'] = str_replace('{site_name}', $this->setting->name, $row['content']);
		$row['content'] = str_replace('{booking_number}', $order->order_no, $row['content']);
		$row['content'] = str_replace('{room_details}', $html, $row['content']);
		
		$msg 				 = html_entity_decode($row['content'],ENT_QUOTES, 'UTF-8');
		$params['recipient'] = $order->email;
		$params['subject'] 	 = $row['subject'];
		$params['message']   = $msg;
		$this->mailer->send($params);
		return true;
	}	
}