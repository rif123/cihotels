<?php
class Calendar extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('room_type_model','calendar_model','setting_model'));
		$this->load->library('form_validation');
	}
	
	function index()
	{	
		$data['room_types']	= $this->room_type_model->get_all();
		$data['setting']	= $this->setting_model->get();		
		$order	= $this->calendar_model->get_first_order();
		$data['calendar_result']		=	array();
				if(!empty($_POST['room_type_id'])){		
				    if($order){
						$room_type	=	$this->calendar_model->get_room_type();
						$begin = new DateTime($order->check_in);
						$end = new DateTime(date('Y-m-d', strtotime('+ 120 days')));
						$interval = DateInterval::createFromDateString('1 day');
						$period = new DatePeriod($begin, $interval, $end);
						foreach($period as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							$result	=		$this->calendar_model->get_booking_by_room_type_and_date($date);
							//$data['result'][$date]['date']			=	$date;
							$data['calendar_result'][$date]['available']		=	$room_type->total_rooms - $result->bookings;
							$data['calendar_result'][$date]['unavailable']	=	$result->bookings;
						}
                    }    
					// echo '<pre>'; print_r($data['calendar_result']);die;
				}		
				
		
		$data['page_title']	= lang('availability_calendar');
		$this->render_admin('calendar/calendar', $data);		
	}
	
}