<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
				<li><?php echo lang('payment_from_stripe')?></li>
			</ul>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->


<div class="testimonials">
    <div class="container">
        <div class="row">
			<h3><span><?php echo lang('payment_from_stripe')?></span></h3>
            <div class="panel panel-primary margin-40-y" >
    			<div class="panel-body">
                    <form action="<?php echo site_url('front/book/stripe')?>" method="POST">	
						<script
						src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						data-key="<?php echo $this->setting->stripe_key?>"
						data-image="<?php echo base_url().'assets/admin/uploads/images/'.$this->setting->logo?>"
						data-name="<?php echo $this->setting->name?>"
						data-description="<?php echo $booking_data['room_type']?>"
						data-amount="<?php echo rate_exchange($booking_data['advance_amount'])*100?>"
						data-currency="<?php echo $booking_data['currency']?>">
					  </script>
					</form>	
                </div>
            </div>
        </div>
    </div>
</div>            
<script>
$(document).ready(function() {
  	//call_loader();
	setTimeout(function(){ 
		//$('form').submit();
	}, 3000);
});
</script>