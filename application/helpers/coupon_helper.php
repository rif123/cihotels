<?php
		function apply_coupon($code)
		{	
			$CI =& get_instance();
			
			$CI->session->unset_userdata('coupon_data');	//unset old coupons data
			
			$front_user	=	$CI->session->userdata('front_user');
			$booking_data	=	$CI->session->userdata('booking_data');
			$paid_service_applied	=	0;
			
			$pdservices				= 	array();
			
								$CI->db->where('code',$code);
								$CI->db->where('date_from <=',date('Y-m-d H:i:s'));
								$CI->db->where('date_to >=',date('Y-m-d H:i:s'));
			$result	=	$CI->db->get('coupons')->row();	
					if(empty($result)){
						$CI->session->set_flashdata('error', "Coupon Is Invalid.");
						redirect('front/book/payment');
					}
				
					$include_user	=	json_decode($result->include_user);
					$exclude_user	=	json_decode($result->exclude_user);
					
					$include_room_type	=	json_decode($result->include_room_type);
					$exclude_room_type	=	json_decode($result->exclude_room_type);
					
					$paid_services		=	json_decode($result->paid_services);
					
					//echo '<pre>--->1'; print_r($booking_data);
					//echo '<pre>--->2'; print_r($exclude_user);
					//echo '<pre>--->3'; print_r($result);die;
					if(!empty($result)){	//Date Validate
						$next	=	1;
					}else{
						//expired
						$next	=	0;
						$CI->session->set_flashdata('error', "This Coupon Code Is Expired");
						redirect('front/book/payment');
					}
					if($next==1){
						if($booking_data['totalamount']	<	$result->min_amount){
							$CI->session->set_flashdata('error', "This Coupon Code Is Eligible For Minimum Amount ".rate_exchange($result->min_amount));
							redirect('front/book/payment');
						}
					}
					if($next==1){ //check include user/exclude user
						if(empty($include_user) && empty($exclude_user)){
							$next = 1;
						}else{
								if(!empty($include_user)){
									if(in_array($front_user['id'],$include_user)){	// check include user if yes then eligible
										$next	=	1;
									}
								}
								if(!empty($exclude_user)){
									if(in_array($front_user['id'],$exclude_user)){	// check exclude user if yes then not eligible
										$next	=	0;
										$CI->session->set_flashdata('error', "You Are Not Eligible For This Coupon Code.");
										redirect('front/book/payment');
									}
								}	
						}
					}
					if($next==1){	// check include /exclude room type
							if(empty($include_room_type) && empty($exclude_room_type)){
								$next = 1;
							}else{
									if(!empty($include_room_type)){
										if(in_array($booking_data['room_type_id'],$include_room_type)){	// check include room type if yes then eligible
											$next	=	1;
										}
									}
									if(!empty($exclude_room_type)){
										if(in_array($booking_data['room_type_id'],$exclude_room_type)){	// check exclude include room type if yes then not eligible
											$next	=	0;
											$CI->session->set_flashdata('error', "This Coupon Is Not Eligible For This Room.");
											redirect('front/book/payment');
										}
									}
							}
					}
					if($next==1){	//limit per user
										$CI->db->where('coupon',$code);
										$CI->db->where('guest_id',$front_user['id']);
							$orders		=	$CI->db->get('orders')->result();	
							
							if(count($orders) > $result->limit_per_user){
								$next	=	0;
								$CI->session->set_flashdata('error', "This Coupon Code Is Sold Out.");
								redirect('front/book/payment');
							}else{
								$next	=	1;
							}		
					}
					if($next==1){	//limit per coupon
										$CI->db->where('coupon',$code);
							$orders		=	$CI->db->get('orders')->result();	
							
							if(count($orders) > $result->limit_per_coupon){
								$next	=	0;
								$CI->session->set_flashdata('error', "This Coupon Code Is Sold Out.");
								redirect('front/book/payment');
							}else{
								$next	=	1;
							}		
					}
					
					if($next==1){	//Paid Services
						
						//echo '<pre>'; print_r($booking_data);die;
						if(!empty($paid_services)){
							if(!empty($booking_data['paid_services'])){
								$next	=	1;
								$paid_service_applied	=	1;
								
									foreach($booking_data['paid_services'] as $new){
										if(in_array($new,$paid_services)){
											$pdservices[]	= $new;
										}		
									}
									/*if(empty($pdservices)){
										$CI->session->set_flashdata('error', "This Coupon Code Is Not Eligible On  Your Selected Paid Services.");
										redirect('front/book/payment');
									}*/
							}
							/*else{
								$next	=	0;
								$CI->session->set_flashdata('error', "This Coupon Code Is Only Eligible On Paid Services.");
								redirect('front/book/payment');
							}*/
						}
					}
					if($next==1){	//coupon value less in main amount 
						$servicesless	=	0;
						if($paid_service_applied==1){	//paid service will be free
								$pdservices;
								if(!empty($pdservices)){
									$CI->db->where_in('id',$pdservices);
									$CI->db->select('services.*,GROUP_CONCAT(title) as titles');
									$CI->db->select('SUM(price) as total');
									$services	=	$CI->db->get('services')->row();	
								//echo '<pre>'; print_r($services);die;					
								
									$servicesless 	+=	$services->total;
								}
						}
						$less	=	0;
						
						if($result->type=='Percentage'){
							$less	+=	$result->value/100*$booking_data['totalamount'];
						}
						if($result->type=='Fixed'){
							$less	+=	$result->value;
						}
						$amount	=	$booking_data['totalamount']	-	$less;	// less coupon
						$amount	=	$amount-$servicesless;		// less free services price
						if($amount	< 0){
							$amount	=	0;
						}
						$coupon_data	=	array(
											'active'						=> 1,
											'code'							=>	$code,
											'totalamount'					=>	$amount,
											'discount'						=>	$less,
											'paid_service_applied'			=>	$pdservices,
											'services'						=>	@$services->titles,
											'services_total'				=>	@$services->total,
										);
						$CI->session->set_userdata('coupon_data',$coupon_data);				
						$CI->session->set_flashdata('message', "Coupon Applied.");
						redirect('front/book/payment');
					}
					
						//echo '<pre>'; print_r($result);die;		
			return;
		}		
		
		
		function apply_coupon_ajax($code,$guest_id)
		{	
			$CI =& get_instance();
			
			$CI->session->unset_userdata('coupon_data');	//unset old coupons data
			
			$front_user	=	$CI->session->userdata('front_user');
			$booking_data	=	$CI->session->userdata('booking_data');
			$paid_service_applied	=	0;
			
			$pdservices				= 	array();
			
								$CI->db->where('code',$code);
								$CI->db->where('date_from <=',date('Y-m-d H:i:s'));
								$CI->db->where('date_to >=',date('Y-m-d H:i:s'));
			$result	=	$CI->db->get('coupons')->row();	
					if(empty($result)){
						return "Coupon Is Invalid.";
					}
				
					$include_user	=	json_decode($result->include_user);
					$exclude_user	=	json_decode($result->exclude_user);
					
					$include_room_type	=	json_decode($result->include_room_type);
					$exclude_room_type	=	json_decode($result->exclude_room_type);
					
					$paid_services		=	json_decode($result->paid_services);
					
					//echo '<pre>--->1'; print_r($booking_data);
					//echo '<pre>--->2'; print_r($exclude_user);
					//echo '<pre>--->3'; print_r($result);die;
					if(!empty($result)){	//Date Validate
						$next	=	1;
					}else{
						//expired
						$next	=	0;
						return "This Coupon Code Is Expired";
					}
					if($next==1){
						if(round($_POST['total'],2)	<	$result->min_amount){
							return "This Coupon Code Is Eligible For Minimum Amount ".rate_exchange($result->min_amount);
						}
					}
					if($next==1){ //check include user/exclude user
						if(empty($include_user) && empty($exclude_user)){
							$next = 1;
						}else{
								if(!empty($include_user)){
									if(in_array($guest_id,$include_user)){	// check include user if yes then eligible
										$next	=	1;
									}
								}
								if(!empty($exclude_user)){
									if(in_array($guest_id,$exclude_user)){	// check exclude user if yes then not eligible
										$next	=	0;
										return "You Are Not Eligible For This Coupon Code.";
									}
								}	
						}
					}
					if($next==1){	// check include /exclude room type
							if(empty($include_room_type) && empty($exclude_room_type)){
								$next = 1;
							}else{
									if(!empty($include_room_type)){
										if(in_array($_POST['room_type_id'],$include_room_type)){	// check include room type if yes then eligible
											$next	=	1;
										}
									}
									if(!empty($exclude_room_type)){
										if(in_array($_POST['room_type_id'],$exclude_room_type)){	// check exclude include room type if yes then not eligible
											$next	=	0;
											return "This Coupon Is Not Eligible For This Room.";
										}
									}
							}
					}
					if($next==1){	//limit per user
										$CI->db->where('coupon',$code);
										$CI->db->where('guest_id',$guest_id);
							$orders		=	$CI->db->get('orders')->result();	
							
							if(count($orders) > $result->limit_per_user){
								$next	=	0;
								return "This Coupon Code Is Sold Out.";
							}else{
								$next	=	1;
							}		
					}
					if($next==1){	//limit per coupon
										$CI->db->where('coupon',$code);
							$orders		=	$CI->db->get('orders')->result();	
							
							if(count($orders) > $result->limit_per_coupon){
								$next	=	0;
								return "This Coupon Code Is Sold Out.";
							}else{
								$next	=	1;
							}		
					}
					
					if($next==1){	//Paid Services
						
						//echo '<pre>'; print_r($booking_data);die;
						if(!empty($paid_services)){
							if(!empty($_POST['paid_services'])){
								$next	=	1;
								$paid_service_applied	=	1;
								
									foreach($_POST['paid_services'] as $new){
										if(in_array($new,$paid_services)){
											$pdservices[]	= $new;
										}		
									}
									/*if(empty($pdservices)){
										$CI->session->set_flashdata('error', "This Coupon Code Is Not Eligible On  Your Selected Paid Services.");
										redirect('front/book/payment');
									}*/
							}
							/*else{
								$next	=	0;
								$CI->session->set_flashdata('error', "This Coupon Code Is Only Eligible On Paid Services.");
								redirect('front/book/payment');
							}*/
						}
					}
					if($next==1){	//coupon value less in main amount 
						$servicesless	=	0;
						if($paid_service_applied==1){	//paid service will be free
								$pdservices;
								if(!empty($pdservices)){
									$CI->db->where_in('id',$pdservices);
									$CI->db->select('services.*,GROUP_CONCAT(title) as titles');
									$CI->db->select('SUM(price) as total');
									$services	=	$CI->db->get('services')->row();	
								//echo '<pre>'; print_r($services);die;					
								
									$servicesless 	+=	$services->total;
								}
						}
						$less	=	0;
						
						if($result->type=='Percentage'){
							$less	+=	$result->value/100*round($_POST['total'],2);
						}
						if($result->type=='Fixed'){
							$less	+=	$result->value;
						}
						$amount	=	round($_POST['total'],2)	-	$less;	// less coupon
						$amount	=	$amount-$servicesless;		// less free services price
						if($amount	< 0){
							$amount	=	0;
						}
						$coupon_data	=	array(
											'active'						=> 1,
											'code'							=>	$code,
											'totalamount'					=>	$amount,
											'discount'						=>	$less,
											'paid_service_applied'			=>	$pdservices,
											'services'						=>	@$services->titles,
											'services_total'				=>	@$services->total,
										);
						$CI->session->set_userdata('coupon_data',$coupon_data);				
						return 1;
						
					}
					
						//echo '<pre>'; print_r($result);die;		
			return;
		}
		
		
		function apply_coupon_admin_booking($code)
		{	
			$CI =& get_instance();
			
			$CI->session->unset_userdata('coupon_data');	//unset old coupons data
			
			$booking_data	=	$CI->session->userdata('booking_data');
			//echo '<pre>'; print_r($booking_data);die;
			$paid_service_applied	=	0;
			
			$pdservices				= 	array();
			
								$CI->db->where('code',$code);
								$CI->db->where('date_from <=',date('Y-m-d H:i:s'));
								$CI->db->where('date_to >=',date('Y-m-d H:i:s'));
			$result	=	$CI->db->get('coupons')->row();	
					if(empty($result)){
						$CI->session->set_flashdata('error', "Coupon Is Invalid.");
						redirect('admin/bookings/save');
					}
				
					$include_user	=	json_decode($result->include_user);
					$exclude_user	=	json_decode($result->exclude_user);
					
					$include_room_type	=	json_decode($result->include_room_type);
					$exclude_room_type	=	json_decode($result->exclude_room_type);
					
					$paid_services		=	json_decode($result->paid_services);
					
					//echo '<pre>--->1'; print_r($booking_data);
					//echo '<pre>--->2'; print_r($exclude_user);
					//echo '<pre>--->3'; print_r($result);die;
					if(!empty($result)){	//Date Validate
						$next	=	1;
					}else{
						//expired
						$next	=	0;
						$CI->session->set_flashdata('error', "This Coupon Code Is Expired");
						redirect('admin/bookings/save');
					}
					if($next==1){
						if($booking_data['totalamount']	<	$result->min_amount){
							$CI->session->set_flashdata('error', "This Coupon Code Is Eligible For Minimum Amount ".rate_exchange($result->min_amount));
							redirect('admin/bookings/save');
						}
					}
					if($next==1){ //check include user/exclude user
						if(empty($include_user) && empty($exclude_user)){
							$next = 1;
						}else{
								if(!empty($include_user)){
									if(in_array($booking_data['guest_id'],$include_user)){	// check include user if yes then eligible
										$next	=	1;
									}
								}
								if(!empty($exclude_user)){
									if(in_array($booking_data['guest_id'],$exclude_user)){	// check exclude user if yes then not eligible
										$next	=	0;
										$CI->session->set_flashdata('error', "You Are Not Eligible For This Coupon Code.");
										redirect('admin/bookings/save');
									}
								}	
						}
					}
					if($next==1){	// check include /exclude room type
							if(empty($include_room_type) && empty($exclude_room_type)){
								$next = 1;
							}else{
									if(!empty($include_room_type)){
										if(in_array($booking_data['room_type_id'],$include_room_type)){	// check include room type if yes then eligible
											$next	=	1;
										}
									}
									if(!empty($exclude_room_type)){
										if(in_array($booking_data['room_type_id'],$exclude_room_type)){	// check exclude include room type if yes then not eligible
											$next	=	0;
											$CI->session->set_flashdata('error', "This Coupon Is Not Eligible For This Room.");
											redirect('admin/bookings/save');
										}
									}
							}
					}
					if($next==1){	//limit per user
										$CI->db->where('coupon',$code);
										$CI->db->where('guest_id',$booking_data['guest_id']);
							$orders		=	$CI->db->get('orders')->result();	
							
							if(count($orders) > $result->limit_per_user){
								$next	=	0;
								$CI->session->set_flashdata('error', "This Coupon Code Is Sold Out.");
								redirect('admin/bookings/save');
							}else{
								$next	=	1;
							}		
					}
					if($next==1){	//limit per coupon
										$CI->db->where('coupon',$code);
							$orders		=	$CI->db->get('orders')->result();	
							
							if(count($orders) > $result->limit_per_coupon){
								$next	=	0;
								$CI->session->set_flashdata('error', "This Coupon Code Is Sold Out.");
								redirect('admin/bookings/save');
							}else{
								$next	=	1;
							}		
					}
					
					if($next==1){	//Paid Services
						
						//echo '<pre>'; print_r($booking_data);die;
						if(!empty($paid_services)){
							if(!empty($booking_data['paid_services'])){
								$next	=	1;
								$paid_service_applied	=	1;
								
									foreach($booking_data['paid_services'] as $new){
										if(in_array($new,$paid_services)){
											$pdservices[]	= $new;
										}		
									}
									/*if(empty($pdservices)){
										$CI->session->set_flashdata('error', "This Coupon Code Is Not Eligible On  Your Selected Paid Services.");
										redirect('front/book/payment');
									}*/
							}
							/*else{
								$next	=	0;
								$CI->session->set_flashdata('error', "This Coupon Code Is Only Eligible On Paid Services.");
								redirect('front/book/payment');
							}*/
						}
					}
					if($next==1){	//coupon value less in main amount 
						$servicesless	=	0;
						if($paid_service_applied==1){	//paid service will be free
								$pdservices;
								if(!empty($pdservices)){
									$CI->db->where_in('id',$pdservices);
									$CI->db->select('services.*,GROUP_CONCAT(title) as titles');
									$CI->db->select('SUM(price) as total');
									$services	=	$CI->db->get('services')->row();	
								//echo '<pre>'; print_r($services);die;					
								
									$servicesless 	+=	$services->total;
								}
						}
						$less	=	0;
						
						if($result->type=='Percentage'){
							$less	+=	$result->value/100*$booking_data['totalamount'];
						}
						if($result->type=='Fixed'){
							$less	+=	$result->value;
						}
						$amount	=	$booking_data['totalamount']	-	$less;	// less coupon
						$amount	=	$amount-$servicesless;		// less free services price
						if($amount	< 0){
							$amount	=	0;
						}
						$coupon_data	=	array(
											'active'						=> 1,
											'code'							=>	$code,
											'totalamount'					=>	$amount,
											'discount'						=>	$less,
											'paid_service_applied'			=>	$pdservices,
											'services'						=>	@$services->titles,
											'services_total'				=>	@$services->total,
										);
						$CI->session->set_userdata('coupon_data',$coupon_data);				
						$CI->session->set_flashdata('message', "Coupon Applied.");
						redirect('admin/bookings/save');
					}
					
						//echo '<pre>'; print_r($result);die;		
			return;
		}		
		
		
			
?>