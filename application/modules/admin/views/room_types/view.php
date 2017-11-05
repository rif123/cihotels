  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/room_types') ?>"> <?php echo lang('room_types')?> </a></li>
            <li class="active"><?php echo lang('view');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('title') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php echo $room_type->title?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('slug') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php echo $room_type->slug?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('shortcode') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php echo $room_type->shortcode?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('description') ?></label>
                      	</div>
						<div class="col-md-4">	
							<?php echo $room_type->description?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('base_occupancy') ?></label>
                      	</div>
						<div class="col-md-4">
						<?php echo $room_type->base_occupancy?>
							
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('higher_occupancy') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php echo $room_type->higher_occupancy?>
								
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('extra_bed') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php echo $room_type->extra_beds?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('kids_occupancy') ?></label>
                      	</div>
						<div class="col-md-4">
						<?php echo $room_type->kids_occupancy?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('amenities') ?></label>
                      	</div>
						<div class="col-md-10">
							<?php echo $room_type->ams ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('base_price') ?></label>
                      	</div>
						<div class="col-md-4">
						<?php echo $room_type->base_price?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('additional_person') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php echo $room_type->additional_person?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-2">
                      		<label><?php echo lang('extra_bed_price') ?></label>
                      	</div>
						<div class="col-md-4">
							<?php echo $room_type->extra_bed_price?>
						</div>	
					  </div>		
                    </div>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
