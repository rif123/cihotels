<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />

<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
				<li><?php echo lang('payment')?></li>
			</ul>
		</div>
		<div class="services-top-breadcrumbs-left">
			<h3><?php echo lang('payment')?></h3>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->


<div class="testimonials">
    <div class="container">
        <div class="row">
			<h3><span><?php echo lang('payment_for')?> : #<?php echo $booking->order_no?></span></h3>    
			<div class="panel-body margin-40-y">
			     <table class="table table-striped" id="example1">
					<thead class="header-panal">
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
        									<a class="btn btn-theme" href="#invoice<?php echo $new->id?>" data-toggle="modal"><i class="fa fa-list"></i> <?php echo lang('invoice')?></a>
        							</td>
        						</tr>
        				<?php $i++; endforeach;?>
        				<?php endif ?>
					</tbody>
				</table>
			</div>
	     </div>
    </div>
</div>
<?php if(isset($payments)):?>
<?php $i=1;
foreach ($payments as $new){?>
<!-- Modal -->
<div class="modal fade" id="invoice<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      
	  <div class="modal-header header-panal">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel" style="color:#FFFFFF"><?php echo lang('invoice')?> </h4>
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
	  
      <div class="modal-footer" style="background-color:rgba(0, 173, 138, 0.06);">
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
		


<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	
});

</script>
