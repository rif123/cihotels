<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />

<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
				<li><?php echo lang('payment')?></li>
			</ul>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->


<div class="testimonials">
    <div class="container">
        <div class="row">
			<h3><span><?php echo lang('payment')?></span></h3>
            <div class="panel panel-primary margin-40-y" >
    			<div class="panel-body">
                    <form method="post">
                        <table class="table table-striped table-hover">
        					<tr>
        						<th><?php echo lang('details')?></th>
        						<td><?php echo $booking['room_type']?>  <?php echo $booking['nights']?> Nights Booking From  <?php echo date_convert($booking['check_in'])?> to <?php echo date_convert($booking['check_out']);?></td>
        					</tr>
        					<tr>
        						<th><?php echo lang('total_amount')?></th>
        						<td><b><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo checkUserLogin(rate_exchange($booking['totalamount'])) ?> </b></td>
        					</tr>
        					<?php if(!empty($coupon_data)){?>
        						<tr>
        							<th><?php echo lang('coupon')?></th>
        							<td><b>- <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo checkUserLogin(rate_exchange($coupon_data['discount'])) ?> </b></td>
        						</tr>
        						<?php if(!empty($coupon_data['paid_service_applied'])){?>
        						<tr>
        							<th><?php echo lang('free_services')?></th>
        							<td><b>- <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo checkUserLogin(rate_exchange($coupon_data['services_total'])) ?> 	(<?php echo @$coupon_data['services']?>)</b></td>
        						</tr>
        						<?php } ?>
        						<tr>
        							<th><?php echo lang('amount_payable')?></th>
        							<td><b><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo checkUserLogin(rate_exchange($coupon_data['totalamount'])) ?>  </b></td>
        						</tr>
        					<?php } ?>
        					<tr>
        						<th><?php echo lang('advance_payment')?> - <?php echo $this->setting->advance_payment?>%</th>
        						<td><b><?php echo $this->session->userdata('currency_sybmol'); ?>  <?php echo checkUserLogin(rate_exchange(get_advance())) ?></b></td>
        					</tr>
        					<tr>
        						<th><?php echo lang('payment_method')?></th>
        						<td>
        						<?php if($this->setting->paypal==1){?>
        							<input type="radio" name="payment_gateway" value="1" /> <?php echo lang('paypal')?> 
        						<?php } ?>
        						<?php if($this->setting->stripe==1){?>
        							<input type="radio" name="payment_gateway" value="2" /> <?php echo lang('stripe')?> 
        						<?php } ?>
        						<?php if($this->setting->pay_on_arrival==1){?>
        							<input type="radio" name="payment_gateway" value="3" /> <?php echo lang('pay_on_arrival')?> 
        						<?php } ?>	
        						</td>
        					</tr>
                            <tr>
        						<th><?php echo lang('coupon')?></th>
        						<td>
                                    <div class="col-md-5 input-group">
                                      <input type="text" name="coupon" id="coupon" class="form-control"  placeholder='<?php echo lang('coupon')?>' autocomplete="off" />
                                      <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit" name="coupon_apply" value="<?php echo lang('apply')?>"><?php echo lang('apply')?></button>
                                      </span>
                                    </div>
                                </td>
        					</tr>
                            <tr>
                                <th></th>
                                <td>
                                    <div class="pull-right">
                                        <input type="submit" name="pay" value="<?php echo lang('pay')?>" class="btn btn-primary" />
                                    </div>
                                </td>
                            </tr>
        			    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>				
<script>
  $(document).ready(function() {
  	$('input[type="radio"],input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue',
          increaseArea: '20%' // optional
     });
	
   });


</script>