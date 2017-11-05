<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
    	$this->load->model(array('dashboard_model','report_model','service_model','employee_model'));
	}
	
	
	function index() {
		
		$data['orders']		=	$this->dashboard_model->get_orders();
		$data['guests']		=	$this->dashboard_model->get_guests();	
		$data['rooms']		=	$this->dashboard_model->get_rooms();
		$data['latest_bookings']		=	$this->dashboard_model->get_latest_bookings($limit=10);	
		$data['trevenue']		=	$this->dashboard_model->get_todays_revenue();
		$data['coupons']		=	$this->dashboard_model->get_coupons();
		$data['services']		=	$this->service_model->get_all();
		$data['vips']		=	$this->dashboard_model->get_vips();
		$data['employees']		=	$this->employee_model->get_all();
		
		$begin = new DateTime(date('Y-m-d', strtotime('- 6 days')));
		$end = new DateTime(date('Y-m-d'));
		
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);
		$data['dbchart']	=	array();
		foreach ( $period as $dt ){
		  $date	=	$dt->format( "Y-m-d" );
		  $data['dbchart'][$date]		=	$this->dashboard_model->get_payment_by_date($date);
		}
		//echo '<pre>'; print_r($data['dbchart']);die;
		//occupanycy report--
		$weekstart	=	date("Y-m-d", strtotime("- 6 DAYS"));
		$wbegin = new DateTime($weekstart);
		$wend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
		
		$winterval = DateInterval::createFromDateString('1 day');
		$wperiod = new DatePeriod($wbegin, $winterval, $wend);
		$i=0;
		foreach($wperiod as $dt){
			$date		=	 $dt->format( "Y-m-d" );	
			$dayno		=	 $dt->format( "N" );
			$day		=	 $dt->format( "D" );
			$day		=	strtolower($day);
			$weekdata	=	$this->report_model->get_this_date_guest($date);
			$data['weekdata'][$i]['date']	=	$date;
			$data['weekdata'][$i]['total']	=	(!empty($weekdata->total))?$weekdata->total:'0';
			//$data['weekdata'][$i]['color']	=	$this->colors[$i];
		$i++;
		}	
					
		//echo '<pre>'; print_r($data['weekdata']);die;				
		$data['page_title']	=	lang('dashboard');
		$this->render_admin('dashboard/dashboard', $data);	

	}	
	
		
	
}