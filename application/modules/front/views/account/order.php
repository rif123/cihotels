<style>
@media print{
    .footer-section{
		display:none !important;
    }
	.print-hide,.btn-theme{
		display:none !important;
    }
	.panel{
		border:0px !important
	}
	 
}
.stl{text-decoration:line-through}
</style>

<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
				<li><?php echo lang('booking_summary')?></li>
			</ul>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->

<div class="testimonials">
    <div class="container">
        <div class="row">
			<h3><span><?php echo lang('order')?> - #<?php echo $order->order_no?></span></h3>
            <div class="panel panel-primary margin-40-y" >
                <div class="panel-heading" >
    	           <h4 class="panel-title" style="line-height: 35px;"> <?php echo lang('order')?> - #<?php echo $order->order_no?></h4>
                </div>
    			<div class="panel-body">
                    <form>
    			     <table class="table table-striped table-hover" id="printbooking" width="100%">
    					<tr >
    						<td colspan="4">
    							<table width="100%" >
    								<tr>
    									<td align="center">
    										<img src="<?php echo base_url('assets/admin/uploads/images/'.$this->setting->logo)?>" height="60" width="102" />
    									</td>
    								</tr>
    								<tr>
    									<td align="center">
    										<h2><?php echo $this->setting->name;?></h2>
    									</td>
    								</tr>
    								<tr>
    									<td align="center">
    										<h6><?php echo $this->setting->address;?></h6>
    									</td>
    								</tr>
    							</table>
    						</td>
    					</tr>
    					<tr>
    						<th class="col-md-2 col-sm-4 col-xs-4"><?php echo lang('order_number')?></th>
    						<td class="col-md-4 col-sm-4 col-xs-4"><?php echo $order->order_no?></td>
    						<th class="col-md-2 col-sm-4 col-xs-4"><?php echo lang('booking_date')?></th>
    						<td class="col-md-4 col-sm-4 col-xs-4"><?php echo date_time_convert($order->ordered_on)?></td>
    						
    					</tr>
    					
    					<tr>
    						<th ><?php echo lang('full_name')?></th>
    						<td ><?php echo $order->firstname?> <?php echo $order->lastname?></td>
    						<th ><?php echo lang('mobile')?></th>
    						<td ><?php echo $order->mobile?></td>
    					</tr>
    					<tr>
    						<th ><?php echo lang('check_in')?></th>
    						<td ><?php echo date_convert($order->check_in)?></td>
    						<th ><?php echo lang('check_out')?></th>
    						<td ><?php echo date_convert($order->check_out);?></td>
    					</tr>
    					
    					<tr>
    						<th ><?php echo lang('adults')?></th>
    						<td ><?php echo $order->adults?></td>
    						<th ><?php echo lang('kids')?></th>
    						<td ><?php echo $order->kids?></td>
    					</tr>
    					<tr>
    						<th ><?php echo lang('room_type')?></th>
    						<td ><?php echo $order->room_type?></td>
    						<th ><?php echo lang('nights')?></th>
    						<td ><?php echo $order->nights?></td>
    					</tr>
    					<tr>
    						<th ><?php echo lang('booking_status')?></th>
    						<td ><?php echo ($order->status==1)?lang('success'):''?> <?php echo ($order->status==2)?lang('canceled'):''?><?php echo ($order->status==0)?lang('pending'):'';?></td>
    						<th ><?php echo lang('payment_status')?></th>
    						<td >
    							<?php echo ($order->payment_status==1)?lang('success'):''?> <?php echo ($order->payment_status==2)?lang('pending'):''?><?php echo ($order->payment_status==0)?lang('failed'):'';?> <?php echo ($order->payment_status==3)?lang('partialy_paid'):'';?>
    						</td>
    					</tr>
    					<tr>
    						<th ><?php echo lang('price_per_night')?></th>
    						<td  colspan="3">
    							<table width="100%" border="0">
    										<tr>
    											<th>#</th>
    											<th><?php echo lang('date');?></th>
    											<td align="right"><b><?php echo lang('price');?></b></td>
    											 <?php if($order->additional_person > 0){?>
    											<td align="center"><b><?php echo lang('addi_person');?></b></td>
    											<td><b><?php echo lang('total')?></b></td>
    											<?php } ?>
    											
    										</tr>
    									<?php $i=1;foreach($prices as $new){?>
    										<tr>
    											<td><?php echo $i?>.</td>
    											<td><?php echo date_convert($new->date)?></td>
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
    						<th ><?php echo lang('amount')?></th>
    						<td  colspan="3"><?php echo $order->cs?> <?php echo rate_exchange_order($order->amount,$order->currency_unit);?></td>
    					</tr>
    					<tr>
    						<th ><?php echo lang('taxes')?></th>
    						<td  colspan="3">
    								
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
    						<th ><?php echo lang('paid_services')?></th>
    						<td  colspan="3">
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
    						<th ><?php echo lang('coupon')?></th>
    						<th  id="grand_total" colspan="3">-<?php echo $order->cs?> <?php echo rate_exchange_order($order->coupon_discount,$order->currency_unit);?></th>
    					</tr>
    					<?php } ?>
    					<?php if($order->free_paid_services_amount > 0){?>
    						<tr>
    							<th ><?php echo lang('free_services')?></th>
    							<td  colspan="3">	<b>-<?php echo $order->cs?>  <?php echo rate_exchange_order($order->free_paid_services_amount,$order->currency_unit)?> 	(<?php echo @$order->free_paid_services_title?>)</b></td>
    						</tr>
    					<?php } ?>
    					<tr>
    						<th ><?php echo lang('total_amount')?></th>
    						<th  id="grand_total" colspan="3"><?php echo $order->cs?> <?php echo rate_exchange_order($order->totalamount,$order->currency_unit);?></th>
    					</tr>
    					<tr>
    						<th ><?php echo lang('advance_payment')?></th>
    						<th  colspan="3"><?php echo $order->cs?> <?php echo rate_exchange_order($order->advance_amount,$order->currency_unit);?></th>
    					</tr>
    				  </table>
    					<div class="row">
    						<div class="col-md-12">
                                <div class="pull-right">
        							<button type="submit" id="print" class="btn btn-primary"><?php echo lang('print')?></button>
        							<a href="<?php echo site_url('front/account/pdf/'.$order->id)?>" class="btn btn-primary"> <i class="fa fa-download"></i> <?php echo lang('download')?></a>
                                </div>
    						</div>
    					</div>
    			</div>
            </div>
	     </div>
    </div>
</div>

<script>
function printData()
{
   var divToPrint=document.getElementById("printbooking");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
}

$('#print').on('click',function(){
printData();
})

</script>