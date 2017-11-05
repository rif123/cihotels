<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css"> 
<link href="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />
<style>
@media print{
  body{font-size:12px !important} 
  .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 3px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
   }
   a{display:none !important}
}
</style>
<?php 

if($booking->payment_status==1){
	$payment_status	=	lang('success');
}	
if($booking->payment_status==2){
	$payment_status	=	lang('pending');
}
if($booking->payment_status==0){
	$payment_status	=	lang('failed');
}
if($booking->payment_status==3){
	$payment_status	=	lang('partialy_paid');
}
if($booking->status==0){
	$booking_status	=	lang('pending');
}
if($booking->status==1){
	$booking_status	=	lang('success');
}
if($booking->status==2){
	$booking_status	=	lang('canceled');
}	
?>


<section class="content-header">
          <h1>
            <?php echo $page_title; ?> #<?php echo $booking->order_no?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/bookings') ?>"> <?php echo lang('bookings')?> </a></li>
            <li class="active"><?php echo lang('view');?></li>
          </ol>
</section>

 <div class="row" style="padding:20px;">
		 	<div class="col-md-5 pull-right">
					<div class="col-md-6">
						<select name="booking_status" class="form-control" id="booking_status" data-toggle="tooltip" title="Change Booking Status" >
								<option value="0" <?php echo ($booking->status==0)?'selected="selected"':'';?>><?php echo lang('pending')?></option>
								<option value="1" <?php echo ($booking->status==1)?'selected="selected"':'';?>><?php echo lang('success')?></option>
								<option value="2" <?php echo ($booking->status==2)?'selected="selected"':'';?>><?php echo lang('canceled')?></option>
						</select>
					</div>
					<div class="col-md-6">
						<select name="payment_status" class="form-control" id="payment_status" data-toggle="tooltip" title="Change Payment Status" >
								<option value="0" <?php echo ($booking->payment_status==0)?'selected="selected"':'';?>><?php echo lang('failed')?></option>
								<option value="1" <?php echo ($booking->payment_status==1)?'selected="selected"':'';?>><?php echo lang('success')?></option>
								<option value="2" <?php echo ($booking->payment_status==2)?'selected="selected"':'';?>><?php echo lang('pending')?></option>
								<option value="3" <?php echo ($booking->payment_status==3)?'selected="selected"':'';?>><?php echo lang('partialy_paid')?></option>
						</select>
					</div>
				
			</div>
		 </div>
 <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
        <div id="responsiveTabsDemo">
						<ul>
							<li><a href="#tab-1"> <?php echo lang('details')?> </a></li>
							<li><a href="#tab-2"> <?php echo lang('payments')?></a></li>
							<li><a href="#tab-3"> <?php echo lang('room')?></a></li>
						</ul>
						<div id="tab-1">
					
				  <div class="row">
					<div class="col-xs-12">
					  <h2 class="page-header">
						<img src="<?php echo base_url('assets/admin/uploads/images/'.$this->setting->logo) ?>" height="35" width="60" /></i> <?php echo $this->setting->name?>
						<small class="pull-right"><?php echo lang('booking_date')?>: <?php echo date_time_convert($booking->ordered_on);?></small>
					  </h2>
					</div><!-- /.col -->
				  </div>
				  <!-- info row -->
				  <div class="row invoice-info">
					<div class="col-sm-4 invoice-col">
					  <?php echo lang('hotel_details')?>
					  <address>
						<strong><?php echo $this->setting->name?></strong><br>
						<?php echo wordwrap($this->setting->address,50,"<br>\n");?><br>
						<?php echo lang('phone')?>: <?php echo $this->setting->phone?><br/>
						<?php echo lang('email')?>: <?php echo $this->setting->email?>
					  </address>
					</div><!-- /.col -->
					<div class="col-sm-4 invoice-col">
					  <?php echo lang('guest_details')?>
					  <address>
						<strong><?php echo $booking->firstname?> <?php echo $booking->lastname?></strong><br>
						<?php echo $booking->guest_address?><br>
						<?php echo $booking->guest_city?> <?php echo $booking->guest_state?>, <?php echo $booking->guest_country?><br>
						<?php echo lang('phone')?>: <?php echo $booking->guest_phone?><br/>
						<?php echo lang('email')?>: <?php echo $booking->guest_email?>
					  </address>
					</div><!-- /.col -->
					<div class="col-sm-4 invoice-col">
							<table width="90%">
								<tr>
									<th><b><?php echo lang('room')?></b></th>
									<th>:</th>
									<td><?php echo $booking->room?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('booking_number')?> </b></th>
									<th>:</th>
									<td ><?php echo $booking->order_no?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('check_in')?> </b></th>
									<th>:</th>
									<td ><?php echo date_convert($booking->check_in);?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('check_out')?></b></th>
									<th>:</th>
									<td ><?php echo date_convert($booking->check_out);?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('payment_status')?> </b></th>
									<th>:</th>
									<td ><?php echo $payment_status;?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('booking_status')?> </b></th>
									<th>:</th>
									<td ><?php echo $booking_status?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('adults')?></b></th>
									<th>:</th>
									<td ><?php echo $booking->adults?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('kids')?> </b></th>
									<th>:</th>
									<td ><?php echo $booking->kids?></td>
								</tr>
								<tr>
									<th><b><?php echo lang('nights')?> </b></th>
									<th>:</th>
									<td ><?php echo $booking->nights?></td>
								</tr>
							</table>
					 </div><!-- /.col -->
				  </div><!-- /.row -->
		
				  <!-- Table row -->
				  <div class="row">
					<div class="col-xs-12 table-responsive">
					  <table class="table table-striped">
						<thead>
						  <tr>
							<th>#</th>
							<th><?php echo lang('date');?></th>
							<td align="right"><b><?php echo lang('price');?></b></td>
							 <?php if($booking->additional_person > 0){?>
							<td align="center"><b><?php echo lang('addi_person');?></b></td>
							<td><b><?php echo lang('total')?></b></td>
							<?php } ?>
						  </tr>
						</thead>
						<tbody>
						<?php $i=1;foreach($prices as $new){?>
							<tr>
								<td><?php echo $i?>.</td>
								<td><?php echo date_convert($new->date)?></td>
								<td align="right"><?php echo $booking->cs?>  <?php echo rate_exchange_order($new->price,$booking->currency_unit)?></td>
								 <?php if($booking->additional_person > 0){?>
								<td align="center"><?php echo @$new->additional_person; ?> &times; <?php echo rate_exchange_order(@$new->additional_person_price,@$booking->currency_unit); ?> = <?php echo @$order->cs?>	<?php echo @$new->additional_person * rate_exchange_order(@$new->additional_person_price,@$order->currency_unit)?></td>
								<td>  <?php echo $booking->cs?>	<?php echo rate_exchange_order($new->total,$booking->currency_unit)?></td>
								<?php } ?>
								
							</tr>
						<?php $i++;}?>
						<tr>
							<td></td>
							<td align=""><b><?php echo lang('total_price')?></b></td>
							<td align="right"> <b> <?php echo $booking->cs?>	<?php echo rate_exchange_order($booking->amount	-	 $booking->additional_person_amount,$booking->currency_unit)?></b></td>
							<?php if($booking->additional_person > 0){?>
							<td align="center"><b> <?php echo $booking->cs?> <?php echo rate_exchange_order($booking->additional_person_amount,$booking->currency_unit)?></b></td>
							<td><b><?php echo $booking->cs?> <?php echo rate_exchange_order($booking->amount,$booking->currency_unit);?></b></td>
							<?php }?>
						</tr>
						</tbody>
					  </table>
					</div><!-- /.col -->
				  </div><!-- /.row -->
		
				  <div class="row">
					<!-- accepted payments column -->
					<div class="col-xs-12">
					  <p class="lead"><?php echo lang('taxes')?></p>
					  <div class="table-responsive">
						<table class="table">
						 <?php $i=1;foreach($taxes as $t){?>
							<tr>
								<td ><?php echo $i?>.</td>
								<td><?php echo $t->name?></td>
								<td><?php echo ($t->type=='Fixed')?'$':''?><?php echo $t->rate?> <?php echo ($t->type=='Percentage')?'%':''?></td>
								<td>= <?php echo $booking->cs?> <?php echo rate_exchange_order($t->amount,$booking->currency_unit);?></td>
							</tr>
							<?php $i++;}?>
							<tr>
								<td></td>
								<td colspan="2" align=""><b><?php echo lang('total_tax')?></b></td>
								<td>= <b><?php echo $booking->cs?> <?php echo rate_exchange_order($booking->taxamount,$booking->currency_unit);?></b></td>
							</tr>
						</table>
						<table class="table">
							<?php if(!empty($booking->coupon)){?>
									<tr>
										<th class="col-md-7"><?php echo lang('coupon')?></th>
										<th >-<?php echo $booking->cs?> <?php echo rate_exchange_order($booking->coupon_discount,$booking->currency_unit);?>  (<?php echo strtoupper($booking->coupon)?>)</th>
									</tr>
									<?php } ?>
									<?php if($booking->free_paid_services_amount > 0){?>
										<tr>
											<th><?php echo lang('free_services')?></th>
											<td >	<b>-<?php echo $booking->cs?>  <?php echo rate_exchange_order($booking->free_paid_services_amount,$booking->currency_unit)?> 	(<?php echo @$booking->free_paid_services_title?>)</b></td>
										</tr>
									<?php } ?>
						</table>
						<?php if(!empty($services)){?>
						<p class="lead"><?php echo lang('paid_services')?></p>
						<table class="table" border="0">
									<tr>
										<td colspan="2" >
											<table width="100%" >
												<?php $i=1;foreach($services as $serv){
													$fs	=	json_decode($booking->free_paid_services);
													$stl	=	'';
													if(!empty($fs)){
														$stl		=	(in_array($serv->id,$fs))?'stl':'';
													}
												?>
												<tr>
													<td><?php echo $i;?></td>
													<td><?php echo $serv->title?></td>
													<td class="<?php echo $stl?>">&nbsp; <?php echo $booking->cs?> <?php echo rate_exchange_order($serv->amount,$booking->currency_unit);?></td> 
													<td><?php
														$price_type	=	'';
															if($serv->price_type==1){
																$price_type	=	lang('per_person');
															}
															if($serv->price_type==2){
																$price_type	=	lang('per_night');
															}
															if($serv->price_type==3){
																$price_type	=	lang('fixed_price');
															}
															echo $price_type;
														?>
													</td>
												</tr>
												
												<?php $i++;} ?>
												<tr>
													<td></td>
													<td colspan="1" align=""><b><?php echo lang('services_paid')?></b> <span class="pull-right">=</span>  </td>
													<?php if($booking->free_paid_services_amount > 0){?>
													<td> <b> &nbsp; <?php echo $booking->cs?> <?php echo rate_exchange_order($booking->paid_service_amount-$booking->free_paid_services_amount ,$booking->currency_unit);?></b></td>
													<?php }else{?>
													<td> <b> &nbsp; <?php echo $booking->cs?> <?php echo rate_exchange_order($booking->paid_service_amount,$booking->currency_unit);?></b></td>
													<?php } ?>
												</tr>
											</table>	
										</td>
									</tr>
						<?php } ?>
						</table>
						<table class="table" border="0">
									
								<?php if(!empty($booking->payment_gateway_name)){?>		
									<tr>
										<th ><?php echo lang('payment_method')?></th>
										<td><?php echo $booking->payment_gateway_name?> </td>
									</tr>
								<?php } ?>	
								<?php if(!empty($booking->txn_id)){?>	
									<tr>
										<th ><?php echo lang('transection_id')?></th>
										<td><?php echo $booking->txn_id?> </td>
									</tr>
								<?php } ?>	
									<tr>
										<th ><?php echo lang('total_amount')?></th>
										<th ><?php echo $booking->cs?> <?php echo rate_exchange_order($booking->totalamount,$booking->currency_unit);?></th>
									</tr>
									<tr>
										<th ><?php echo lang('advance_payment')?></th>
										<th ><?php echo $booking->cs?> <?php echo rate_exchange_order($booking->advance_amount,$booking->currency_unit);?></th>
									</tr>
									
						</table>
					  </div>
					</div><!-- /.col -->
				  </div><!-- /.row -->
		
				  <!-- this row will not appear when printing -->
				  <div class="row no-print">
					<div class="col-xs-12">
					  <a href="#" class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</a>
					  <button class="btn btn-success pull-right hide"><i class="fa fa-credit-card"></i> Submit Payment</button>
					  <button class="btn btn-primary pull-right hide" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
					</div>
				  </div>
				
						</div>
						<div id="tab-2">
							<div class="box-header">
							  <h3 class="box-title"><?php echo lang('total_paid'); ?> : <?php echo ($totalpaid->total>0)?$totalpaid->total:'0';?></h3>
							  &nbsp;&nbsp;&nbsp;&nbsp;
							  <?php $pending	=	$booking->totalamount-$totalpaid->total;?>
							  <?php if(round($pending)>0){?>
							  <h3 class="box-title" style="color:#FF0000"><?php echo lang('pending'); ?> : <?php echo round($pending,2) ?></h3>
								<?php } ?>
							</div><!-- /.box-header -->
							 <div class="row">
								<div class="col-md-12" style="padding-bottom:10px;">
									<div class="btn-group pull-right">
										<a class="btn btn-success" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add');?> </a>
									</div>
					
								</div>
							 </div>
							<table class="table table-striped" id="example1">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('added_date'); ?></th>
									<th><?php echo lang('invoice_number'); ?></th>
									<th><?php echo lang('amount'); ?></th>
									<th><?php echo lang('action'); ?></th>
								</tr>
							</thead>
							
							<tbody >
						<?php if($payments):?>		
						<?php $i=1;foreach ($payments as $new):?>
								<tr>
									<td><?php echo $i;?></td>
									<td class="gc_cell_left" ><?php echo  date_convert($new->added_date); ?></td>
									<td><?php echo  $new->invoice; ?></td>
									<td><?php echo  $new->amount; ?></td>
									<td>
										<div class="btn-group" style="float:right">
											<a class="btn btn-default" href="#invoice<?php echo $new->id?>" data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice')?></a>
											<a class="btn btn-default" href="#view<?php echo $new->id?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view')?></a>
											<a class="btn btn-primary" href="#edit<?php echo $new->id?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
											</div>
									</td>
								</tr>
						<?php $i++; endforeach;?>
						<?php endif ?>
							</tbody>
						</table>

						</div>
						<div id="tab-3">
						<form method="post" action="<?php echo site_url('admin/bookings/alotroom')?>">
							<input type="hidden" name="order_id" value="<?php echo $booking->id?>" />
							 <div class="form-group">
								<div class="row">
									<div class="col-md-3">
										<b><?php echo lang('room_number')?></b>
									</div>
									<div class="col-md-5">
										<select name="room_id" class="form-control">
											<option value="">--<?php echo lang('select_room')?>--</option>
											<?php foreach($rooms as $room){?>
												<option value="<?php echo $room->id?>" <?php echo (@$order_room->room_id==$room->id)?'selected="selected"':''; ?>><?php echo $room->room_no; ?> - <?php echo $room->floor?></option>
											<?php } ?>
										</select>
										
									</div>
									<div class="col-md-2">
										<input type="submit" name="save" value="<?php echo lang('save')?>" class="btn btn-primary" />
									</div>
								</div>
							</div>
							
							</form>
							
							<table class="table table-striped" id="example1">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('date'); ?></th>
									<th><?php echo lang('room'); ?></th>
									<th><?php echo lang('floor'); ?></th>
								</tr>
							</thead>
							
							<tbody >
						<?php if($prices):?>		
						<?php $i=1;foreach ($prices as $new):?>
								<tr>
									<td><?php echo $i;?></td>
									<td class="gc_cell_left" ><?php echo  date_convert($new->date); ?></td>
									<td><?php echo  $new->room_no; ?></td>
									<td><?php echo  $new->floor; ?></td>
								</tr>
						<?php $i++; endforeach;?>
						<?php endif ?>
							</tbody>
						</table>
						</div>
				</div>  
        
		</section><!-- /.content -->
<!-- Add Payment-->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('payment');?></h4>
      </div>
      <div class="modal-body">
			</div>
      				   <!-- form start -->
				<form method="post" action="<?php echo site_url('admin/bookings/payment/')?>" enctype="multipart/form-data" id="add_form">
						<input type="hidden" name="order_id" value="<?php echo $booking->id?>" />
			        <div class="box-body">
                      <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('order_number')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="showorder_no" value="<?php echo $booking->order_no;?>" disabled="disabled"  class="form-control " />
								</div>
                            </div>
                        </div>
					  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="invoice_no" value="<?php echo get_invoice_number();?>" readonly="readonly"  class="form-control invoice_no" required />
									
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('added_date')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="added_date" value="" class="form-control datepicker" required/>
                                </div>
                            </div>
                        </div>
						  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_method')?></b>
								</div>
								<div class="col-md-8">
                                  <select name="payment_method" class="form-control" required>
								  	<option value="">--<?php echo lang('select')?> <?php echo lang('method')?>--</option>
									<option value="<?php echo lang('paypal')?>"><?php echo lang('paypal')?></option>
									<option value="<?php echo lang('stripe')?>"><?php echo lang('stripe')?></option>
									<option value="<?php echo lang('cash')?>"><?php echo lang('cash')?></option>
									<option value="<?php echo lang('cheque')?>"><?php echo lang('cheque')?></option>
								  </select>
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amount')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="amount" value="" class="form-control" required/>
                                </div>
                            </div>
                        </div>
						 
            
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
			</form>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

		
<?php if(isset($payments)):?>
<?php $i=1;
foreach ($payments as $new){
//$payment = $this->prescription_model->get_payment_by_id($new->id);
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit')?> <?php echo lang('payment')?></h4>
      </div>
      <div class="modal-body">
			 <div id="err_edit<?php echo $new->id?>">  
				<?php if(validation_errors()){?>
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
					<b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
				</div>
				<?php  } ?>  
			 </div>
			
			<form method="post" action="<?php echo site_url('admin/bookings/edit_payment/')?>" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $new->id?>" />
						<input type="hidden" name="order_id" value="<?php echo $new->order_id?>" />
			        <div class="box-body">
                      <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('order_number')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="showorder_no" value="<?php echo $booking->order_no;?>" disabled="disabled"  class="form-control " />
								</div>
                            </div>
                        </div>
					  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="invoice_no" value="<?php echo $new->invoice?>" readonly="readonly"  class="form-control invoice_no" required />
									
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('added_date')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="added_date" value="<?php echo $new->added_date?>" class="form-control datepicker" required/>
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_method')?></b>
								</div>
								<div class="col-md-8">
                                  <select name="payment_method" class="form-control" required>
								  	<option value="">--<?php echo lang('select')?> <?php echo lang('method')?>--</option>
									<option value="<?php echo lang('paypal')?>" <?php echo ($new->payment_method==lang('paypal'))?'selected="selected"':'';?> ><?php echo lang('paypal')?></option>
									<option value="<?php echo lang('stripe')?>" <?php echo ($new->payment_method==lang('stripe'))?'selected="selected"':'';?> ><?php echo lang('stripe')?></option>
									<option value="<?php echo lang('cash')?>" <?php echo ($new->payment_method==lang('cash'))?'selected="selected"':'';?> ><?php echo lang('cash')?></option>
									<option value="<?php echo lang('cheque')?>" <?php echo ($new->payment_method==lang('cheque'))?'selected="selected"':'';?> ><?php echo lang('cheque')?></option>
								  </select>
                                </div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amount')?></b>
								</div>
								<div class="col-md-8">
                                    <input type="text" name="amount" value="<?php echo $new->amount?>" class="form-control" required/>
                                </div>
                            </div>
                        </div>
						 
            
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary update_payment"><?php echo lang('update')?></button>
                    </div>
			</form>
			</div>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

  <?php $i++;}?>
<?php endif;?>
		

<?php if(isset($payments)):?>
<?php $i=1;
foreach ($payments as $new){
?>
<!-- Modal -->
<div class="modal fade" id="view<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('view')?> <?php echo lang('payment')?></h4>
      </div>
      <div class="modal-body">
			        <div class="box-body">
                      <div class="form-group" style="margin-top:20px;">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('order_number')?></b>
								</div>
								<div class="col-md-8">
                                   <?php echo $booking->order_no;?>
								</div>
                            </div>
                        </div>
					  <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('invoice_number')?></b>
								</div>
								<div class="col-md-8">
                                    <?php echo $new->invoice?>
								</div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('added_date')?></b>
								</div>
								<div class="col-md-8">
                                <?php echo date_convert($new->added_date);?>
								</div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('payment_method')?></b>
								</div>
								<div class="col-md-8">
                                <?php echo $new->payment_method;?>
								</div>
                            </div>
                        </div>
						 <div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('amount')?></b>
								</div>
								<div class="col-md-8">
                                    <?php echo $new->amount?>
                                </div>
                            </div>
                        </div>
						<div class="form-group">
                        	<div class="row">
                                <div class="col-md-3">
                                	<b><?php echo lang('created_on')?></b>
								</div>
								<div class="col-md-8">
                                    <?php echo date_time_convert($new->date_time)?>
                                </div>
                            </div>
                        </div>
						 
            
			</div>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

  <?php $i++;}?>
<?php endif;?>


<?php if(isset($payments)):?>
<?php $i=1;
foreach ($payments as $new){?>
<!-- Modal -->
<div class="modal fade" id="invoice<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('invoice')?> </h4>
      </div>
      <div class="modal-body">
			 <div class="box-body">
					
					<section class="content invoice" >
						<table width="100%" border="0"  id="print_inv<?php echo $new->id?>" class="bd" >
							<tr>
								<td>
									<table width="100%" style="border-bottom:1px solid #CCCCCC; padding-bottom:20px;">
										<tr>
											<td align="left">
											<img src="<?php echo base_url('assets/admin/uploads/images/'.$this->setting->logo) ?>"  height="70" width="80" />
											</td>
											<td align="right">
												<b><?php echo lang('invoice_number')?> : <?php echo $new->invoice ?></b><br />
												<b><?php echo lang('added_date')?>:</b> <?php echo date_convert($new->added_date);?><br />
												<b><?php echo lang('payment_method') ?>:</b> <?php echo $new->payment_method?><br/>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" style="border-bottom:1px solid #CCCCCC; padding-bottom:30px;">
										<tr>
											<td align="left" width="45%">
											<?php echo lang('payment_to') ?>
												 <address>
													<strong><?php echo $this->setting->name?></strong><br>
													<?php echo wordwrap($this->setting->address,50,"<br>\n");?><br>
													<?php echo lang('phone')?>: <?php echo $this->setting->phone?><br/>
													<?php echo lang('email')?>: <?php echo $this->setting->email?>
												  </address>			
											</td>
											<td width="10%"></td>
											<td align="right"width="45%" colspan="1"><?php echo lang('bill_to') ?><br />
												 <address>
													<strong><?php echo $booking->firstname?> <?php echo $booking->lastname?></strong><br>
													<?php echo $booking->guest_address?><br>
													<?php echo $booking->guest_city?> <?php echo $booking->guest_state?>, <?php echo $booking->guest_country?><br>
													<?php echo lang('phone')?>: <?php echo $booking->guest_phone?><br/>
													<?php echo lang('email')?>: <?php echo $booking->guest_email?>
												  </address>
										
											</td>
											
										</tr>
									</table>
								</td>
							</tr>
							<tr >
								<th align="left" style="padding-top:10px;"><?php echo lang('invoice_entries') ?></th>
							</tr>
							<tr>  
								<td>
									<table  width="100%" style="border:1px solid #CCCCCC;" >
										<tr>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="10%" align="left"><b>#</b></td>
											<td style="border-bottom:1px solid #CCCCCC; border-right:1px solid #CCCCCC"  width="75%" align="left"><b><?php echo lang('detail') ?></b></td>
											<td style="border-bottom:1px solid #CCCCCC;"  width="15%"><b><?php echo lang('amount') ?></b></td>
										</tr>
										<tr >
											 <td width="10%" style="border-right:1px solid #CCCCCC" >1</td>
											 <td width="75%" style="border-right:1px solid #CCCCCC"><?php echo lang('payment');?></td>
											 <td width="15%" ><?php echo @$new->amount?></td>
											
										</tr>
										<tr >
											 <td width="10%" style="border-right:1px solid #CCCCCC" ></td>
											 <td width="75%" style="border-right:1px solid #CCCCCC"><?php echo lang('total_amount');?></td>
											 <td width="15%" > <b><?php echo @$new->amount?></b></td>
											
										</tr>
									</table>
								</td>
							</tr>
						</table>
					<div class="row no-print" style="padding-top:10px;">
                        <div class="col-xs-12">
                            <button class="btn btn-default no-print" onclick="printData<?php echo $new->id?>()" ><i class="fa fa-print"></i> <?php echo lang('print') ?></button>
                          
                            <a href="<?php echo site_url('admin/invoice/pdf/'.@$details->id)?>"class="btn btn-primary pull-right hide" style="margin-right: 5px;"><i class="fa fa-download"></i> <?php echo lang('generate_pdf') ?></a>
							  <a href="<?php echo site_url('admin/invoice/mail/'.@$details->id)?>"class="btn btn-primary pull-right hide" style="margin-right: 5px;"><i class="fa fa-mail-forward"></i> <?php echo lang('mail_to_patient') ?></a>
                        </div>
                    </div>
					
					
					
                </section>        
				           
            
			</div>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>
<script>
function printData<?php echo $new->id?>()
{
   var divToPrint=document.getElementById("print_inv<?php echo $new->id?>");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}
</script>

  <?php $i++;}?>
<?php endif;?>
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>		
<script src="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.js"></script>			
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('.datepicker').datepicker({
      	todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
    });
});
$(function() {
	$('#responsiveTabsDemo').responsiveTabs({
    	startCollapsed: 'accordion'
	});
	$('#responsiveTabsDemo').responsiveTabs('activate', <?php echo $active;?>); // This would open the second tab
});
$( ".update_payment" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	call_loader();
	$.ajax({
		url: '<?php echo site_url('admin/bookings/edit_payment') ?>',
		type:'POST',
		data:$(form).serialize(),
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					//location.reload();
					location.href='<?php echo site_url('admin/bookings/booking/'.$booking->id.'/payment')?>';
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					remove_loader();
					$('#err_edit'+id).html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
});

$( "#booking_status" ).change(function( event ) {
	var val		=	$(this).val();
	call_loader();
	$.ajax({
		url: '<?php echo site_url('admin/bookings/booking_status') ?>',
		type:'POST',
		data:{status:val,id:<?php echo $booking->id?>},
		success:function(result){
		//alert(result);return false;
			  remove_loader();
			 toastr.success('Booking Staus Changed');
					
				
		 }
	  });
});


$( "#payment_status" ).change(function( event ) {
	
	var val		=	$(this).val();
	call_loader();
	$.ajax({
		url: '<?php echo site_url('admin/bookings/payment_status') ?>',
		type:'POST',
		data:{status:val,id:<?php echo $booking->id?>},
		success:function(result){
		//alert(result);return false;
			  remove_loader();
			 toastr.success('Payment Staus Changed');
		 }
	  });
});
</script>      