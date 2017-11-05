<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>/js/datepicker3.css">  
<link href="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.css" rel="stylesheet" type="text/css" media="all" />
<style>
.datepicker table tr td.disabled, .datepicker table tr td.disabled:hover {
    background: #CCCCCC;
    color: #444;
    cursor: default;
}
</style> 
<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/bookings') ?>"> <?php echo lang('bookings')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					<div class="box-header">
					  <h3 class="box-title"><?php echo lang('make_reservation'); ?></h3>
					</div><!-- /.box-header -->
				<form method="post"   enctype="multipart/form-data" id="add_form" >	
					<table class="table table-striped ">
						<tr>
											<th class="success"><?php echo lang('details')?></th>
											<td class="table-active"><?php echo $booking['room_type']?>  <?php echo $booking['nights']?> Nights Booking From  <?php echo date('d/m/Y', strtotime($booking['check_in']))?> to <?php echo date('d/m/Y', strtotime($booking['check_out']));?></td>
										</tr>
										<tr>
											<th class="success"><?php echo lang('total_amount')?></th>
											<td class="table-active"><b><?php echo $this->setting->currency_symbol; ?> <?php echo rate_exchange($booking['totalamount'])?> </b></td>
										</tr>
					
						<tr>
							<th class="success"><?php echo lang('coupon')?></th>
							<th class="table-active">
								<table>
									<tr>
										<td><input type="text" name="coupon" id="coupon"  placeholder='<?php echo lang('coupon')?>' autocomplete="off" class="form-control" style="width:80%" /></td>
										<td><button type="submit" name="coupon_apply" id="coupon_apply" value="coupon_apply" class="btn btn-success"><?php echo lang('apply')?></button></td>
									</tr>
								</table>
								
							</th>
						</tr>
						<?php if(!empty($coupon_data)){?>
											<tr>
												<th class="success"><?php echo lang('coupon_applied')?></th>
												<td class="table-active"><b>- <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($coupon_data['discount'])?> </b></td>
											</tr>
											<?php if(!empty($coupon_data['paid_service_applied'])){?>
											<tr>
												<th class="success"><?php echo lang('free_services')?></th>
												<td class="table-active"><b>- <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($coupon_data['services_total'])?> 	(<?php echo @$coupon_data['services']?>)</b></td>
											</tr>
											<?php } ?>
											<tr>
												<th class="success"><?php echo lang('amount_payable')?></th>
												<td class="table-active"><b><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($coupon_data['totalamount'])?>  </b></td>
											</tr>
										<?php } ?>
										
					</table>	
					
					<div class="class="box-footer"">
							<input class="btn btn-primary" type="submit" value="Book" name="book" />
					</div>
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>		
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>	
<script src="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.js"></script>		
