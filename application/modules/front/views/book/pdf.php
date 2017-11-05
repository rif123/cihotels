<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>#<?php echo $order->order_no?></title>
<style>
.stl{text-decoration:line-through}
</style>
</head>

<body>


	<table class="table" border="1" id="printbooking" width="100%">
							<tr  class="success">
								<td colspan="4">
									<table width="100%" cellpadding="0" cellspacing="0" >
										<tr>
											<td align="center">
												<img src="<?php echo base_url('assets/admin/uploads/images/'.$this->setting->logo)?>" height="60" width="102" />
											</td>
										</tr>
										<tr>
											<td align="center">
												<b style="font-size:24px"><?php echo $this->setting->name;?></b>
											</td>
										</tr>
										<tr>
											<td align="center">
												<b style="font-size:16px"><?php echo $this->setting->address;?></b>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<th class="success col-md-2 col-sm-4 col-xs-4"><?php echo lang('order_number')?></th>
								<td class="table-active col-md-4 col-sm-4 col-xs-4"><?php echo $order->order_no?></td>
								<th class="success col-md-2 col-sm-4 col-xs-4"><?php echo lang('booking_date')?></th>
								<td class="table-active col-md-4 col-sm-4 col-xs-4"><?php echo date_time_convert($order->ordered_on)?></td>
								
							</tr>
							
							<tr>
								<th class="success"><?php echo lang('full_name')?></th>
								<td class="table-active"><?php echo $order->firstname?> <?php echo $order->lastname?></td>
								<th class="success"><?php echo lang('mobile')?></th>
								<td class="table-active"><?php echo $order->mobile?></td>
							</tr>
							<tr>
								<th class="success"><?php echo lang('check_in')?></th>
								<td class="table-active"><?php echo date_convert($order->check_in)?></td>
								<th class="success"><?php echo lang('check_out')?></th>
								<td class="table-active"><?php echo date_convert($order->check_out);?></td>
							</tr>
							
							<tr>
								<th class="success"><?php echo lang('adults')?></th>
								<td class="table-active"><?php echo $order->adults?></td>
								<th class="success"><?php echo lang('kids')?></th>
								<td class="table-active"><?php echo $order->kids?></td>
							</tr>
							<tr>
								<th class="success"><?php echo lang('room_type')?></th>
								<td class="table-active"><?php echo $order->room_type?></td>
								<th class="success"><?php echo lang('nights')?></th>
								<td class="table-active"><?php echo $order->nights?></td>
							</tr>
							<tr>
								<th class="success"><?php echo lang('booking_status')?></th>
								<td class="table-active"><?php echo ($order->status==1)?lang('success'):''?> <?php echo ($order->status==2)?lang('canceled'):''?><?php echo ($order->status==0)?lang('pending'):'';?></td>
								<th class="success"><?php echo lang('payment_status')?></th>
								<td class="table-active">
									<?php echo ($order->payment_status==1)?lang('success'):''?> <?php echo ($order->payment_status==2)?lang('pending'):''?><?php echo ($order->payment_status==0)?lang('failed'):'';?> <?php echo ($order->payment_status==3)?lang('partialy_paid'):'';?>
								</td>
							</tr>
							<tr>
								<th class="success"><?php echo lang('price_per_night')?></th>
								<td class="table-active" colspan="3">
									 <?php if($order->additional_person > 0){
									 		$width	=	'100%';
											}else{
											$width	=	'40%';	
											}
									?> 
									<table width="<?php echo $width?>" border="0">
												<tr>
													<th align="left">#</th>
													<td align="center"><b><?php echo lang('date');?></b></td>
													<td align="right"><b><?php echo lang('price');?></b></td>
													 <?php if($order->additional_person > 0){?>
													<td align="center"><b><?php echo lang('addi_person');?></b></td>
													<td><b><?php echo lang('total')?></b></td>
													<?php } ?>
													
												</tr>
											<?php $i=1;foreach($prices as $new){?>
												<tr>
													<td><?php echo $i?>.</td>
													<td align="center"><?php echo date_convert($new->date)?></td>
													<td align="right"><?php echo $order->cs?>  <?php echo rate_exchange_order($new->price,$order->currency_unit)?></td>
													 <?php if($order->additional_person > 0){?>
													<td align="center"><?php echo $new->additional_person; ?> &times; <?php echo rate_exchange_order($new->additional_person_price,$order->currency_unit); ?> = <?php echo $order->cs?>	<?php echo $new->additional_person * rate_exchange_order($new->additional_person_price,$order->currency_unit)?></td>
													<td>  <?php echo $order->cs?>	<?php echo rate_exchange_order($new->total,$order->currency_unit)?></td>
													<?php } ?>
													
												</tr>
												<?php $i++;}?>
												<tr>
													<td></td>
													<td align=""><b><?php echo lang('total_price')?></b></td>
													<td align="right"> <b> <?php echo $order->cs?>	<?php echo rate_exchange_order($order->amount	-	 $order->additional_person_amount,$order->currency_unit)?></b></td>
													<?php if($order->additional_person > 0){?>
													<td align="center"><b> <?php echo $order->cs?> <?php echo rate_exchange_order($order->additional_person_amount,$order->currency_unit)?></b></td>
													<td><b><?php echo $order->cs?> <?php echo rate_exchange_order($order->amount,$order->currency_unit);?></b></td>
													<?php }?>
												</tr>
											</table>
								</td>
							</tr>
							<tr>
								<th class="success"><?php echo lang('amount')?></th>
								<td class="table-active" colspan="3"><?php echo $order->cs?> <?php echo rate_exchange_order($order->amount,$order->currency_unit);?></td>
							</tr>
							<tr>
								<th class="success"><?php echo lang('taxes')?></th>
								<td class="table-active" colspan="3">
										
											<table width="100%" border="0">
											<?php $i=1;foreach($taxes as $t){?>
												<tr>
													<td ><?php echo $i?>.</td>
													<td><?php echo $t->name?></td>
													<td><?php echo ($t->type=='Fixed')?'$':''?><?php echo $t->rate?> <?php echo ($t->type=='Percentage')?'%':''?></td>
													<td>= <?php echo $order->cs?> <?php echo rate_exchange_order($t->amount,$order->currency_unit);?></td>
												</tr>
												<?php $i++;}?>
												<tr>
													<td></td>
													<td colspan="2" align=""><b><?php echo lang('total_tax')?></b></td>
													<td>= <b><?php echo $order->cs?> <?php echo rate_exchange_order($order->taxamount,$order->currency_unit);?></b></td>
												</tr>
											</table>
								</td>
							</tr>
							<?php if(!empty($services)){?>
							<tr>
								<th class="success"><?php echo lang('paid_services')?></th>
								<td class="table-active" colspan="3">
									<table width="100%" >
										<?php $i=1;foreach($services as $serv){
										 	$fs	=	json_decode($order->free_paid_services);
											$stl	=	'';
											if(!empty($fs)){
												$stl		=	(in_array($serv->id,$fs))?'stl':'';
											}
										?>
										<tr>
											<td><?php echo $i;?></td>
											<td><?php echo $serv->title?></td>
											<td class="<?php echo $stl?>">&nbsp; <?php echo $order->cs?> <?php echo rate_exchange_order($serv->amount,$order->currency_unit);?></td> 
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
											<?php if($order->free_paid_services_amount > 0){?>
											<td> <b> &nbsp; <?php echo $order->cs?> <?php echo rate_exchange_order($order->paid_service_amount-$order->free_paid_services_amount ,$order->currency_unit);?></b></td>
											<?php } else	{?>
											<td> <b> &nbsp; <?php echo $order->cs?> <?php echo rate_exchange_order($order->paid_service_amount,$order->currency_unit);?></b></td>
											<?php } ?>
										</tr>
									</table>	
								</td>
							</tr>
							<?php } ?>
							<?php if(!empty($order->coupon)){?>
							<tr>
								<th class="success"><?php echo lang('coupon')?></th>
								<th class="table-active" id="grand_total" colspan="3">-<?php echo $order->cs?> <?php echo rate_exchange_order($order->coupon_discount,$order->currency_unit);?></th>
							</tr>
							<?php } ?>
							<?php if($order->free_paid_services_amount > 0){?>
								<tr>
									<th class="success"><?php echo lang('free_services')?></th>
									<td class="table-active" colspan="3">	<b>-<?php echo $order->cs?>  <?php echo rate_exchange_order($order->free_paid_services_amount,$order->currency_unit)?> 	(<?php echo @$order->free_paid_services_title?>)</b></td>
								</tr>
							<?php } ?>
							<tr>
								<th class="success"><?php echo lang('total_amount')?></th>
								<th class="table-active" id="grand_total" colspan="3"><?php echo $order->cs?> <?php echo rate_exchange_order($order->totalamount,$order->currency_unit);?></th>
							</tr>
							<tr>
								<th class="success"><?php echo lang('advance_payment')?></th>
								<th class="table-active" colspan="3"><?php echo $order->cs?> <?php echo rate_exchange_order($order->advance_amount,$order->currency_unit);?></th>
							</tr>
						  </table>
</body>
</html>
