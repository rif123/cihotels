<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
				<li><?php echo lang('cancel_booking')?></li>
			</ul>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->


<div class="testimonials">
    <div class="container">
        <div class="row">
			<h3><span><?php echo lang('cancel_booking')?></span></h3>
            <div class="panel panel-primary margin-40-y" >
    			<div class="panel-body">
                    <form method="post" enctype="multipart/form-data">
			             <div class="form-group">
                            <div class="row">
								<div class="col-md-12">
									<label><?php echo lang('cancellation_policy') ?></label>
									<?php echo $this->setting->cancellation_policy;?>
								</div>
                            </div>		
                         </div>
			             <div class="form-group">
                            <div class="row">
			                    <div class="col-md-12">
                                    <input class="btn btn-primary" type="submit" value="<?php echo lang('cancel_confirm')?>" name="cancel"/>
								</div>
							</div>
                         </div>	
					</form>	
                </div>
            </div>
        </div>
    </div>
</div>
