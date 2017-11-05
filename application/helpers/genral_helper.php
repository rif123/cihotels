<?php
	
	function get_front_user(){
		 $CI =& get_instance();
		return  $front_admin	=	$CI->session->userdata('front_user');
					
	}
	
	function get_tax_amount($amount){
				$CI =& get_instance();
					   	 $CI->db->where('id', 1);	
		$setting	=	 $CI->db->get('settings')->row();
		$tids		=	json_decode($setting->taxes);
			if(empty($tids)){
				return false;
			}else{	
							$CI->db->where_in('id', $tids);	
				$taxes	=	$CI->db->get('taxes')->result();
				$taxamount	=	0;
				foreach($taxes as $tx){
					if($tx->type=='Percentage'){
						$taxamount	+=	$tx->rate/100*$amount;
					}
					if($tx->type=='Fixed'){
						$taxamount	+=	$tx->rate;
					}
				}
				return $taxamount;
			}
	}
	function get_tax_amount_by_tax($id,$amount){
				$CI =& get_instance();
					
					$CI->db->where('id',$id);
			$tx	=	$CI->db->get('taxes')->row();
			$taxamount	=	0;
				if($tx->type=='Percentage'){
					$taxamount	+=	$tx->rate/100*$amount;
				}
				if($tx->type=='Fixed'){
					$taxamount	+=	$tx->rate;
				}
			
		return $taxamount;
			
	}
		
	function get_setting(){
					$CI =& get_instance();
		 			$CI->db->where('S.id',1);
					$CI->db->select('S.*,C.currency_code,C.currrency_symbol currency_symbol');
					$CI->db->join('currency C', 'C.id = S.currency', 'LEFT');
			return 	$CI->db->get('settings S')->row();	
	}
	
	function get_paid_service_amount($id,$adults,$nights){
				$amount	=	0;
				if($nights==0){
					$nights	=	1;
				}
					$CI =& get_instance();
					$CI->db->where('id',$id);
		$result	=	$CI->db->get('services')->row();	
			
			if($result->price_type==1){	//per person
				$amount	=	$result->price*$adults;
			}
			if($result->price_type==2){ // per night
				$amount	=	$result->price*$nights;
			}
			if($result->price_type==3){ //fixed price
				$amount	=	$result->price;
			}
		return $amount;
	}
	
	function get_paid_service_amount_all($paid_services,$adults,$nights){
			$amount	=	0;
				if($nights==0){
					$nights	=	1;
				}
					$CI =& get_instance();
					$CI->db->where_in('id',$paid_services);
		$results	=	$CI->db->get('services')->result();	
			foreach($results as $result){
				if($result->price_type==1){	//per person
					$amount	+=	$result->price*$adults;
				}
				if($result->price_type==2){ // per night
					$amount	+=	$result->price*$nights;
				}
				if($result->price_type==3){ //fixed price
					$amount	+=	$result->price;
				}
			}	
		return $amount;
	}
	
	function get_room_type_featured_image($id){
					$CI =& get_instance();
		 				$CI->db->where('room_type_id',$id);
						$CI->db->where('is_featured',1);
			$result	=	$CI->db->get('room_types_images')->row();	
						
						if(empty($result)){
							$CI->db->where('room_type_id',$id);
							$result	=	$CI->db->get('room_types_images')->row();
						}
						if(empty($result)){
							return base_url('assets/admin/dist/img/noImageAvailable.jpg'); 
						}else{
							return base_url('assets/admin/uploads/gallery/small/'.$result->image);
						}
						
						
	}
	
	function get_room_type_featured_image_medium($id){
					$CI =& get_instance();
		 				$CI->db->where('room_type_id',$id);
						$CI->db->where('is_featured',1);
			$result	=	$CI->db->get('room_types_images')->row();	
						
						if(empty($result)){
							$CI->db->where('room_type_id',$id);
							$result	=	$CI->db->get('room_types_images')->row();
						}
						if(empty($result)){
							return base_url('assets/admin/dist/img/noImageAvailable.jpg'); 
						}else{
							return base_url('assets/admin/uploads/gallery/medium/'.$result->image);
						}
						
						
	}
	
	
	 function GetDays($sStartDate, $sEndDate){  
	  // Firstly, format the provided dates.  
	  // This function works best with YYYY-MM-DD  
	  // but other date formats will work thanks  
	  // to strtotime().  
	  $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
	  $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  
	  
	   $begin = new DateTime($sStartDate);
		$end = new DateTime($sEndDate);
		
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		$i=1;
		foreach ( $period as $dt ){
	    
		$i++;
		}
		
	  return $i;
	  /*
	  // Start the variable off with the start date  
	  $aDays[] = $sStartDate;  
	  
	  // Set a 'temp' variable, sCurrentDate, with  
	  // the start date - before beginning the loop  
	  $sCurrentDate = $sStartDate;  
	  
	  // While the current date is less than the end date  
	  while($sCurrentDate < $sEndDate){  
		// Add a day to the current date  
		$sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
	  
		// Add this new day to the aDays array  
		$aDays[] = $sCurrentDate;  
	  }  
	  
	  // Once the loop has finished, return the  
	  // array of days.  
	  return $aDays;*/  
	}  
	
	function get_coupon_paid_services($id){
			$CI =& get_instance();
							$CI->db->where('id',$id);
			$coupon	=		$CI->db->get('coupons')->row();
			if(empty($coupon)){
				return false;
			}else{
			
				$pids	=	json_decode($coupon->paid_services);
				if(empty($pids)){
					return false;
				}else{
									$CI->db->where_in('id',$pids);
					return $CI->db->get('services')->result();
				}
			
			}
	}	
	
	function get_advance(){
				$CI =& get_instance();			
				
				$CI->db->where('id',1);
				$setting		=		$CI->db->get('settings')->row();
				$booking_data	=	$CI->session->userdata('booking_data');
				$coupon_data 	=	$CI->session->userdata('coupon_data');
		//echo '<pre>'; print_r($coupon_data);die;
		if(!empty($coupon_data)){
			return $coupon_data['totalamount']/100*$setting->advance_payment;
		}else{
			if(!empty($setting->advance_payment)){
				return $booking_data['totalamount']/100*$setting->advance_payment;
			}else{
				return $booking_data['totalamount'];
			}
		}
	}
	
	function get_invoice_number(){
			$CI =& get_instance();			
			
										$CI->db->select_max('invoice');
				$payment		=		$CI->db->get('payment')->row();
		//echo '<pre>'; print_r($payment);die;
			if(empty($payment->invoice)){
									$CI->db->where('id',1);
				$settings	=		$CI->db->get('settings')->row();
				$inv		=	$settings->invoice;
			}else{
				$inv		=	$payment->invoice+1;
			}
			return $inv;
	}
?>