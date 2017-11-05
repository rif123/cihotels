<?php
		function rate_exchange($amount)
		{	$CI =& get_instance();
			
			$result = $CI->session->userdata('currency_result');
			if(empty($result)){
				$result	=1;
			}
			if(empty($result)){
				$result	=1;
			}
			return round($price =$result*$amount,2);
		}	
		function get_currency_unit(){
			$CI =& get_instance();
			$result = $CI->session->userdata('currency_result');
			if(empty($result)){
				$result	=1;
			}
			return $result;
		}
		
		function rate_exchange_order($amount,$unit){
			return round($price =$amount*$unit,2);
		}
		
		
		function getUsd($amount){
			$CI =& get_instance();
			$setting	=	get_setting();
			$from = $setting->currency_code;
			
			$from_Currency = urlencode($from);
			$to_Currency = urlencode('USD');
				if($from_Currency==$to_Currency){
					$value	= 1;
				}else{
					$encode_amount = 1;
					$get = file_get_contents("https://www.google.com/finance/converter?a=$encode_amount&from=$from_Currency&to=$to_Currency");
					$get = explode("<span class=bld>",$get);
					$get = explode("</span>",$get[1]);
					
					$value = preg_replace("/[^0-9\.]/", null, $get[0]);
				}
			return round($price =$value*$amount,2);
		}
?>