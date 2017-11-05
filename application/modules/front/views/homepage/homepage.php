
<?php $this->load->view('front/template/includes/home_page_banners');?>
<style>
.list ul li {
    display: inline-block;
    letter-spacing: 0.2px;
    line-height: 1em;
    font-size: 0.95em;
    color: #222;
    padding: 5px;
	width:100% !important;
}
</style>
	<div class="content">
        
 
<!-- special-services -->
<div class="special-services">
	<div class="container">
		<h3><span><?php echo $this->setting->content_section_title?></span></h3>
		<p class="autem"><?php echo $this->setting->content_section_description?></p>
		<div class="special-services-grids">
            <?php 
            $i=0;
            foreach($room_types as $rt):
            $rt_image = get_room_type_featured_image($rt->id);
            ?>            	
			<div class="col-md-3 special-services-grid">
				<div class="special-services-grid1">
					<img src="<?php echo $rt_image; ?>" alt="<?php echo $rt->title?>" class="img-responsive" />
				</div>
				<h4 class="text-center"><a href="<?php echo site_url('rooms/'.$rt->slug)?>"><?php echo $rt->title?></a></h4>
			</div>
            <?php 
            $i++;
            if($i%4 == 0) :
			     echo ' <div class="clearfix"></div>
                        </div>
			            <div class="special-services-grids">';
		    endif;
	        endforeach; 
			?>
		</div>
	</div>
</div>


<!-- special-services -->
<?php if(!empty($coupons)){?>
<div class="special-services">
	<div class="container">
		<h3><span><?php echo lang('latest_deals')?></span></h3>
		<p class="autem"><?php echo $this->setting->content_section_description?></p>
		<div class="special-services-grids">
            <div id="owl-demo" class="owl-carousel">
    		     <?php foreach($coupons as $cp){	$services	=	get_coupon_paid_services($cp->id);?>	
    			    <div class="item">
    		           <div class="col-md-4 cap-img">
    						<img src="<?php echo base_url('assets/admin/uploads/coupons/'.$cp->image)?>" class="img-responsive offer-image gray" alt=""/>
    					</div>
    					<div class="col-md-8 offer-description">
    						<h4><?php echo $cp->title?></h4>	
    						<ul class="list-inline text-uppercase">
    							<li><i class="glyphicon glyphicon-credit-card"></i> <b><?php echo lang('use_coupon');?> :</b> <?php echo $cp->code; ?></li>
    							<li> <b><i> <?php echo $this->session->userdata('currency_sybmol')?></i></b>  <b><?php echo lang('min_amount');?> :</b> <?php echo $cp->min_amount; ?></li>
    							<li><b><i> <?php echo $this->session->userdata('currency_sybmol')?></i></b> <b><?php echo lang('max_amount');?> :</b> <?php echo $cp->max_amount; ?></li>
    						</ul>										
    						<p><?php echo substr($cp->description,0,400)?></p>
    						<div class="row">
    							<div class="col-md-9 deatils-left">
    								<?php if(!empty($services)){?>
    								<div class="coupon-list">
    									<h5 style="margin: 10px 0;"><strong>Free Paid Services</strong></h5>
    									<ul class="list-inline">
    										<?php foreach($services as $serv){?>
    										<li><i class="glyphicon glyphicon-hand-right"></i> <?php echo $serv->title?></li>
    										<?php } ?>
    									</ul>
    								</div>
    								<?php } ?>
    							</div>
    							<div class="col-md-3 deatils-right">
                                    <div class="discount alizarin">
                                        <?php echo ($cp->type=='Fixed')?$this->session->userdata('currency_sybmol'):''?> <?php echo $cp->value?> <?php echo ($cp->type=='Percentage')?'%':''?>
                                    
                                    </div>
    							</div>
    							<div class="clearfix"> </div>
    						</div>
    					</div>
    		            <div class="clearfix"> </div>
    		        </div>
    		        <?php } ?>
    	        </div>
		</div>
	</div>
</div>
<?php } ?>


 
<!-- testimonials -->
<div class="testimonials">
	<div class="container">
		<h3><span><?php echo lang('testimonials')?></span></h3>
		<p class="autem">maiores alias consequatur aut perferendis doloribus asperiores repellat</p>
		<div class="testimonials-grids">
			<div class="col-md-12 testimonials-grid-left">
				<div class="wmuSlider example1 animated wow slideInUp" data-wow-delay=".5s">
					<div class="wmuSliderWrapper">
                        <?php 
				        $i=0;
				        foreach($testimonials as $test):
				        ?> 
						<article style="position: absolute; width: 100%; opacity: 0;"> 
							<div class="banner-wrap">
								<div class="testimonials-grid-left-grid">
									<div class="col-md-2 testimonials-grid-left1">
										<img src="<?php echo base_url('assets/admin/uploads/images/'.$test->auther_image)?>" alt=" " class="img-circle img-responsive" width="155" />
									</div>
									<div class="col-md-10 testimonials-grid-left2">
										<h4>
                                            <strong><?php echo $test->title?></strong>
                                            <br />
                                            <?php echo $test->testimonial?> - <i><?php echo $test->auther_name?></i></h4>
										<p>
                                            <?php 
                                            if (strpos($test->rating,'.') !== false) {
												for($j=1;$j<=intval($test->rating);$j++){
													echo '<i class="fa fa-star"></i>';
												}
												echo '<i class="fa fa-star-half-o"></i>';
											}else {
												for($j=1;$j<=intval($test->rating);$j++){
													echo '<i class="fa fa-star"></i>';
												}
											}
									        ?>	
                                        </p>
									</div>
									<div class="clearfix"> </div>
								</div>
							</div>
						</article>
                        <?php 
                        $i++;
						if($i%2 == 0) :
						  echo ' <div class="clearfix"></div>
			                     </div>
				                 <div class="testimonial-grids test2">';
					    endif;
						endforeach; 
				        ?>	
					</div>
				</div>
			 </div>
		   <div class="clearfix"> </div>
		</div>
	</div>
</div>
<!-- //testimonials -->
<script src="<?php echo base_url('assets/front')?>/js/jquery.wmuSlider.js"></script> 
<script type="text/javascript">
	$('.example1').wmuSlider();         
</script>