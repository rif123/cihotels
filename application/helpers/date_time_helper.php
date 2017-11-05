<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function date_time_convert($str){
$CI = get_instance();
$CI = get_instance();
$settings	=	get_setting();
	if($settings->time_format==1){
		return $str = date("".$settings->date_format." h:i a",strtotime($str));
	}
	if($settings->time_format==2){
		return $str = date("".$settings->date_format." H:i",strtotime($str));
	}
}

function date_convert($str){
$CI = get_instance();
$settings	=	get_setting();
return $str = date("".$settings->date_format."",strtotime($str));


}

?>