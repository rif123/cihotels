<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/guests') ?>"><?php echo lang('guests')?></a></li>
            <li class="active"><?php echo lang('view')?> <?php echo lang('guest')?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					<div id="responsiveTabsDemo">
						<ul>
							<li><a href="#tab-1"> <?php echo lang('details')?> </a></li>
							<li><a href="#tab-2"> <?php echo lang('orders')?></a></li>
							<li><a href="#tab-3"> <?php echo lang('payment')?></a></li>
						</ul>
					
						<div id="tab-1"> 
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('name')?></label>
									</div>
									<div class="col-md-6">
										<?php echo $guest->firstname?> <?php echo $guest->lastname?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('gender')?></label>
									</div>
									<div class="col-md-6">
										<?php echo ($guest->gender==1)?lang('male'):'';?> <?php echo ($guest->gender==2)?lang('female'):'';?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('dob')?></label>
									</div>
									<div class="col-md-6">
										<?php echo date_convert($guest->dob);?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('email')?></label>
									</div>
									<div class="col-md-6">
										<?php echo $guest->email;?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('mobile')?></label>
									</div>
									<div class="col-md-6">
										<?php echo $guest->mobile;?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('address')?></label>
									</div>
									<div class="col-md-6">
										<?php echo $guest->address;?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('city')?></label>
									</div>
									<div class="col-md-6">
										<?php echo $guest->city;?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('region')?></label>
									</div>
									<div class="col-md-6">
										<?php echo $guest->state;?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('country')?></label>
									</div>
									<div class="col-md-6">
										<?php echo $guest->country;?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('id')?></label>
									</div>
									<div class="col-md-3">
										<?php echo $guest->id_type;?>
									</div>	
									<div class="col-md-2">
									<?php if(!empty($guest->id_upload)){?>
										<a href="<?php echo base_url('assets/admin/uploads/ids/'.$guest->id_upload); ?>" download class="btn btn-default"> <i class="fa fa-download"></i> <?php echo lang('download')?></a>
									<?php } ?>
									</div>
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('vip')?></label>
									</div>
									<div class="col-md-6">
										<?php echo ($guest->vip==1)?lang('yes'):'';?> <?php echo ($guest->gender==2)?lang('no'):'';?>
									</div>	
								  </div>		
								</div>
						
						 </div>
						<div id="tab-2"> 
							<table class="table table-striped" id="example1">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('booking_number'); ?></th>
									<th><?php echo lang('room'); ?></th>
									<th><?php echo lang('check_in'); ?></th>
									<th><?php echo lang('check_out'); ?></th>
									<th><?php echo lang('booking_date'); ?></th>
									<th><?php echo lang('payment_status'); ?></th>
									<th class="col-md-2"><?php echo lang('booking_status'); ?></th>
								</tr>
							</thead>
							
							<tbody style="cursor:pointer">
						<?php if($bookings):?>		
						<?php $i=1;foreach ($bookings as $new):?>
								<tr>
									<td id="<?php echo $new->id?>"><?php echo $i;?></td>
									<td id="<?php echo $new->id?>" class="gc_cell_left" ><?php echo  $new->order_no; ?></td>
									<td id="<?php echo $new->id?>"><?php echo $new->room?></td>
									<td id="<?php echo $new->id?>"><?php echo date_convert($new->check_in)?></td>
									<td id="<?php echo $new->id?>"><?php echo date_convert($new->check_out)?></td>
									<td id="<?php echo $new->id?>"><?php echo date_time_convert($new->ordered_on);?></td>
									<td id="<?php echo $new->id?>"><?php echo ($new->payment_status==1)?lang('success'):''?> <?php echo ($new->payment_status==2)?lang('pending'):''?><?php echo ($new->payment_status==0)?lang('failed'):'';?> <?php echo ($new->payment_status==3)?lang('partialy_paid'):'';?></td>
									<td id="<?php echo $new->id?>"><?php echo ($new->status==1)?lang('success'):''?> <?php echo ($new->status==2)?lang('canceled'):''?><?php echo ($new->status==0)?lang('pending'):'';?> </td>
								</tr>
						<?php $i++; endforeach;?>
						<?php endif?>
							</tbody>
						</table>

						
						</div>
						<div id="tab-3">
							<table class="table table-striped" id="example2">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('date'); ?></th>
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
										
											</div>
									</td>
								</tr>
						<?php $i++; endforeach;?>
						<?php endif ?>
							</tbody>
						</table>

						
						</div>
					</div>
					
					
					
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
		

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
												<b><?php echo lang('payment_date')?>:</b> <?php echo date_convert($new->added_date);?><br />
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
													<strong><?php echo $new->firstname?> <?php echo $new->lastname?></strong><br>
													<?php echo $new->guest_address?><br>
													<?php echo $new->guest_city?> <?php echo $new->guest_state?>, <?php echo $new->guest_country?><br>
													<?php echo lang('phone')?>: <?php echo $new->guest_phone?><br/>
													<?php echo lang('email')?>: <?php echo $new->guest_email?>
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
		

		
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1,#example2').dataTable({
	});
	
});
$(function() {
	$('#responsiveTabsDemo').responsiveTabs({
    	startCollapsed: 'accordion'
	});
	
});
$("#example1 tbody td").on('click',function() {   
    var id = $(this).attr('id');
   //alert(id);return false;
    if(id){
		document.location.href = "<?php echo site_url('admin/bookings/booking/')?>" + id;       
	}
}); 
</script>