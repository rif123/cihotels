<?php
class Book extends Front_Controller {
	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('homepage_model','book_model'));
		 $this->load->library('paypal_lib');
	}
	
	function index()
	{
		//check availbilty
		//get_invoice_number();
		$this->session->unset_userdata('booking_data');
		$this->session->unset_userdata('coupon_data');
		$data['page_title']			= lang('make_reservation');
		$data['meta_description']	= $this->setting->meta_description;
		$data['meta_keywords']		= $this->setting->meta_keywords;	
		$data['banners']			= $this->homepage_model->get_banners();
		$data['testimonials']		= $this->homepage_model->get_testimonials();	// get 6 testimonials
		$data['room_types']			= $this->homepage_model->get_room_types_all();
		$data['taxes']				= $this->homepage_model->get_taxes();
		if(!empty($_GET['room_type'])){
			$data['services']			= $this->homepage_model->get_paid_services($_GET['room_type']);
		}
		//echo '<pre>'; print_r($data['services']);
		if(empty($_GET['room_type'])){
			$this->render('book/room_types', $data);		
		}else{
			check_availability($_GET['date_from'],$_GET['date_to'],$_GET['adults'],"",$_GET['room_type']);	
			$data['room_type']		= $this->homepage_model->get_room_type($_GET['room_type']);
			$this->render('book/view', $data);		
		}

		
		
	}
	
	function step1(){
		
		// //check for availbility
			//echo get_cart_total();die;
		
			//echo '<pre>'; print_r($_SESSION);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('date_from', 'lang:chek_in', 'required');
			$this->form_validation->set_rules('date_to', 'lang:check_out', 'required');
			$this->form_validation->set_rules('adults', 'lang:adults', 'required');
			$this->form_validation->set_rules('room_type', 'lang:room_type', 'required');
			if ($this->form_validation->run() == true)
			{
				
				$room_type	=	$this->homepage_model->get_room_type($_POST['room_type']);
				$sess_curruncy = $this->session->userdata('currency');	
				if(!empty($sess_curruncy)){
					$currency = $this->session->userdata('currency');
				}else{
					$currency = $this->setting->currency_code;
				}
				//	echo $currency;die;
				$paid_services	=	$this->input->post('paid_services');	
				$room_type		= $this->homepage_model->get_room_type($_POST['room_type']);
				$nights	=	GetDays($_POST['date_from'],$_POST['date_to'])-1;	
				if($nights==0){
				$nights=1;
				}
				$base_price	=	get_price($_POST['date_from'],$_POST['date_to'],$_POST['room_type'],$_POST['adults'],"");
				$amount		=	$base_price['total_price'];
				//$amount	=	$room_type->base_price * $_POST['adults'] * $nights;		//oLd
				$taxamount	=	get_tax_amount($amount);
				$total		=	$amount+$taxamount;
				if(!empty($paid_services)){
					$booking_data['paid_service_amount']		=	get_paid_service_amount_all($paid_services,$_POST['adults'],$nights);
					$total	=	$total+$booking_data['paid_service_amount'];
				}	 
				$getGedung = getGedungID($this->input->post('room_type'));
				$booking_data['order_no']		=	time().$this->front_user['id'];
				$booking_data['check_in']		=	$this->input->post('date_from');
				$booking_data['check_out']		=	$this->input->post('date_to');
				$booking_data['guest_id']		=	$this->front_user['id'];
				$booking_data['adults']			=	$this->input->post('adults');
				$booking_data['room_type_id']	=	$this->input->post('room_type');
				$booking_data['idGedung']	=	!empty($getGedung[0]['idGedung']) ? $getGedung[0]['idGedung'] : "" ;
				$booking_data['ordered_on']		=	date('Y-m-d H:i:s');
				$booking_data['base_price']		=	checkUserLogin($room_type->base_price);
				$booking_data['additional_person_amount']		=	$base_price['additional_person_amount'];
				$booking_data['additional_person']		=	$base_price['additional_person'];
				$booking_data['amount']			=	checkUserLogin(round($amount,2));
				$booking_data['taxamount']		=	round($taxamount,2);
				$booking_data['totalamount']	=	checkUserLogin(round($total,2));
				$booking_data['nights']			=	$nights;
				$booking_data['currency']		=	$currency;
				$booking_data['currency_unit']	=	get_currency_unit();
				$booking_data['paid_services']	=	$paid_services;
				$booking_data['room_type']		=	$room_type->title;
				$booking_data['base_price_details']		=	$base_price;
				$this->session->set_userdata('booking_data',$booking_data);
				$this->session->set_flashdata('message', "Your Booking Saved Successfully");
				redirect('front/book/payment');			
			}else{
				$this->session->unset_userdata('booking_data');
				$this->session->set_flashdata('error', "Something Went Wrong Try Again..!");
				redirect('');
			}
	}
	function payment(){
		// echo '<pre>'; print_r($this->session->userdata('booking_data'));die;
		//echo '<pre>'; print_r($this->session->all_userdata());die;
		if ($this->input->server('REQUEST_METHOD') === 'POST')
        {	
			//echo '<pre>'; print_r($_POST);;die;
			$coupon_apply	=	$this->input->post('coupon_apply');
			$coupon	=	strtolower($this->input->post('coupon'));
			if(!empty($coupon_apply))
			{
				if(!empty($coupon))
				{
					apply_coupon($coupon);	
				}
			}
			$pay	=	strtolower($this->input->post('pay'));
			if(!empty($pay))
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('payment_gateway', 'lang:payment_method', 'required');
				if ($this->form_validation->run() == true)
				{
					$sess_curruncy = $this->session->userdata('currency');
					if(!empty($sess_curruncy)){
						$currency = $this->session->userdata('currency');
					}else{
						$currency = $this->setting->currency_code;
					}
					$coupon_data	=	$this->session->userdata('coupon_data');
					$booking_data	=	$this->session->userdata('booking_data');
					$user	=	$this->session->userdata('front_user');
					
					//echo '<pre>->1'; print_r($this->session->userdata('coupon_data'));
					//echo '<pre>->2'; print_r($this->session->userdata('booking_data'));die;
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
					$save['room_type_id']	=	$booking_data['room_type_id'];
					
					$save['idBuilding']	=	$booking_data['idGedung'];
					$save['idCategory']	=	$user['idCategory'];

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
					
					if($_POST['payment_gateway']!=3){	// if pay on arrival then we will not save advance payment
						$save['advance_amount']	=	get_advance();
					}
					//echo '<pre>-->3'; print_r($save);die;
					
					$paid_services	=	@$booking_data['paid_services'];
					
					$p_key	=	$this->book_model->save_order($save);
						//Save Payment
						
					$save['room_type']			=	@$booking_data['room_type'];
					$save['order_id']			=	$p_key;
					$save['payment_gateway']	=	$_POST['payment_gateway'];
					$save['price_details']		=	$booking_data['base_price_details']['price_details'];
					//Unset Session 
					$this->session->unset_userdata('booking_data');
					$this->session->unset_userdata('coupon_data');
					
					$this->session->set_userdata('booking_data',$save);//set session
					
					$taxes			= $this->homepage_model->get_taxes();
					//echo '<pre>-->3'; print_r($taxes);die;
							
							$i=1;
							foreach($taxes as $t){
								$save_tax[$i]['order_id']	= $p_key;;	
								$save_tax[$i]['tax_id']		= $t->id;	
								$save_tax[$i]['amount']		= get_tax_amount_by_tax($t->id,$save['amount']);	
							$i++;
							}
							if(!empty($save_tax)){
								$this->book_model->save_taxes($save_tax);
							}
										
							if(!empty($paid_services)){
								$i=0;
								foreach($paid_services as $new){
									$save_service[$i]['order_id']		= $p_key;;	
									$save_service[$i]['service_id']		= $new;	
									$save_service[$i]['amount']			= get_paid_service_amount($new,$save['adults'],$save['nights']);
								$i++;
								}
								$this->book_model->save_service($save_service);
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
								$this->book_model->save_price($save_price);
							}
									
					//echo '<pre>'; print_r($this->session->userdata('booking_data'));die;
					redirect('front/book/pay');
				}// End Form Validation
			}
		}
		$data['booking']		=	$this->session->userdata('booking_data');
		$data['coupon_data']	=	$this->session->userdata('coupon_data');
		$data['page_title']	=	lang('payment');
		$data['meta_description']	=	$this->setting->meta_description;
		$data['meta_keywords']		=	$this->setting->meta_keywords;	
		$this->render('book/payment', $data);
	}	
	
	function pay(){
		
				$booking_data	=	$this->session->userdata('booking_data');
				//echo '<pre>'; print_r($booking_data);die;	
				if($booking_data['payment_gateway']==1){
					redirect('front/book/paypal');
				}
				if($booking_data['payment_gateway']==2){
					redirect('front/book/stripe');
				}
				if($booking_data['payment_gateway']==3){	// Pay On Arrival
					$id											=	$booking_data['order_id'];
					$save['payment_status']						=	2;
					$save['payment_gateway_status']				=	NULL;
					$save['payment_gateway_name']				=	lang('pay_on_arrival');
					$save['txn_id']								=	NULL;
					
					$this->book_model->update_order($save,$id);
					$this->mail_booking($booking_data['order_id']);
					$this->session->set_flashdata('message', "Your Booking Payment Success");
					redirect('front/book/order');
				}
				//Set variables for paypal form
				$returnURL = site_url().'/front/book/success'; //payment success url
				$cancelURL = site_url().'/front/book/cancel'; //payment cancel url
				$notifyURL = site_url().'/front/book/ipn'; //ipn url
				//get particular product data
				$userID = 1; //current user id
				$logo = base_url().'assets/admin/uploads/images/'.$this->setting->logo;
				
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('item_name', $booking_data['room_type']);
				$this->paypal_lib->add_field('custom', $booking_data['guest_id']);
				$this->paypal_lib->add_field('item_number', $booking_data['order_no']);
				$this->paypal_lib->add_field('amount',  $booking_data['totalamount']);
				//$this->paypal_lib->add_field('currency_code',  "INR");        
				$this->paypal_lib->image($logo);
				
				$this->paypal_lib->paypal_auto_form();
	}
	
	function paypal(){
		
				$data['booking_data']	=	$booking_data	=	$this->session->userdata('booking_data');
				//echo $booking_data['totalamount'];die;
				//Set variables for paypal form
				$returnURL = site_url().'/front/book/success'; //payment success url
				$cancelURL = site_url().'/front/book/cancel'; //payment cancel url
				$notifyURL = site_url().'/front/book/ipn'; //ipn url
				//get particular product data
				$userID = 1; //current user id
				$logo = base_url().'assets/admin/uploads/images/'.$this->setting->logo;
				
				$this->paypal_lib->add_field('return', $returnURL);
				$this->paypal_lib->add_field('cancel_return', $cancelURL);
				$this->paypal_lib->add_field('notify_url', $notifyURL);
				$this->paypal_lib->add_field('item_name', $booking_data['room_type']);
				$this->paypal_lib->add_field('custom', $booking_data['guest_id']);
				$this->paypal_lib->add_field('item_number', $booking_data['order_no']);
				$this->paypal_lib->add_field('amount',  getUsd($booking_data['advance_amount']));
				//$this->paypal_lib->add_field('currency_code',  "INR");        
				$this->paypal_lib->image($logo);
				
				$this->paypal_lib->paypal_auto_form();
	}
	
	function stripe(){
		//echo '<pre>'; print_r($this->session->all_userdata());die;
			$data['booking_data']	=		$booking_data	=	$this->session->userdata('booking_data');
				//echo '<pre>'; print_r($booking_data);die;	
			if ($this->input->server('REQUEST_METHOD') === 'POST')
        	{
				try {
					require_once APPPATH. '/third_party/Stripe/lib/Stripe.php';
					//require_once('Stripe/lib/Stripe.php');
					Stripe::setApiKey($this->setting->stripe_api_key);
				
					$charge = Stripe_Charge::create(array(
								  "amount" => rate_exchange($booking_data['advance_amount'])*100,//$booking_data['order_no']*100,
								  "currency" => $booking_data['currency'],
								  "card" => @$_POST['stripeToken'],
								  "description" => "Order Number ".$booking_data['order_no']." Booking For Room ".$booking_data['room_type']
								));
					//send the file, this line will be reached if no error was thrown above
				
				
					
				  //you can send the file to this email:
					
				  //echo $_POST['stripeEmail'];
				  ///echo '<pre>-->1'; print_r($_POST);
				  //echo '<pre>-->2'; print_r($_REQUEST);die;
				  //die;
				}
				
				catch(Stripe_CardError $e) {
					
				}
				//catch the errors in any way you like
				
				 catch (Stripe_InvalidRequestError $e) {
				  // Invalid parameters were supplied to Stripe's API
				  $this->session->set_flashdata('error', "Your Payment Not Succes");
					redirect('');

				
				} catch (Stripe_AuthenticationError $e) {
				  // Authentication with Stripe's API failed
				  // (maybe you changed API keys recently)
				
					$this->session->set_flashdata('error', "Your Payment Not Succes");
					redirect('');

				} catch (Stripe_ApiConnectionError $e) {
				  // Network communication with Stripe failed
					$this->session->set_flashdata('error', "Your Payment Not Succes");
					redirect('');

				} catch (Stripe_Error $e) {
				
				  // Display a very generic error to the user, and maybe send
				  // yourself an email
					$this->session->set_flashdata('error', "Your Payment Not Succes");
					redirect('');

				} catch (Exception $e) {
				
					$this->session->set_flashdata('error', "Your Payment Not Succes");
					redirect('');
				  // Something else happened, completely unrelated to Stripe
				}
				
				//echo '<pre>'; print_r($_REQUEST);die;
					$id											=	$booking_data['order_id'];
					$save['payment_status']						=	3;	//partialy_paid
					$save['status']								=	1;
					$save['payment_gateway_status']				=	$_REQUEST['stripeEmail'];
					$save['payment_gateway_name']				=	"Stripe";
					$save['txn_id']								=	$_REQUEST['stripeToken'];
					
					$this->book_model->update_order($save,$id);
					$data['order']	=	$this->book_model->get_order($booking_data['order_id']);
							
						$save_payment['order_id']		=	$id;
						$save_payment['date_time']		=	date('Y-m-d H:i:s');
						$save_payment['added_date']		=	date('Y-m-d H:i:s');
						$save_payment['amount']			=	$data['order']->advance_amount;
						$save_payment['invoice']		=	get_invoice_number();
						$save_payment['is_main_amount']	=	1;
						$save_payment['payment_method']	=	'Stripe';
						$this->book_model->save_payment($save_payment);
					$this->mail_booking($booking_data['order_id']);	
					$this->session->set_flashdata('message', "Your Booking Payment Success");
					redirect('front/book/order');
			}
			$data['page_title']	=	lang('payment');
			$this->render('book/stripe', $data);	
	}
	
	function success(){
		//echo '<pre>'; print_r($_REQUEST);
		$booking_data	=	$this->session->userdata('booking_data');
		
		
		$id									=	$booking_data['order_id'];
		$save['payment_status']						=	3;	//partialy_paid
		$save['status']								=	1;
		$save['payment_gateway_status']				=	$_REQUEST['payment_status'];
		$save['payment_gateway_name']				=	"Paypal";
		$save['txn_id']								=	$_REQUEST['txn_id'];
		
		$this->book_model->update_order($save,$id);
		$data['order']	=	$this->book_model->get_order($booking_data['order_id']);
		
		$save_payment['order_id']		=	$id;
		$save_payment['date_time']		=	date('Y-m-d H:i:s');
		$save_payment['added_date']		=	date('Y-m-d H:i:s');
		$save_payment['amount']			=	$data['order']->advance_amount;
		$save_payment['invoice']		=	get_invoice_number();
		$save_payment['is_main_amount']	=	1;
		$save_payment['payment_method']	=	'Stripe';
		$this->book_model->save_payment($save_payment);
		$this->mail_booking($booking_data['order_id']);
		$this->session->set_flashdata('message', "Your Booking Payment Success");
		redirect('front/book/order');		
		//echo '<pre>'; print_r($save);die;
	}
	
	function cancel(){
		//echo '<pre>'; print_r($_REQUEST);die;
		
		$this->session->unset_userdata('booking_data');
		$this->session->unset_userdata('coupon_data');
		$this->session->set_flashdata('error', "Your Booking Has Been Canceled Due To Payment");
		redirect('');
	}
	function ipn(){
		echo '<pre>'; print_r($_REQUEST);die;
	}
	
	function order(){
		//echo '<pre>'; print_r($this->session->all_userdata());die;
		$booking_data	=	$this->session->userdata('booking_data');
		if(!empty($booking_data)){
			$data['order']	=	$this->book_model->get_order($booking_data['order_id']);
			$data['taxes']	=	$this->book_model->get_taxes($booking_data['order_id']);
			$data['services']	=	$this->book_model->get_services($booking_data['order_id']);
			$data['prices']	=	$this->book_model->get_prices($booking_data['order_id']);
			$this->session->unset_userdata('booking_data');
			$this->session->unset_userdata('coupon_data');
			$data['page_title']	=	lang('order');
			$this->render('book/order', $data);
		}else{
			redirect('front/account/bookings');
		}
	}
	
	function pdf($id){
		$this->load->helper('dompdf_helper');
		$this->load->helper('download');
		
		$data['order']	=	$this->book_model->get_order($id);
		$data['taxes']	=	$this->book_model->get_taxes($id);
		$data['services']	=	$this->book_model->get_services($id);
		$data['prices']	=	$this->book_model->get_prices($id);
		//echo '<pre>'; print_r($data['taxes']);die;
		$html = $this->load->view('book/pdf', $data,true);		
		pdf_create($html, 'Order_'.$data['order']->order_no);
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
	
	function mail_booking($order_id){
		$data['order']	=	$order	=	$this->book_model->get_order($order_id);
		$data['taxes']	=	$this->book_model->get_taxes($order_id);
		$data['services']	=	$this->book_model->get_services($order_id);
		$data['prices']	=	$this->book_model->get_prices($order_id);
		$html = $this->load->view('book/mail', $data,true);
		
		$row	=	$this->homepage_model->get_template(2);
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
	
}