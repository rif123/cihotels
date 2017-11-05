<?php
	
	
	function check_availability($check_in,$check_out,$adults,$kids,$room_type_id){
					$query		=	'?date_from='.$check_in.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&room_type=';	
					$CI =& get_instance();
					if($check_in==$check_out){
						$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
					}
						
						
												$CI->db->where('id',1);
						$settings	=	$CI->db->get('settings')->row_array();
							
											$CI->db->where('id',$room_type_id);
											$CI->db->select('room_types.*,base_price as price');
						$room_type	=	$CI->db->get('room_types')->row_array();
						//echo '<pre>'; print_r($room_type);die;
						
											$CI->db->where('room_type_id',$room_type_id);
											$CI->db->select('rooms.*,count(room_no) as total_rooms');
						$rooms	  	=	$CI->db->get('rooms')->row_array();
						$total_rooms	=	$rooms['total_rooms'];
						//echo '<pre>'; print_r($rooms);die;
						$begin = new DateTime($check_in);
						$end = new DateTime($check_out);
						
						$interval = DateInterval::createFromDateString('1 day');
						$period = new DatePeriod($begin, $interval, $end);
					
						foreach($period as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							///echo $date;die;			
							//check for room block period
						
							if($date >= $settings['room_block_start_date'] && $date <=$settings['room_block_end_date'])
							{
								$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
								$CI->session->set_flashdata('error', $block_message);
								redirect('');
						
							}
											$CI->db->where('O.room_type_id',$room_type_id);
											$CI->db->where('R.date',$date);
											$CI->db->select('R.*,');
											$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
							$orders	  	=	$CI->db->get('rel_orders_prices R')->result_array();
							// echo '<pre>'; print_r($orders);die;
						
							if($total_rooms > 0){
								//echo count($orders);die;
								if(count($orders) >= $total_rooms){
									$CI->session->unset_userdata('booking_data');
									$CI->session->unset_userdata('coupon_data');
									$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");
									redirect('front/book/index'.$query);
								}else{
									continue;	// continue loop
								}
							}else{
									$CI->session->unset_userdata('booking_data');
									$CI->session->unset_userdata('coupon_data');
									$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");
									redirect('front/book/index'.$query);
							}
						}
					
						
		return;
	}
	

	function check_availability_admin($check_in,$check_out,$adults,$kids,$room_type_id){
		$query		=	'?date_from='.$check_in.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&room_type=';	
		$CI =& get_instance();
		if($check_in==$check_out){
			$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
		}
			
			
									$CI->db->where('id',1);
			$settings	=	$CI->db->get('settings')->row_array();
				
								$CI->db->where('id',$room_type_id);
								$CI->db->select('room_types.*,base_price as price');
			$room_type	=	$CI->db->get('room_types')->row_array();
			//echo '<pre>'; print_r($room_type);die;
			
								$CI->db->where('room_type_id',$room_type_id);
								$CI->db->select('rooms.*,count(room_no) as total_rooms');
			$rooms	  	=	$CI->db->get('rooms')->row_array();
			$total_rooms	=	$rooms['total_rooms'];
			//echo '<pre>'; print_r($rooms);die;
			$begin = new DateTime($check_in);
			$end = new DateTime($check_out);
			
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
		
			foreach($period as $dt){
				$date		=	 $dt->format( "Y-m-d" );	
				$dayno		=	 $dt->format( "N" );
				$day		=	 $dt->format( "D" );
				$day		=	strtolower($day);
				///echo $date;die;			
				//check for room block period
			
				if($date >= $settings['room_block_start_date'] && $date <=$settings['room_block_end_date'])
				{
					$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
					$CI->session->set_flashdata('error', $block_message);
					redirect('');
			
				}
								$CI->db->where('O.room_type_id',$room_type_id);
								$CI->db->where('R.date',$date);
								$CI->db->select('R.*,');
								$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
				$orders	  	=	$CI->db->get('rel_orders_prices R')->result_array();
				// echo '<pre>'; print_r($orders);die;
			
				if($total_rooms > 0){
					//echo count($orders);die;
					if(count($orders) >= $total_rooms){
						$CI->session->unset_userdata('booking_data');
						$CI->session->unset_userdata('coupon_data');
						$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");
						redirect('front/book/index'.$query);
					}else{
						continue;	// continue loop
					}
				}else{
						$CI->session->unset_userdata('booking_data');
						$CI->session->unset_userdata('coupon_data');
						$CI->session->set_flashdata('error', "Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room");
						redirect('front/book/index'.$query);
				}
			}
		
			
return;
}


	function check_availability_ajax($check_in,$check_out,$adults,$kids,$room_type_id){
					$query		=	'?date_from='.$check_in.'&date_to='.$check_out.'&adults='.$adults.'&kids='.$kids.'&room_type=';	
					$CI =& get_instance();
					if($check_in==$check_out){
						$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
					}
											$CI->db->where('id',1);
						$settings	=	$CI->db->get('settings')->row_array();



										$CI->db->where('id',$room_type_id);
										$CI->db->select('room_types.*,base_price as price');
						$room_type	=	$CI->db->get('room_types')->row_array();
					
						
											$CI->db->where('room_type_id',$room_type_id);
											$CI->db->select('rooms.*,count(room_no) as total_rooms');
						$rooms	  	=	$CI->db->get('rooms')->row_array();

						$total_rooms	=	$rooms['total_rooms'];
						
						$begin = new DateTime($check_in);
						$end = new DateTime($check_out);
						
						$interval = DateInterval::createFromDateString('1 day');
						$period = new DatePeriod($begin, $interval, $end);
						
						foreach($period as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
						
							if($date >= $settings['room_block_start_date'] && $date <= $settings['room_block_end_date'])
							{
								$block_message	=	"Sorry.. No Room Available Between ".date('d/m/Y',strtotime($settings['room_block_start_date']))." to ".date('d/m/Y',strtotime($settings['room_block_end_date']))."  ";
								return $block_message;								
						
							}
											$CI->db->where('O.room_type_id',$room_type_id);
											$CI->db->where('R.date',$date);
											$CI->db->select('R.*,');
											$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
						$orders	  	=	$CI->db->get('rel_orders_prices R')->result_array();
					
							if($total_rooms > 0){
								if(count($orders) > $total_rooms){
									echo '<pre>'; print_r($orders);die;
									$CI->session->unset_userdata('booking_data');
									$CI->session->unset_userdata('coupon_data');
									return 'Sorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
								}else{
									continue;	// continue loop
								}
							}else{
									$CI->session->unset_userdata('booking_data');
									$CI->session->unset_userdata('coupon_data');
									return 'asdfaSorry.. This Dates Between Rooms Not Available Please Try With Another Date Or Room';
							}
						}
						
		return 1;
	}
	
	
	
	function room_alot($check_in,$check_out,$room_type_id){
					//echo $check_in;echo $check_out;
					$CI =& get_instance();
					if($check_in==$check_out){
						$check_out	=	date('Y-m-d', strtotime($check_out.'+ 1 day'));
					}
					
											//$CI->CI->db->where("(status=1 OR status=3)", NULL, FALSE);
											$CI->db->where_in('O.status',array(1,0));	//for check booking status succes/pending
											$CI->db->where('O.room_type_id',$room_type_id);
											$CI->db->where('R.date >=',$check_in);
											$CI->db->where('R.date <',$check_out);
											$CI->db->select('R.*');
											$CI->db->join('orders O', 'O.id = R.order_id', 'LEFT');
											
						$orders	  		=	$CI->db->get('rel_orders_prices R')->result_array();
						//echo '<pre>'; print_r($orders);die;
						$rids	=	array();
						foreach($orders as $od){
							//echo $od['room_id'];
							if($od['room_id'] >  0){
								$rids[]	=	$od['room_id'];
							}
						}
						//echo '<pre>'; print_r($rids);die;
										if(!empty($rids)){
											$CI->db->where_not_in('R.id', $rids);
										}
										$CI->db->where('R.room_type_id',$room_type_id);
										$CI->db->select('R.*,F.name floor');
										$CI->db->join('floors F', 'F.id = R.floor_id', 'LEFT');
						$rooms	=		$CI->db->get('rooms R')->result();
						//echo '<pre>'; print_r($rooms);die;
						
							
		return $rooms;
	}				
	function checkUserLogin($value) {
		$CI =& get_instance();
		$user = $CI->session->userdata('front_user');
		if ($user['idCategory'] == 3 ) {
			return 0;
		} else {
			return $value;
		}
		
	}	
	function getGedungID($room_type_id) {
		$CI =& get_instance();
		$CI->db->where('R.room_type_id',$room_type_id);
		return $CI->db->get('rooms R')->result_array();

	}	
	
?>