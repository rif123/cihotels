<?php
class Reports extends Admin_Controller {

	function __construct()
	{		
		parent::__construct();
		$this->load->model(array('room_type_model','report_model','setting_model','expenses_category_model', 'housekeeping_model'));
		$this->load->library('form_validation');
		$this->colors	=	array('#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74','#CD5C5C','#F08080','#FA8072','#FFA07A','#B22222','#DB7093','#C71585','#FF1493','#FF69B4','#FFB6C1','#FFC0CB','#FF4500','#FF6347','#FFA07A','#FFFF00','#FFD700','#F0E68C','#EE82EE','#9370DB','#00FA9A','#B0C4DE','#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74','#CD5C5C','#F08080','#FA8072','#FFA07A','#B22222','#DB7093','#C71585','#FF1493','#FF69B4','#FFB6C1','#FFC0CB','#FF4500','#FF6347','#FFA07A','#FFFF00','#FFD700','#F0E68C','#EE82EE','#9370DB','#00FA9A','#B0C4DE','#FF0F00','#FF6600','#FF9E01','#FCD202','#F8FF01','#B0DE09','#04D215','#0D8ECF','#0D52D1','#2A0CD0','#8A0CCF','#CD0D74','#CD5C5C','#F08080','#FA8072','#FFA07A','#B22222','#DB7093','#C71585','#FF1493','#FF69B4','#FFB6C1','#FFC0CB','#FF4500','#FF6347','#FFA07A','#FFFF00','#FFD700','#F0E68C','#EE82EE','#9370DB','#00FA9A','#B0C4DE');
	}
	
	function occupancy()
	{	
		$data['room_types']	= $this->room_type_model->get_all();
		$data['setting']	= $this->setting_model->get();		
		$data['weekdata']	=	array();
		$data['monthdata']	=	array();		
		$data['yeardata']	=	array();
		$data['customdata']	=	array();
				// 7 DAYS Week Chart
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
							$weekdata	=	$this->report_model->get_this_week_occupancy($date);
							$data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['weekdata'][$i]['total']	=	@$weekdata->total;
							$data['weekdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$mbegin = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
						$mend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
						
						$minterval = DateInterval::createFromDateString('1 day');
						$mperiod = new DatePeriod($mbegin, $minterval, $mend);
						$i=0;
						foreach($mperiod as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							$monthdata	=	$this->report_model->get_this_week_occupancy($date);
						 
							$data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['monthdata'][$i]['total']	=	@$monthdata->total;
							$data['monthdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$start = $month = strtotime("- 365 days");
						$end = strtotime('+ 1 day');
						$i=0;
						while($month < $end)
						{
							$month = strtotime("+1 month", $month);
							 $Y	= date('Y', $month);
							 $M	= date('m', $month);
							$yeardata	=	$this->report_model->get_this_year_occupancy($Y,$M); 
							
							$data['yeardata'][$i]['date']	=	date('M', $month)." ".date('Y', $month);
							$data['yeardata'][$i]['total']	=	@$yeardata->total;
							$data['yeardata'][$i]['color']	=	$this->colors[$i];
							$i++;	 
						}		
						
						if(!empty($_POST['from']) && !empty($_POST['to'])){
						
							$from = $this->input->post('from');
							$to = $this->input->post('to');
							$cbegin = new DateTime($from);
							$cend = new DateTime($to );
							
							$cinterval = DateInterval::createFromDateString('1 day');
							$cperiod = new DatePeriod($cbegin, $cinterval, $cend);
							$cnt=1;
							foreach ($cperiod as $dt){
								$cnt++;
							}
							//echo '<pre>'; print_r($this->colors);die;	
							
								$i=0;
								foreach ($cperiod as $dt){
									$customdata	=	$this->report_model->get_this_week_occupancy($dt->format( "Y-m-d" ));
									$data['customdata'][$i]['date']		=	$dt->format( "d M Y" );
									$data['customdata'][$i]['total']	=	@$customdata->total;
									$data['customdata'][$i]['color']	=	@$this->colors[$i];
									$i++;
								}
							
						}
						
			//echo json_encode($data['weekdata']);			
		//echo '<pre>'; print_r($data['customdata']);die;
		$data['page_title']	= lang('occupancy_report');
		$this->render_admin('reports/occupancy', $data);		
	}
	
	function guest()
	{	
		$data['room_types']	= $this->room_type_model->get_all();
		$data['setting']	= $this->setting_model->get();		
		$data['weekdata']	=	array();
		$data['monthdata']	=	array();		
		$data['yeardata']	=	array();
		$data['customdata']	=	array();
				// 7 DAYS Week Chart
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
							$data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['weekdata'][$i]['total']	=	@$weekdata->total;
							$data['weekdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$mbegin = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
						$mend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
						
						$minterval = DateInterval::createFromDateString('1 day');
						$mperiod = new DatePeriod($mbegin, $minterval, $mend);
						$i=0;
						foreach($mperiod as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							$monthdata	=	$this->report_model->get_this_date_guest($date);
						 
							$data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['monthdata'][$i]['total']	=	@$monthdata->total;
							$data['monthdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$start = $month = strtotime("- 365 days");
						$end = strtotime('+ 1 day');
						$i=0;
						while($month < $end)
						{
							$month = strtotime("+1 month", $month);
							 $Y	= date('Y', $month);
							 $M	= date('m', $month);
							$yeardata	=	$this->report_model->get_this_year_guest($Y,$M); 
							
							$data['yeardata'][$i]['date']	=	date('M', $month)." ".date('Y', $month);
							$data['yeardata'][$i]['total']	=	@$yeardata->total;
							$data['yeardata'][$i]['color']	=	$this->colors[$i];
							$i++;	 
						}		
						
						if(!empty($_POST['from']) && !empty($_POST['to'])){
						
							$from = $this->input->post('from');
							$to = $this->input->post('to');
							$cbegin = new DateTime($from);
							$cend = new DateTime($to );
							
							$cinterval = DateInterval::createFromDateString('1 day');
							$cperiod = new DatePeriod($cbegin, $cinterval, $cend);
							$cnt=1;
							foreach ($cperiod as $dt){
								$cnt++;
							}
							//echo '<pre>'; print_r($this->colors);die;	
							
								$i=0;
								foreach ($cperiod as $dt){
									$customdata	=	$this->report_model->get_this_date_guest($dt->format( "Y-m-d" ));
									$data['customdata'][$i]['date']		=	$dt->format( "d M Y" );
									$data['customdata'][$i]['total']	=	@$customdata->total;
									$data['customdata'][$i]['color']	=	@$this->colors[$i];
									$i++;
								}
							
						}
						
			//echo json_encode($data['weekdata']);			
		//echo '<pre>'; print_r($data['customdata']);die;
		$data['page_title']	= lang('guest_report');
		$this->render_admin('reports/guest', $data);		
	}
	
	function financial()
	{	
		$data['weekdata']	=	array();
		$data['monthdata']	=	array();		
		$data['yeardata']	=	array();
		$data['customdata']	=	array();
				// 7 DAYS Week Chart
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
							$weekdata	=	$this->report_model->get_this_date_financial($date);
							$data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['weekdata'][$i]['total']	=	@$weekdata->total;
							$data['weekdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$mbegin = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
						$mend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
						
						$minterval = DateInterval::createFromDateString('1 day');
						$mperiod = new DatePeriod($mbegin, $minterval, $mend);
						$i=0;
						foreach($mperiod as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							$monthdata	=	$this->report_model->get_this_date_financial($date);
						 
							$data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['monthdata'][$i]['total']	=	@$monthdata->total;
							$data['monthdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$start = $month = strtotime("- 365 days");
						$end = strtotime('+ 1 day');
						$i=0;
						while($month < $end)
						{
							$month = strtotime("+1 month", $month);
							 $Y	= date('Y', $month);
							 $M	= date('m', $month);
							$yeardata	=	$this->report_model->get_this_year_financial($Y,$M); 
							
							$data['yeardata'][$i]['date']	=	date('M', $month)." ".date('Y', $month);
							$data['yeardata'][$i]['total']	=	@$yeardata->total;
							$data['yeardata'][$i]['color']	=	$this->colors[$i];
							$i++;	 
						}		
						
						if(!empty($_POST['from']) && !empty($_POST['to'])){
						
							$from = $this->input->post('from');
							$to = $this->input->post('to');
							$cbegin = new DateTime($from);
							$cend = new DateTime($to );
							
							$cinterval = DateInterval::createFromDateString('1 day');
							$cperiod = new DatePeriod($cbegin, $cinterval, $cend);
							$cnt=1;
							foreach ($cperiod as $dt){
								$cnt++;
							}
							//echo '<pre>'; print_r($this->colors);die;	
							
								$i=0;
								foreach ($cperiod as $dt){
									$customdata	=	$this->report_model->get_this_date_financial($dt->format( "Y-m-d" ));
									$data['customdata'][$i]['date']		=	$dt->format( "d M Y" );
									$data['customdata'][$i]['total']	=	@$customdata->total;
									$data['customdata'][$i]['color']	=	@$this->colors[$i];
									$i++;
								}
							
						}
						
			//echo json_encode($data['weekdata']);			
		//echo '<pre>'; print_r($data['customdata']);die;
		$data['page_title']	= lang('financial_report');
		$this->render_admin('reports/financial', $data);		
	}
	
	
	function coupon()
	{	$data['coupons']	=	$this->report_model->get_coupons();
		$data['weekdata']	=	array();
		$data['monthdata']	=	array();		
		$data['yeardata']	=	array();
		$data['customdata']	=	array();
				// 7 DAYS Week Chart
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
							$weekdata	=	$this->report_model->get_this_date_coupon($date);
							$data['weekdata'][$i]['date']		=	date('d M', strtotime($date));
							$data['weekdata'][$i]['amount']		=	@$weekdata->amount;
							$data['weekdata'][$i]['coupons']	=	@$weekdata->coupons;
						$i++;
						}		
						
						
						$mbegin = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
						$mend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
						
						$minterval = DateInterval::createFromDateString('1 day');
						$mperiod = new DatePeriod($mbegin, $minterval, $mend);
						$i=0;
						foreach($mperiod as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							$monthdata	=	$this->report_model->get_this_date_coupon($date);
						 
							$data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['monthdata'][$i]['amount']	=	@$monthdata->amount;
							$data['monthdata'][$i]['coupons']	=	@$monthdata->coupons;
						$i++;
						}		
						
						
						$start = $month = strtotime("- 365 days");
						$end = strtotime('+ 1 day');
						$i=0;
						while($month < $end)
						{
							$month = strtotime("+1 month", $month);
							 $Y	= date('Y', $month);
							 $M	= date('m', $month);
							$yeardata	=	$this->report_model->get_this_year_coupon($Y,$M); 
							
							$data['yeardata'][$i]['date']		=	date('M', $month)." ".date('Y', $month);
							$data['yeardata'][$i]['amount']		=	@$yeardata->amount;
							$data['yeardata'][$i]['coupons']	=	@$yeardata->coupons;
							$i++;	 
						}		
						
						if(!empty($_POST['from']) && !empty($_POST['to'])){
						
							$from = $this->input->post('from');
							$to = $this->input->post('to');
							$cbegin = new DateTime($from);
							$cend = new DateTime($to );
							
							$cinterval = DateInterval::createFromDateString('1 day');
							$cperiod = new DatePeriod($cbegin, $cinterval, $cend);
							$cnt=1;
							foreach ($cperiod as $dt){
								$cnt++;
							}
							//echo '<pre>'; print_r($this->colors);die;	
							
								$i=0;
								foreach ($cperiod as $dt){
									$customdata	=	$this->report_model->get_this_date_coupon($dt->format( "Y-m-d" ));
									$data['customdata'][$i]['date']		=	$dt->format( "d M Y" );
									$data['customdata'][$i]['amount']	=	@$customdata->amount;
									$data['customdata'][$i]['coupons']	=	@$customdata->coupons;
									$i++;
								}
							
						}
						
			//echo json_encode($data['weekdata']);			
			//echo '<pre>'; print_r($data['weekdata']);die;
		$data['page_title']	= lang('coupon_report');
		$this->render_admin('reports/coupon', $data);		
	}
	
	function expenses()
	{	
		$data['ecategory']	=	$this->expenses_category_model->get_all();
		$data['weekdata']	=	array();
		$data['monthdata']	=	array();		
		$data['yeardata']	=	array();
		$data['customdata']	=	array();
				// 7 DAYS Week Chart
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
							$weekdata	=	$this->report_model->get_this_date_expenses($date);
							$data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['weekdata'][$i]['total']	=	@$weekdata->total;
							$data['weekdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$mbegin = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
						$mend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
						
						$minterval = DateInterval::createFromDateString('1 day');
						$mperiod = new DatePeriod($mbegin, $minterval, $mend);
						$i=0;
						foreach($mperiod as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							$monthdata	=	$this->report_model->get_this_date_expenses($date);
						 
							$data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['monthdata'][$i]['total']	=	@$monthdata->total;
							$data['monthdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$start = $month = strtotime("- 365 days");
						$end = strtotime('+ 1 day');
						$i=0;
						while($month < $end)
						{
							$month = strtotime("+1 month", $month);
							 $Y	= date('Y', $month);
							 $M	= date('m', $month);
							$yeardata	=	$this->report_model->get_this_year_expenses($Y,$M); 
							
							$data['yeardata'][$i]['date']	=	date('M', $month)." ".date('Y', $month);
							$data['yeardata'][$i]['total']	=	@$yeardata->total;
							$data['yeardata'][$i]['color']	=	$this->colors[$i];
							$i++;	 
						}		
						
						if(!empty($_POST['from']) && !empty($_POST['to'])){
						
							$from = $this->input->post('from');
							$to = $this->input->post('to');
							$cbegin = new DateTime($from);
							$cend = new DateTime($to );
							
							$cinterval = DateInterval::createFromDateString('1 day');
							$cperiod = new DatePeriod($cbegin, $cinterval, $cend);
							$cnt=1;
							foreach ($cperiod as $dt){
								$cnt++;
							}
							//echo '<pre>'; print_r($this->colors);die;	
							
								$i=0;
								foreach ($cperiod as $dt){
									$customdata	=	$this->report_model->get_this_date_expenses($dt->format( "Y-m-d" ));
									$data['customdata'][$i]['date']		=	$dt->format( "d M Y" );
									$data['customdata'][$i]['total']	=	@$customdata->total;
									$data['customdata'][$i]['color']	=	@$this->colors[$i];
									$i++;
								}
							
						}
						
			//echo json_encode($data['weekdata']);			
		//echo '<pre>'; print_r($data['customdata']);die;
		$data['page_title']	= lang('expenses_report');
		$this->render_admin('reports/expenses', $data);		
	}	

	function housekeeping() {

		$data['ecategory']	=	$this->housekeeping_model->get_all();
		$data['weekdata']	=	array();
		$data['monthdata']	=	array();		
		$data['yeardata']	=	array();
		$data['customdata']	=	array();
				// 7 DAYS Week Chart
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
							$weekdata	=	$this->housekeeping_model->get_this_date_house($date);
							$data['weekdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['weekdata'][$i]['total']	=	@$weekdata->total;
							$data['weekdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
						
						
						$mbegin = new DateTime(date("Y-m-d", strtotime("- 30 DAYS")));
						$mend = new DateTime(date('Y-m-d', strtotime("+ 1 DAYS")));
						
						$minterval = DateInterval::createFromDateString('1 day');
						$mperiod = new DatePeriod($mbegin, $minterval, $mend);
						$i=0;
						foreach($mperiod as $dt){
							$date		=	 $dt->format( "Y-m-d" );	
							$dayno		=	 $dt->format( "N" );
							$day		=	 $dt->format( "D" );
							$day		=	strtolower($day);
							$monthdata	=	$this->housekeeping_model->get_this_date_house($date);
							$data['monthdata'][$i]['date']	=	date('d M', strtotime($date));
							$data['monthdata'][$i]['total']	=	@$monthdata->total;
							$data['monthdata'][$i]['color']	=	$this->colors[$i];
						$i++;
						}		
					
						
						$start = $month = strtotime("- 365 days");
						$end = strtotime('+ 1 day');
						$i=0;
						while($month < $end)
						{
							$month = strtotime("+1 month", $month);
							 $Y	= date('Y', $month);
							 $M	= date('m', $month);
							$yeardata	=	$this->housekeeping_model->get_this_year_house($Y,$M); 
							
							$data['yeardata'][$i]['date']	=	date('M', $month)." ".date('Y', $month);
							$data['yeardata'][$i]['total']	=	@$yeardata->total;
							$data['yeardata'][$i]['color']	=	$this->colors[$i];
							$i++;	 
						}		
						
						// echo "<pre>";
						// print_R($_POST);die;

						if(!empty($_POST['from']) && !empty($_POST['to'])){
						
							$from = $this->input->post('from');
							$to = $this->input->post('to');
							$cbegin = new DateTime($from);
							$cend = new DateTime($to );
							
							$cinterval = DateInterval::createFromDateString('1 day');
							$cperiod = new DatePeriod($cbegin, $cinterval, $cend);
							$cnt=1;
							foreach ($cperiod as $dt){
								$cnt++;
							}
							//echo '<pre>'; print_r($this->colors);die;	
							
							$i=0;
							foreach ($cperiod as $dt){
								$customdata	=	$this->housekeeping_model->get_this_date_house($dt->format( "Y-m-d" ));
								$data['customdata'][$i]['date']		=	$dt->format( "d M Y" );
								$data['customdata'][$i]['total']	=	@$customdata->total;
								$data['customdata'][$i]['color']	=	@$this->colors[$i];
								$i++;
							}

							
							
						}
						
			//echo json_encode($data['weekdata']);			
		// echo '<pre>'; print_r($data);die;
		$data['page_title']	= lang('housekeeping_report');
		$this->render_admin('reports/reportHousekeeping', $data);		
	}
}