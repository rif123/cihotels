<!-- breadcrumbs -->
	<div class="services-top-breadcrumbs">
		<div class="container">
			<div class="services-top-breadcrumbs-right">
				<ul>
					<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
					<li><?php echo lang('rooms_rates')?></li>
				</ul>
			</div>
			<div class="services-top-breadcrumbs-left">
				<h3><?php echo lang('rooms_rates')?></h3>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //breadcrumbs -->

<div class="rooms-rates">
    <div class="container">
        <div class="testimonials text-center">
             <?php 
             $i=0;
             foreach($room_types as $rt):
             $rt_image	=	get_room_type_featured_image_medium($rt->id);
             $amenities	=	$this->homepage_model->get_amenities($rt->id);
             ?>
			 <div class="col-md-4 room-sec">
                 <form method="get" action="<?php echo site_url('front/book/index')?>">
					<input type="hidden" name="date_from" value="<?php echo @$_GET['date_from']?>" />
					<input type="hidden" name="date_to" value="<?php echo @$_GET['date_to']?>" />
					<input type="hidden" name="adults" value="<?php echo @$_GET['adults']?>" />
					<input type="hidden" name="kids" value="<?php echo @$_GET['kids']?>" />
					<input type="hidden" name="room_type" value="<?php echo $rt->id?>" />
                    <img src="<?php echo $rt_image?>" alt="" class="img-responsive" />
				    <h4><a href="<?php echo site_url('rooms/'.$rt->slug)?>"><?php echo $rt->title?></a></h4>
                    <p><?php echo substr($rt->description,0,200)?></p>
                    <ul class="items list-inline">
                        <?php foreach($amenities as $am):?>
							<li><img src="<?php echo base_url('assets/admin/uploads/amenities/'.$am->image)?>" class="img-responsive gray" width="25" title="<?php echo $am->name?>" data-toggle="tooltip"/></li>
						<?php endforeach; ?>	
   				    </ul>
                    <h4 class="text-uppercase"><em><?php echo lang('from')?> <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($rt->base_price)?> <span class="small"> / <?php echo lang('night')?></span></em></h4>
                    <div class="keywords">	
			   	         <input type="submit" name="search" value="<?php echo lang('book_now');?>" onclick="this.form.submit"/>
        			</div>
				</form>
			 </div>
             <?php 
             $i++;
			 if($i%3 == 0) :
			   echo ' <div class="clearfix"></div>
                     </div>
	                 <div class="testimonials text-center">';
		     endif;
			 endforeach; 
             ?>
             <div class="clearfix"></div>
		 </div>
    </div>
</div>